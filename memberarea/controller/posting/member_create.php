<?php
    require_once '../../../helper/all_member.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberProspek.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classSMS.php';

    $cm = new classMember();
    $cmp = new classMemberProspek();
    $cka = new classKodeAktivasi();
    $sms  = new classSMS();

    if ($_maintenance == true) {
        echo json_encode(['status' => false, 'message' => 'Mohon maaf. Sistem sedang Maintenace. Silahkan dicoba beberapa saat lagi.']);
        return false;
    }

    $sponsor = $session_member_id;
    $sponsor_id = $session_member_id;
    if ($_sponsor_static == false) {
        # CEK PARAMETER POST
        if (!isset($_POST['sponsor'])) {
            echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Sponsor tidak ditemukan.']);
            return false;
        }
        $data_sponsor = $cm->data_sponsor($session_member_id, $_POST['sponsor'], base64_decode($_POST['id_upline']));
        if (!$data_sponsor) {
            echo json_encode(['status' => false, 'message' => 'Sponsor tidak ada dijaringan anda.']);
            return false;
        }
        $sponsor_id = $data_sponsor->id;
    }
    # CEK PARAMETER POST
    if (!isset($_POST['id_kodeaktivasi'])) {
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }

    $tipe_akun = $_POST['tipe_akun'];
    // $tipe_akun = 0;
    // $current_kode_aktivasi = $_POST['kode_aktivasi'];
    $id_kodeaktivasi = number($_POST['id_kodeaktivasi']);
    $pin = $cka->get_kodeaktivasi($sponsor, $id_kodeaktivasi, 0);
    if (!$pin) {
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Kode Aktivasi tidak ditemukan.']);
        return false;
    }
    # CEK KODE AKTIVASI
    $cek_duplikat = $cka->cek_duplikat($sponsor, $pin->kode_aktivasi);
    if ($cek_duplikat > 0) {
        echo json_encode(['status' => false, 'message' => $lang['pin'] . ' sudah digunakan.']);
        return false;
    }

    // Variables used in member creation (keep in this file)
    $kode_aktivasi = $pin->kode_aktivasi;
    $id_produk_jenis = $pin->jenis_produk;
    $reposisi = $pin->reposisi;
    $founder = $pin->founder;
    $id_plan = $pin->jenis_aktivasi;
    $id_paket = 1;
    $id_peringkat = 0;
    $jenis_posting = 'posting';
    $type_saldo_wd = 'posting';
    $created_at = date('Y-m-d H:i:s');
    
    // Variables for bonus calculation (will be extracted in create_bonus.php)
    // These are passed to create_bonus.php via $pin object

    // Initialize connection for transaction
    $conn = new classConnection();

    try {
        // Start transaction
        $conn->beginTransaction();
        $current_operation = 'Validasi Data'; // Track current operation for error reporting

        $upline = NULL;
        $posisi = addslashes(strip_tags($_POST['posisi']));
        if ($_binary == true) {
            $id_upline = base64_decode($_POST['id_upline']);
            $data_upline = $cm->show($id_upline);
            if (!$data_upline) {
                echo json_encode(['status' => false, 'message' => 'Data upline tidak ditemukan.']);
                return false;
            }
            $upline = $id_upline;
            $level = $data_upline->level + 1;
            $cek_posisi = $cm->cek_posisi_kaki($id_upline, $posisi);
            if (!$cek_posisi) {
                echo json_encode(['status' => false, 'message' => 'Posisi kaki penuh.']);
                return false;
            }
        } else {
            $level = $data_sponsor->level + 1;
        }

        if ($tipe_akun == '0') {
            $id_member = $cm->generate_id_member(5, 'A99');
            $group_akun = $id_member;
            $pass_member = generatePassword();
            $pin_member = generatePIN();
            $nama_member = isset($_POST['nama_member']) ? addslashes(strip_tags($_POST['nama_member'])) : NULL;
            $hp_member = number($_POST['hp_member']);

            // $nama_samaran = addslashes(strip_tags($_POST['nama_samaran']));
            $user_member = addslashes(strip_tags($_POST['username']));
            $nama_samaran = $user_member;
            $tgl_lahir_member = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['tanggal_lahir'])));
            $tempat_lahir_member = addslashes(strip_tags($_POST['tempat_lahir']));
            $alamat_member = NULL;
            $jns_kel_member = NULL;
            $no_ktp_member = NULL;
            $telp_member = NULL;
            $kodepos_member = NULL;
            $email_member = isset($_POST['email_member']) ? addslashes(strip_tags($_POST['email_member'])) : NULL;
            $no_rekening = isset($_POST['no_rekening']) ? addslashes(strip_tags($_POST['no_rekening'])) : NULL;
            // $atas_nama_rekening = $_POST['atas_nama_rekening'];
            $atas_nama_rekening = isset($_POST['nama_member']) ? addslashes(strip_tags($_POST['nama_member'])) : NULL;
            $cabang_rekening = isset($_POST['cabang_rekening']) ? addslashes(strip_tags($_POST['cabang_rekening'])) : NULL;
            $id_bank = isset($_POST['id_bank']) ? addslashes(strip_tags($_POST['id_bank'])) : NULL;
            $id_provinsi = NULL;
            $id_kota = NULL;
            $id_kecamatan = NULL;
            $id_kelurahan = NULL;
            $profile_updated = '1';
        } else if ($tipe_akun == '1') {
            $cloning = $cm->detail($sponsor_id);
            if (!$cloning) {
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Data Cloning ID tidak ditemukan.']);
                return false;
            }

            if ($cloning->group_akun == '') {
                $group_akun = $cloning->id_member;
            } else {
                $group_akun = $cloning->group_akun;
            }
            $jumlah_akun = $cm->jumlah_akun($group_akun);
            // $akronim = strtoupper($cm->admin_config("akronim_member"));
            // $count_akronim = strlen($akronim);
            // $potongan = substr($group_akun, $count_akronim)+$jumlah_akun;
            $id_member = $cm->generate_id_member(6, '00');
            // $id_member = $akronim.$potongan;

            // $group_akun = $cm->generate_group_akun($data_sponsor->id_member, 4);
            if ($group_akun == '') {
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Akun tidak dapat di cloning. Silahkan Hubungi administrator.']);
                return false;
            }
            $pass_member = $cloning->pass_member;
            $pin_member = $cloning->pin_member;
            $nama_member = addslashes(strip_tags($cloning->nama_member));
            $hp_member = $cloning->hp_member;

            $nama_samaran = addslashes(strip_tags($cloning->nama_samaran));
            $user_member = $cloning->user_member . $jumlah_akun;
            $tgl_lahir_member = $cloning->tgl_lahir_member;
            $tempat_lahir_member = $cloning->tempat_lahir_member;
            $alamat_member = $cloning->alamat_member;
            $jns_kel_member = $cloning->jns_kel_member;
            $no_ktp_member = $cloning->no_ktp_member;
            $telp_member = $cloning->telp_member;
            $kodepos_member = $cloning->kodepos_member;
            $email_member = $cloning->email_member;
            $no_rekening = $cloning->no_rekening;
            $atas_nama_rekening = $cloning->atas_nama_rekening;
            $cabang_rekening = $cloning->cabang_rekening;
            $id_bank = $cloning->id_bank;
            $id_kota = $cloning->id_kota;
            $id_provinsi = $cloning->id_provinsi;
            $id_kecamatan = $cloning->id_kecamatan;
            $id_kelurahan = $cloning->id_kelurahan;
            $profile_updated = '1';
        } else if ($tipe_akun == '2') {

            $id_member_prospek = $_POST['member_prospek'];
            $member_prospek = $_POST['member_prospek'];
            // $member_prospek = $cmp->show($sponsor, $member_prospek);
            $_data_sponsor = $cm->detail($sponsor_id);
            $_sponsor = $_data_sponsor->user_member;
            $member_prospek = $cmp->show($id_member_prospek, $sponsor_id);
            if (!$member_prospek) {
                echo json_encode(['status' => false, 'message' => 'Anda tidak memiliki ' . $lang['member'] . ' prospek.']);
                return false;
            }

            $id_member = $cm->generate_id_member(6, '00');
            $no_rekening = $member_prospek->no_rekening;
            $group_akun = $cm->cek_nomor_rekening($no_rekening);
            if (!$group_akun) {
                $group_akun = $id_member;
            } else {
                // $jumlah_akun = $cm->jumlah_akun($group_akun);
                // $akronim = strtoupper($cm->admin_config("akronim_member"));
                // $count_akronim = strlen($akronim);
                // $potongan = substr($group_akun, $count_akronim)+$jumlah_akun;
                // $id_member = $akronim.$potongan;
                $id_member = $cm->generate_id_member(6, '00');
            }
            $pass_member = generatePassword();
            $pin_member = generatePIN();
            $nama_member = addslashes(strip_tags($member_prospek->nama_member));
            $hp_member = $member_prospek->hp_member;

            $nama_samaran = addslashes(strip_tags($member_prospek->nama_member));
            $user_member = addslashes(strip_tags($member_prospek->nama_samaran));
            $tgl_lahir_member = NULL;
            $tempat_lahir_member = NULL;
            $alamat_member = NULL;
            $jns_kel_member = NULL;
            $no_ktp_member = NULL;
            $telp_member = NULL;
            $kodepos_member = NULL;
            $email_member = addslashes(strip_tags($member_prospek->email));
            $no_rekening = addslashes(strip_tags($member_prospek->no_rekening));
            $atas_nama_rekening = addslashes(strip_tags($member_prospek->nama_member));
            $cabang_rekening = addslashes(strip_tags($member_prospek->cabang_rekening));
            $id_bank = addslashes(strip_tags($member_prospek->id_bank));
            $id_provinsi = NULL;
            $id_kota = NULL;
            $id_kecamatan = NULL;
            $id_kelurahan = NULL;
            $profile_updated = '0';
        } else {
            echo json_encode(['status' => false, 'message' => 'Tipe akun tidak valid.']);
            return false;
        }

        $cm->set_id_member($id_member);
        $cm->set_nama_member($nama_member);
        $cm->set_hp_member($hp_member);
        $cm->set_kode_aktivasi($kode_aktivasi);
        $cm->set_id_plan($id_plan);
        $cm->set_id_paket($id_paket);
        $cm->set_id_peringkat($id_peringkat);
        $cm->set_id_produk_jenis($id_produk_jenis);
        $cm->set_sponsor($sponsor_id);
        $cm->set_upline($upline);
        $cm->set_posisi($posisi);
        $cm->set_level($level);
        $cm->set_group_akun($group_akun);
        $cm->set_status_member('1');


        $cm->set_nama_samaran($nama_samaran);
        $cm->set_user_member($user_member);
        $cm->set_pass_member($pass_member);
        $cm->set_pin_member($pin_member);
        $cm->set_tgl_lahir_member($tgl_lahir_member);
        $cm->set_tempat_lahir_member($tempat_lahir_member);
        $cm->set_alamat_member($alamat_member);
        $cm->set_jns_kel_member($jns_kel_member);
        $cm->set_no_ktp_member($no_ktp_member);
        $cm->set_telp_member($telp_member);
        $cm->set_kodepos_member($kodepos_member);
        $cm->set_email_member($email_member);
        $cm->set_no_rekening($no_rekening);
        $cm->set_atas_nama_rekening($atas_nama_rekening);
        $cm->set_cabang_rekening($cabang_rekening);
        $cm->set_id_bank($id_bank);
        $cm->set_id_provinsi($id_provinsi);
        $cm->set_id_kota($id_kota);
        $cm->set_id_kecamatan($id_kecamatan);
        $cm->set_id_kelurahan($id_kelurahan);
        $cm->set_reposisi($reposisi);
        $cm->set_founder($founder);
        $cm->set_profile_updated($profile_updated);
        $cm->set_created_at($created_at);

        // === STEP 1: CREATE MEMBER ===
        $current_operation = 'Membuat Data Member';
        $member_id = $cm->create_transaction($conn);

        if ($member_id > 0) {
            // === STEP 2: UPDATE UPLINE & ACTIVATION ===
            $current_operation = 'Update Kaki Upline';
            if ($_binary == true) {
                $update_kaki_upline_sql = "UPDATE mlm_member SET ";
                if ($posisi == 'kiri') {
                    $update_kaki_upline_sql .= "kaki_kiri = '$member_id'";
                } else {
                    $update_kaki_upline_sql .= "kaki_kanan = '$member_id'";
                }
                $update_kaki_upline_sql .= " WHERE id = '$id_upline'";
                $conn->_query_transaction($update_kaki_upline_sql);
            }
            
            require_once 'create_bonus.php';

            $current_operation = 'Update Member Prospek';
            if ($tipe_akun == '2') {
                // Update member prospek - using direct SQL in transaction
                $sql_update_mp1 = "UPDATE mlm_member_prospek SET status_member = '1' WHERE sponsor = '$sponsor' AND id = '{$member_prospek->id}' AND status_member = '0'";
                $conn->_query_transaction($sql_update_mp1);
            }
        } else {
            throw new Exception('Aktifasi gagal. Member ID tidak dapat dibuat.');
        }

        if ($tipe_akun == '2') {
            // Update member prospek - using direct SQL in transaction
            $sql_update_mp2 = "UPDATE mlm_member_prospek SET status_member = '1' WHERE sponsor = '$_sponsor' AND id = '$id_member_prospek' AND status_member = '0'";
            $conn->_query_transaction($sql_update_mp2);
        }

        // === TRANSACTION COMPLETE ===
        $current_operation = 'Commit Transaction';
        $conn->commit();
        
        // === SEND SMS/WA AFTER SUCCESSFUL COMMIT ===
        // SMS hanya dikirim jika transaksi berhasil
        $sms->smsPendaftaran($member_id);
        $sms->smsPendaftaranSponsor($member_id, $sponsor_id);
        
        // Kirim SMS bonus dari queue (dari create_bonus.php)
        if(isset($sms_queue) && is_array($sms_queue)) {
            foreach($sms_queue as $notification) {
                if($notification['type'] == 'bonus') {
                    $sms->smsBonusNew(
                        $notification['member_id'], 
                        $notification['nominal'], 
                        $notification['keterangan'], 
                        $notification['created_at']
                    );
                }
            }
        }
    } catch (\Exception $e) {
        // Rollback transaction on error
        $conn->rollback();

        // Detailed error logging
        $error_details = [
            'status' => false,
            'message' => 'Pendaftaran gagal pada tahap: ' . $current_operation,
            'error' => $e->getMessage(),
            'member_id' => isset($member_id) ? $member_id : 'Belum dibuat',
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Log to file for debugging
        $log_message = "[" . date('Y-m-d H:i:s') . "] Registration Error\n";
        $log_message .= "Operation: " . $current_operation . "\n";
        $log_message .= "Member ID: " . (isset($member_id) ? $member_id : 'N/A') . "\n";
        $log_message .= "Sponsor: " . (isset($sponsor) ? $sponsor : 'N/A') . "\n";
        $log_message .= "Error: " . $e->getMessage() . "\n";
        $log_message .= "-----------------------------------\n";
        @file_put_contents(__DIR__ . '/../../log/member_registration_errors.log', $log_message, FILE_APPEND);

        echo json_encode($error_details);
        return false;
    }
    $message = '
        <div style="max-width: 500px; margin: 0 auto; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 16px; padding: 32px; box-shadow: 0 8px 32px rgba(0,0,0,0.3); border: 1px solid #d4af37;">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="display: inline-block; background: linear-gradient(135deg, #d4af37 0%, #f4e5a1 100%); padding: 12px 24px; border-radius: 50px; margin-bottom: 16px;">
                    <svg style="width: 48px; height: 48px; fill: #1a1a1a;" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <h2 style="color: #d4af37; font-size: 24px; font-weight: 700; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 1px;">Pendaftaran Berhasil</h2>
                <p style="color: #a0a0a0; font-size: 14px; margin: 0;">Selamat! Akun ' . $lang['member'] . ' Anda telah aktif</p>
            </div>
            
            <div style="background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 12px; padding: 20px; margin-bottom: 16px;">
                <div style="display: grid; gap: 16px;">
                    <div style="border-left: 3px solid #d4af37; padding-left: 16px;">
                        <p style="color: #888; font-size: 12px; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Nama Member</p>
                        <p style="color: #fff; font-size: 16px; font-weight: 600; margin: 0;">' . $nama_member . '</p>
                    </div>
                    
                    <div style="border-left: 3px solid #d4af37; padding-left: 16px;">
                        <p style="color: #888; font-size: 12px; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">ID ' . $lang['member'] . '</p>
                        <p style="color: #d4af37; font-size: 18px; font-weight: 700; margin: 0; font-family: monospace;">' . $id_member . '</p>
                    </div>
                    
                    <div style="border-left: 3px solid #d4af37; padding-left: 16px;">
                        <p style="color: #888; font-size: 12px; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Username</p>
                        <p style="color: #fff; font-size: 16px; font-weight: 600; margin: 0; font-family: monospace;">' . $user_member . '</p>
                    </div>
                    
                    <div style="border-left: 3px solid #d4af37; padding-left: 16px;">
                        <p style="color: #888; font-size: 12px; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Password</p>
                        <p style="color: #fff; font-size: 16px; font-weight: 600; margin: 0; font-family: monospace;">' . base64_decode($pass_member) . '</p>
                    </div>
                    
                    <div style="border-left: 3px solid #d4af37; padding-left: 16px;">
                        <p style="color: #888; font-size: 12px; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">PIN</p>
                        <p style="color: #fff; font-size: 16px; font-weight: 600; margin: 0; font-family: monospace;">' . base64_decode($pin_member) . '</p>
                    </div>
                </div>
            </div>
            
            <div style="background: rgba(212, 175, 55, 0.05); border-radius: 8px; padding: 16px; text-align: center;">
                <p style="color: #d4af37; font-size: 12px; margin: 0; line-height: 1.6;">
                    <strong>⚠️ PENTING:</strong> Simpan data login Anda dengan aman
                </p>
            </div>
        </div>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
