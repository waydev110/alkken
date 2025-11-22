
<?php
    // ===================================================
    // BONUS CALCULATION MODULE
    // This file is included from member_create.php
    // All parent variables are available here
    // ===================================================

    // Load only used models
    require_once '../../../model/classBonusSponsorMonoleg.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classBonusUpline.php';
    require_once '../../../model/classPlan.php';

    // Initialize only used class instances
    $cksm = new classBonusSponsorMonoleg();
    $ckg = new classBonusGenerasi();
    $cku = new classBonusUpline();
    $cpl = new classPlan();
    
    // Array to store SMS notifications (will be sent after commit)
    $sms_queue = [];

    // ===================================================
    // EXTRACT BONUS VARIABLES FROM PIN OBJECT
    // ===================================================
    $current_kode_aktivasi = $kode_aktivasi;
    $jumlah_hu = $pin->jumlah_hu;
    $poin_reward = $pin->poin_reward;
    $harga = $pin->harga;
    $bonus_sponsor = $pin->bonus_sponsor;
    $bonus_generasi = $pin->bonus_generasi;
    $bonus_upline = $pin->bonus_upline;
    $bonus_cashback = $pin->bonus_cashback;
    $bonus_sponsor_monoleg = $pin->bonus_sponsor_monoleg;
    $bonus_poin_cashback = $pin->bonus_poin_cashback;
    $pasangan = $pin->pasangan;
    $parent_pasangan = $pin->parent_pasangan;
    $pasangan_level = $pin->pasangan_level;
    $parent_pasangan_level = $pin->parent_pasangan_level;
    $reward = $pin->reward;
    $reward_sponsor = $pin->reward_sponsor;
    $parent_reward = $pin->parent_reward;
    $parent_reward_sponsor = $pin->parent_reward_sponsor;
    $promo_reward_sponsor = $pin->promo_reward_sponsor;
    $poin_reward_promo = $pin->poin_reward_promo;
    $fee_founder = $pin->fee_founder;
    $tingkat = $pin->tingkat;
    $nama_plan = $pin->nama_plan;
    $nama_plan_produk = $pin->nama_plan . ' ' . $pin->name;
    $reward_wajib_ro = $pin->reward_wajib_ro;
    $saldo_wd = $pin->saldo_wd;
    $nominal_balik_modal = $pin->nominal_balik_modal;
    $keterangan_saldo_wd = 'Penambahan Saldo Transfer Bonus sebesar ' . rp($saldo_wd) . ' dari paket ' . $nama_plan;

    // ===================================================
    // START BONUS PROCESSING
    // ===================================================

    // Update aktivasi
    $current_operation = 'Update Status Aktivasi PIN';
    $update_aktivasi_sql = "UPDATE mlm_kodeaktivasi SET status_aktivasi = '1', updated_at = '$created_at' WHERE id = '$id_kodeaktivasi'";
    $conn->_query_transaction($update_aktivasi_sql);

    // Create history
    $current_operation = 'Membuat History Aktivasi';
    $create_history_sql = "INSERT INTO mlm_kodeaktivasi_history (id_kodeaktivasi, id_member, jenis_aktivasi, created_at) 
                              VALUES ('$id_kodeaktivasi', '$member_id', '$id_plan', '$created_at')";
    $conn->_query_transaction($create_history_sql);

    // === STEP 3: BONUS BALIK MODAL (SHARING PROFIT) ===
    $current_operation = 'Bonus Balik Modal';
    if ($id_plan == 16 || $id_plan == 17) {
        if ($harga > 0) {
            $arr_plan = [
                16 => 60,
                17 => 40
            ];
            foreach ($arr_plan as $plan_member => $persentase) {
                $sql_get_member = "SELECT id FROM mlm_member WHERE id_plan = '$plan_member' AND deleted_at IS NULL";
                $get_member = $conn->_query_transaction($sql_get_member);
                $total_member = $get_member->num_rows;
                if ($total_member > 0) {
                    $total_bonus = floor($nominal_balik_modal * $persentase / 100);
                    $nominal_bonus = floor($total_bonus / $total_member);
                    if ($nominal_bonus > 0) {
                        // Create rekap
                        $sql_rekap = "INSERT INTO mlm_bonus_balik_modal_rekap (id_plan, total_omset, persentase, total_bonus, total_member, nominal_bonus, id_kodeaktivasi, created_at) 
                                         VALUES ('$plan_member', '$nominal_balik_modal', '$persentase', '$total_bonus', '$total_member', '$nominal_bonus', '$id_kodeaktivasi', '$created_at')";
                        $conn->_query_transaction($sql_rekap);

                        // Create bonus for each member
                        $keterangan = 'Bonus Sharing Profit Reborn ' . percent($persentase) . ' dari ' . currency($nominal_balik_modal) . ' / ' . $total_member . ' member';
                        while ($row_member = $get_member->fetch_object()) {
                            $sql_bonus_bm = "INSERT INTO mlm_bonus_balik_modal (id_member, nominal, status_transfer, jenis_bonus, keterangan, id_kodeaktivasi, created_at) 
                                                VALUES ('{$row_member->id}', '$nominal_bonus', '0', '$plan_member', '$keterangan', '$id_kodeaktivasi', '$created_at')";
                            $conn->_query_transaction($sql_bonus_bm);
                        }
                    }
                }
            }
        }
    }

    // === STEP 4: BONUS SPONSOR ===
    $current_operation = 'Bonus Sponsor (ID: ' . $sponsor_id . ')';
    if ($bonus_sponsor > 0) {
        if ($id_plan == 200) {
            $keterangan = 'Bonus ' . $lang['sponsor'] . ' dari ( ID: ' . $id_member . ' / ' . $nama_samaran . ' / ' . $user_member . ' ) paket ' . $nama_plan . ' (' . rp($harga) . ')';
            $sql_wallet = "INSERT INTO mlm_wallet (id_member, jenis_saldo, nominal, type, keterangan, status, status_transfer, dari_member, id_kodeaktivasi, dibaca, created_at) 
                               VALUES ('$sponsor_id', 'reward', '$bonus_sponsor', 'bonus_sponsor', '$keterangan', 'd', '0', '$member_id', '$id_kodeaktivasi', '0', '$created_at')";
            $conn->_query_transaction($sql_wallet);
        } else {
            $keterangan = 'Bonus ' . $lang['sponsor'] . ' dari ( ID: ' . $id_member . ' / ' . $user_member . ' ) paket ' . $nama_plan_produk . ' (' . rp($harga) . ')';
            $sql_bonus_sponsor = "INSERT INTO mlm_bonus_sponsor (id_member, nominal, status_transfer, dari_member, id_kodeaktivasi, jenis_bonus, keterangan, created_at) 
                                      VALUES ('$sponsor_id', '$bonus_sponsor', '0', '$member_id', '$id_kodeaktivasi', '$id_plan', '$keterangan', '$created_at')";
            $conn->_query_transaction($sql_bonus_sponsor);
            // Queue SMS untuk dikirim setelah commit
            $sms_queue[] = ['type' => 'bonus', 'member_id' => $sponsor_id, 'nominal' => $bonus_sponsor, 'keterangan' => $keterangan, 'created_at' => $created_at];
        }
    }

    // === STEP 5: BONUS SPONSOR MONOLEG ===
    $current_operation = 'Bonus Sponsor Monoleg';
    if ($bonus_sponsor_monoleg > 0) {
        $sponsor_monoleg_id = $cksm->get_sponsor_monoleg($member_id);
        if ($sponsor_monoleg_id > 0) {
            $keterangan = 'Bonus ' . $lang['sponsor'] . ' Monoleg dari ( ID: ' . $id_member . ' / ' . $user_member . ' ) paket ' . $nama_plan_produk . ' (' . rp($harga) . ')';
            $sql_bonus_monoleg = "INSERT INTO mlm_bonus_sponsor_monoleg (id_member, nominal, status_transfer, dari_member, id_kodeaktivasi, jenis_bonus, keterangan, created_at) 
                                      VALUES ('$sponsor_monoleg_id', '$bonus_sponsor_monoleg', '0', '$member_id', '$id_kodeaktivasi', '$id_plan', '$keterangan', '$created_at')";
            $conn->_query_transaction($sql_bonus_monoleg);
            // Queue SMS untuk dikirim setelah commit
            $sms_queue[] = ['type' => 'bonus', 'member_id' => $sponsor_monoleg_id, 'nominal' => $bonus_sponsor_monoleg, 'keterangan' => $keterangan, 'created_at' => $created_at];
        }
    }

    // === STEP 6: BONUS CASHBACK ===
    $current_operation = 'Bonus Cashback (Rp ' . number_format($bonus_cashback) . ')';
    if ($bonus_cashback > 0) {
        $keterangan = 'Bonus Cashback paket ' . $nama_plan_produk . ' (' . rp($harga) . ')';
        $sql_bonus_cashback = "INSERT INTO mlm_bonus_cashback (id_member, nominal, status_transfer, dari_member, id_kodeaktivasi, jenis_bonus, keterangan, created_at) 
                                   VALUES ('$member_id', '$bonus_cashback', '0', '$member_id', '$id_kodeaktivasi', '$id_plan', '$keterangan', '$created_at')";
        $conn->_query_transaction($sql_bonus_cashback);
        // Queue SMS untuk dikirim setelah commit
        $sms_queue[] = ['type' => 'bonus', 'member_id' => $member_id, 'nominal' => $bonus_cashback, 'keterangan' => $keterangan, 'created_at' => $created_at];
    }

    // === LOAD GENERASI UPLINE (1x untuk semua operasi) ===
    $current_operation = 'Load Generasi Upline';
    $upline_tree = [];
    if ($_binary == true || $bonus_generasi > 0 || $bonus_upline > 0 || $fee_founder > 0) {
        $sql_gen_upline = "CALL GenerasiUpline($member_id)";
        $gen_upline_result = $conn->_query_transaction($sql_gen_upline);

        if ($gen_upline_result && $gen_upline_result->num_rows > 0) {
            while ($row = $gen_upline_result->fetch_object()) {
                $upline_tree[] = [
                    'upline' => $row->upline,
                    'posisi' => $row->posisi,
                    'generasi' => $row->generasi,
                    'id_plan' => $row->id_plan
                ];
            }
            $gen_upline_result->free();
        }

        // Clear all remaining result sets from stored procedure
        while ($conn->koneksi->more_results()) {
            $conn->koneksi->next_result();
            $res = $conn->koneksi->store_result();
            if ($res instanceof mysqli_result) {
                $res->free();
            }
        }
    }

    // === STEP 7: POIN PASANGAN (BINARY) ===
    $current_operation = 'Poin Pasangan Binary';
    if ($_binary == true && $jumlah_hu > 0) {
        if ($pasangan == '1' || $parent_pasangan > 0) {
            $plan_pasangan = $id_plan;
            if ($parent_pasangan > 0) {
                $plan_pasangan = $parent_pasangan;
            }

            // Use pre-loaded upline tree
            foreach ($upline_tree as $data) {
                $upline_id = $data['upline'];
                $posisi = $data['posisi'];
                $id_plan_member = $data['id_plan'];

                if ($id_plan_member >= 1) {
                    $sql_cek = "SELECT COUNT(*) as total FROM mlm_member_poin_pasangan WHERE id_member = '$upline_id' AND id_kodeaktivasi = '$id_kodeaktivasi' AND id_plan = '$plan_pasangan' AND posisi = '$posisi'";
                    $cek_poin_result = $conn->_query_transaction($sql_cek);
                    $cek_poin_row = $cek_poin_result->fetch_object();
                    $cek_poin_result->free();

                    if ($cek_poin_row->total == 0) {
                        $sql_poin = "INSERT INTO mlm_member_poin_pasangan (id_member, posisi, poin, id_kodeaktivasi, id_plan, type, status, created_at) 
                                         VALUES ('$upline_id', '$posisi', '$jumlah_hu', '$id_kodeaktivasi', '$plan_pasangan', '$jenis_posting', 'd', '$created_at')";
                        $conn->_query_transaction($sql_poin);
                    }
                }
            }
        }
    }
    // === STEP 8: POIN PASANGAN LEVEL ===
    $current_operation = 'Poin Pasangan Level';
    if ($_binary == true && $reposisi == '0') {
        if ($pasangan_level == '1' || $parent_pasangan_level > 0) {
            $plan_pasangan_level = $id_plan;
            if ($parent_pasangan_level > 0) {
                $plan_pasangan_level = $parent_pasangan_level;
            }

            // Use pre-loaded upline tree
            foreach ($upline_tree as $data) {
                $upline_pl = $data['upline'];
                $posisi_pl = $data['posisi'];
                $generasi_pl = $data['generasi'];
                $id_plan_upline = $data['id_plan'];

                if ($id_plan_upline >= 1) {
                    // Check if poin already exists
                    $sql_cek_pl = "SELECT COUNT(*) as total FROM mlm_member_poin_pasangan_level WHERE id_member = '$upline_pl' AND posisi = '$posisi_pl' AND id_plan = '$plan_pasangan_level' AND generasi = '$generasi_pl' AND id_kodeaktivasi = '$id_kodeaktivasi' AND status = 'd' AND deleted_at IS NULL";
                    $cek_pl_result = $conn->_query_transaction($sql_cek_pl);
                    $cek_pl = $cek_pl_result->fetch_object();
                    $cek_pl_result->free();
                    if ($cek_pl->total == 0) {
                        $sql_insert_pl = "INSERT INTO mlm_member_poin_pasangan_level (id_member, generasi, posisi, poin, id_kodeaktivasi, id_plan, type, status, created_at) VALUES ('$upline_pl', '$generasi_pl', '$posisi_pl', '1', '$id_kodeaktivasi', '$plan_pasangan_level', '$jenis_posting', 'd', '$created_at')";
                        $conn->_query_transaction($sql_insert_pl);
                    }
                }
            }
        }
    }
    // === STEP 9: POIN REWARD BINARY ===
    $current_operation = 'Poin Reward Binary';
    if ($_binary == true && $poin_reward > 0) {
        if ($reward == '1' || $parent_reward > 0) {
            $plan_reward = $id_plan;
            if ($parent_reward > 0) {
                $plan_reward = $parent_reward;
                $parent_plan = $cpl->show($plan_reward);
                $reward_wajib_ro = $parent_plan->reward_wajib_ro;
            }

            // Use pre-loaded upline tree
            foreach ($upline_tree as $data) {
                $upline_rw = $data['upline'];
                $posisi_rw = $data['posisi'];
                $kondisi_rw = false;

                if ($reward_wajib_ro == 1) {
                    $sql_cek_ro = "SELECT COUNT(*) as total FROM mlm_member_poin_ro_reward WHERE id_member = '$upline_rw' AND id_plan = '$plan_reward' AND deleted_at IS NULL";
                    $cek_ro_result = $conn->_query_transaction($sql_cek_ro);
                    $cek_ro = $cek_ro_result->fetch_object();
                    $cek_ro_result->free();
                    if ($cek_ro->total > 0) {
                        $kondisi_rw = true;
                    }
                } else {
                    $kondisi_rw = true;
                }

                if ($plan_reward >= 1) {
                    $kondisi_rw = true;
                } else {
                    $kondisi_rw = false;
                }

                if ($kondisi_rw == true) {
                    // Check if poin already exists
                    $sql_cek_rw = "SELECT COUNT(*) as total FROM mlm_member_poin_reward WHERE id_member = '$upline_rw' AND id_kodeaktivasi = '$id_kodeaktivasi' AND id_plan = '$plan_reward' AND posisi = '$posisi_rw' AND status = 'd' AND deleted_at IS NULL";
                    $cek_rw_result = $conn->_query_transaction($sql_cek_rw);
                    $cek_rw = $cek_rw_result->fetch_object();
                    $cek_rw_result->free();
                    if ($cek_rw->total == 0) {
                        $sql_insert_rw = "INSERT INTO mlm_member_poin_reward (id_member, posisi, poin, id_kodeaktivasi, id_plan, type, status, created_at) VALUES ('$upline_rw', '$posisi_rw', '$poin_reward', '$id_kodeaktivasi', '$plan_reward', '$jenis_posting', 'd', '$created_at')";
                        $conn->_query_transaction($sql_insert_rw);
                    }
                }
            }
        }
    }
    // if($reward_sponsor == '1' || $parent_reward_sponsor > 0){
    //     $plan_reward_sponsor = $id_plan;
    //     if($parent_reward_sponsor > 0){
    //         $plan_reward_sponsor = $parent_reward_sponsor;
    //     }                    
    //     $create_poin_reward_sponsor = $cbr->create_poin_pribadi($sponsor_id, 1, $id_kodeaktivasi, $plan_reward_sponsor, $jenis_posting, $created_at);
    // }
    // === STEP 10: POIN REWARD PAKET ===
    $current_operation = 'Poin Reward Paket (Sponsor)';
    if ($poin_reward_promo > 0) {
        // Create poin reward paket - using direct SQL in transaction
        $sql_cek_rwp = "SELECT COUNT(*) as total FROM mlm_member_poin_reward_paket WHERE id_member = '$sponsor_id' AND id_produk_jenis = '$id_produk_jenis' AND id_kodeaktivasi = '$id_kodeaktivasi' AND status = 'd' AND deleted_at IS NULL";
        $cek_rwp_result = $conn->_query_transaction($sql_cek_rwp);
        $cek_rwp = $cek_rwp_result->fetch_object();
        $cek_rwp_result->free();
        if ($cek_rwp->total == 0) {
            $sql_insert_rwp = "INSERT INTO mlm_member_poin_reward_paket (id_member, posisi, poin, id_kodeaktivasi, id_produk_jenis, type, status, created_at) VALUES ('$sponsor_id', '', '$poin_reward_promo', '$id_kodeaktivasi', '$id_produk_jenis', '$jenis_posting', 'd', '$created_at')";
            $conn->_query_transaction($sql_insert_rwp);
        }
    }

    // === STEP 11: UPDATE JUMLAH KAKI ===
    $current_operation = 'Update Jumlah Kaki Kiri/Kanan';
    if ($_binary == true) {
        // Build path untuk menentukan posisi di setiap level
        // Posisi member baru menentukan cabang mana untuk direct parent
        // Untuk upline di atasnya, ikuti posisi parent mereka

        $current_member = $upline; // Direct parent
        $current_posisi = ($posisi == 'kiri' || $posisi == 'L') ? 'L' : 'R'; // Normalize posisi

        // Update direct parent
        if ($current_posisi == 'L') {
            $sql_update_parent = "UPDATE mlm_member SET jumlah_kiri = jumlah_kiri + 1 WHERE id = '$current_member'";
        } else {
            $sql_update_parent = "UPDATE mlm_member SET jumlah_kanan = jumlah_kanan + 1 WHERE id = '$current_member'";
        }
        $conn->_query_transaction($sql_update_parent);

        // Update upline di atasnya mengikuti posisi parent chain
        foreach ($upline_tree as $data) {
            $upline_jk = $data['upline'];
            $id_plan_jk = $data['id_plan'];

            // Skip direct parent (sudah di-update)
            if ($upline_jk == $current_member) continue;

            // Ambil posisi parent relatif terhadap grandparent ini
            $sql_get_parent_pos = "SELECT posisi FROM mlm_member WHERE id = '$current_member'";
            $parent_pos_result = $conn->_query_transaction($sql_get_parent_pos);
            $parent_pos_data = $parent_pos_result->fetch_object();
            $parent_pos_result->free();

            if ($parent_pos_data) {
                $parent_posisi = $parent_pos_data->posisi;
                $normalized_pos = ($parent_posisi == 'kiri' || $parent_posisi == 'L') ? 'L' : 'R';

                if ($id_plan >= 1 && $id_plan_jk >= 1) {
                    if ($normalized_pos == 'L') {
                        $sql_update_jk = "UPDATE mlm_member SET jumlah_kiri = jumlah_kiri + 1 WHERE id = '$upline_jk'";
                    } else {
                        $sql_update_jk = "UPDATE mlm_member SET jumlah_kanan = jumlah_kanan + 1 WHERE id = '$upline_jk'";
                    }
                    $conn->_query_transaction($sql_update_jk);
                }

                // Move up the chain
                $current_member = $upline_jk;
            }
        }
    }

    // === STEP 12: BONUS FOUNDER ===
    $current_operation = 'Bonus Founder Fee';
    if ($fee_founder > 0 && $harga > 0) {
        // Get founder list
        $sql_founder = "SELECT id, name, persentase_bonus FROM mlm_founder WHERE status = '1' AND deleted_at IS NULL";
        $founder = $conn->_query_transaction($sql_founder);
        if ($founder && $founder->num_rows > 0) {
            while ($row = $founder->fetch_object()) {
                $keterangan_founder = 'Fee ' . $row->name . ' Paket ' . $nama_plan_produk;
                $id_founder = $row->id;
                $nominal_bonus_founder = floor($fee_founder * $row->persentase_bonus / 100);

                // Use pre-loaded upline tree
                foreach ($upline_tree as $data_fd) {
                    $upline_fd = $data_fd['upline'];
                    $posisi_fd = $data_fd['posisi'];
                    $id_plan_fd = $data_fd['id_plan'];

                    // Check if upline is founder
                    $sql_cek_founder = "SELECT COUNT(*) as total FROM mlm_founder WHERE id_member = '$upline_fd' AND id = '$id_founder' AND deleted_at IS NULL";
                    $cek_founder_result = $conn->_query_transaction($sql_cek_founder);
                    $cek_founder = $cek_founder_result->fetch_object();
                    $cek_founder_result->free();

                    if ($id_plan_fd >= 1 && $cek_founder->total > 0) {
                        $sql_insert_fd = "INSERT INTO mlm_bonus_founder (id_member, dari_member, dari_id_member, dari_nama, nominal, posisi, status_transfer, jenis_bonus, id_founder, keterangan, id_kodeaktivasi, created_at) VALUES ('$upline_fd', '$member_id', '$id_member', '$user_member', '$nominal_bonus_founder', '$posisi_fd', '0', '$id_plan', '$id_founder', '$keterangan_founder', '$id_kodeaktivasi', '$created_at')";
                        $conn->_query_transaction($sql_insert_fd);
                    }
                }
            }
        }
    }

    // === STEP 13: BONUS GENERASI (UNILEVEL) ===
    $current_operation = 'Bonus Generasi/Unilevel';
    if ($bonus_generasi > 0) {
        $jenis_bonus = $id_plan;
        $max = $ckg->max_generasi($id_plan);
        $keterangan = 'Paket ' . $nama_plan_produk . ' (' . rp($harga) . ')';

        // Get setting bonus generasi
        $sql_setting = "SELECT * FROM mlm_bonus_generasi_setting WHERE id_plan = '$jenis_bonus'";
        $setting_result = $conn->_query_transaction($sql_setting);
        $setting_bonus = $setting_result->fetch_object();
        $setting_result->free();

        if ($setting_bonus && $setting_bonus->rekap == '1') {
            $status_transfer = '-1';
        } else {
            $status_transfer = '0';
        }

        // Get sponsor tree with max
        $sql_sponsor = "CALL GenerasiSponsorWithMax($member_id, $max)";
        $sponsor_result = $conn->_query_transaction($sql_sponsor);

        // Store sponsor data to array
        $sponsor_tree = [];
        if ($sponsor_result && $sponsor_result->num_rows > 0) {
            while ($row_sponsor = $sponsor_result->fetch_object()) {
                $sponsor_tree[] = [
                    'sponsor' => $row_sponsor->sponsor,
                    'generasi' => $row_sponsor->generasi
                ];
            }
            $sponsor_result->free();
        }

        // Clear stored procedure result sets
        while ($conn->koneksi->more_results()) {
            $conn->koneksi->next_result();
            $res = $conn->koneksi->store_result();
            if ($res instanceof mysqli_result) {
                $res->free();
            }
        }

        // Process bonus generasi
        foreach ($sponsor_tree as $data_sponsor) {
            $sponsor_id = $data_sponsor['sponsor'];
            $generasi = $data_sponsor['generasi'];

            if ($jenis_bonus >= 200) {
                // Langsung ke wallet untuk paket >= 200
                $keterangan_gen = 'Bonus Generasi ' . $keterangan . ' dari ' . $user_member . ' (' . $id_member . ') Generasi ke-' . $generasi;
                $sql_wallet_gen = "INSERT INTO mlm_wallet (id_member, jenis_saldo, nominal, type, keterangan, status, status_transfer, dari_member, id_kodeaktivasi, dibaca, created_at) 
                                      VALUES ('$sponsor_id', 'cash', '$bonus_generasi', 'bonus_generasi', '$keterangan_gen', 'd', '0', '$member_id', '$id_kodeaktivasi', '0', '$created_at')";
                $conn->_query_transaction($sql_wallet_gen);
            } else {
                // Get persentase berdasarkan generasi
                $sql_persentase = "SELECT * FROM mlm_bonus_generasi_persentase WHERE id_plan = '$jenis_bonus' AND generasi = '$generasi'";
                $persentase_result = $conn->_query_transaction($sql_persentase);
                $setting_persentase = $persentase_result->fetch_object();
                $persentase_result->free();

                if ($setting_persentase) {
                    $persentase = $setting_persentase->persentase;
                    $syarat_sponsori = $setting_persentase->sponsori;
                } else {
                    $persentase = 100;
                    $syarat_sponsori = 0;
                }

                // Cek total sponsori
                $total_sponsori = $ckg->sponsori($sponsor_id);

                $kondisi = false;
                if ($total_sponsori >= $syarat_sponsori) {
                    $kondisi = true;
                }

                if ($jenis_bonus == 14) {
                    $status_transfer = '-1';
                    $keterangan_gen = 'Bonus Generasi RO Aktif ' . $keterangan . ' dari ' . $user_member . ' (' . $id_member . ') Generasi ke-' . $generasi;
                } else {
                    $keterangan_gen = 'Bonus Generasi ' . $keterangan . ' dari ' . $user_member . ' (' . $id_member . ') Generasi ke-' . $generasi;
                }

                if ($kondisi == true) {
                    $nominal_bonus = floor($bonus_generasi * $persentase / 100);

                    // Cek apakah bonus sudah ada
                    if ($ckg->cek_bonus($sponsor_id, $id_kodeaktivasi, $jenis_bonus) == 0) {
                        $sql_bonus_gen = "INSERT INTO mlm_bonus_generasi (id_member, nominal, status_transfer, dari_member, id_kodeaktivasi, jenis_bonus, generasi, keterangan, created_at) 
                                             VALUES ('$sponsor_id', '$nominal_bonus', '$status_transfer', '$member_id', '$id_kodeaktivasi', '$jenis_bonus', '$generasi', '$keterangan_gen', '$created_at')";
                        $conn->_query_transaction($sql_bonus_gen);
                    }
                }
            }
        }
    }

    // === STEP 14: BONUS UPLINE ===
    $current_operation = 'Bonus Upline';
    if ($bonus_upline > 0) {
        $jenis_bonus = $id_plan;
        $max = $cku->max_generasi($id_plan);
        $keterangan = 'Paket ' . $nama_plan_produk . ' (' . rp($harga) . ')';

        // Use pre-loaded upline tree and filter by max generasi
        foreach ($upline_tree as $data_gen) {
            if ($data_gen['generasi'] <= $max) {
                $upline_member = $data_gen['upline'];
                $generasi = $data_gen['generasi'];
                $keterangan_upline = 'Bonus Upline ' . $keterangan . ' dari ' . $user_member . ' (' . $id_member . ') Generasi ke-' . $generasi;

                $sql_bonus_upline = "INSERT INTO mlm_bonus_upline (id_member, nominal, status_transfer, dari_member, id_kodeaktivasi, jenis_bonus, generasi, keterangan, created_at) 
                                        VALUES ('$upline_member', '$bonus_upline', '0', '$member_id', '$id_kodeaktivasi', '$jenis_bonus', '$generasi', '$keterangan_upline', '$created_at')";
                $conn->_query_transaction($sql_bonus_upline);
            }
        }
    }

    // === STEP 15: SALDO WITHDRAWAL ===
    $current_operation = 'Saldo Penarikan (Rp ' . number_format($saldo_wd) . ')';
    if ($saldo_wd > 0) {
        $jenis_saldo_wd = $id_plan == 200 ? 'cash' : 'saldo_wd';
        $sql_saldo_wd = "INSERT INTO mlm_saldo_penarikan (id_member, jenis_saldo, nominal, type, keterangan, status, id_kodeaktivasi, created_at) 
                             VALUES ('$member_id', '$jenis_saldo_wd', '$saldo_wd', '$type_saldo_wd', '$keterangan_saldo_wd', 'd', '$id_kodeaktivasi', '$created_at')";
        $conn->_query_transaction($sql_saldo_wd);
    }
?>