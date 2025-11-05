<?php
    require_once 'Model.php';     // File Model


    class StokisDepositDetail extends Model{
        protected $table = 'mlm_stokis_deposit_detail';

        public function create($id_stokis, $id_stokis_tujuan, $id_deposit, $created_at) {
            // SQL Query menggunakan rawQuery dan rawExecute
            $sql = "INSERT INTO mlm_stokis_deposit_detail (
                        id_deposit, 
                        id_produk,
                        jenis_produk, 
                        nama_produk, 
                        hpp, 
                        harga, 
                        qty, 
                        jumlah, 
                        fee_stokis, 
                        created_at
                    ) 
                    SELECT 
                        :id_deposit,
                        c.id_produk,
                        p.id_produk_jenis,
                        p.nama_produk,
                        p.hpp,
                        p.harga,
                        c.qty,
                        p.harga * c.qty,
                        (ps.persentase_fee / 100) * (p.harga * c.qty),
                        :created_at
                    FROM mlm_stokis_deposit_cart c
                    LEFT JOIN mlm_stokis_member sm ON c.id_stokis = sm.id
                    LEFT JOIN mlm_stokis_paket ps ON sm.id_paket = ps.id
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id                    
                    WHERE c.id_stokis = :id_stokis
                    AND c.id_stokis_tujuan = :id_stokis_tujuan
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
            
            // Parameter binding menggunakan rawExecute
            return $this->rawExecute($sql, [
                'id_deposit' => $id_deposit,
                'created_at' => $created_at,
                'id_stokis' => $id_stokis,
                'id_stokis_tujuan' => $id_stokis_tujuan
            ]);
        }

        public function index($id_deposit) {
            // SQL Query menggunakan rawQuery
            $sql = "SELECT 
                    dt.*, 
                    p.gambar, 
                    p.nama_produk,
                    p.qty as qty_produk,
                    p.satuan,
                    j.name
                    FROM mlm_stokis_deposit_detail dt
                    LEFT JOIN mlm_produk p ON dt.id_produk = p.id 
                    LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                    WHERE dt.id_deposit = :id_deposit
                    AND dt.deleted_at IS NULL
                    ORDER BY dt.id ASC";
            
            // Mengambil hasil dengan rawQuery
            return $this->rawQuery($sql, ['id_deposit' => $id_deposit]);
        }
    }
?>