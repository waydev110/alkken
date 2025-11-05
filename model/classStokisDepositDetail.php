<?php
    require_once 'classConnection.php';

    class classStokisDepositDetail{
        public function create($id_stokis, $id_stokis_tujuan, $id_deposit, $created_at){
            $sql = "INSERT INTO mlm_stokis_deposit_detail (
                        id_deposit, 
                        id_produk, 
                        nama_produk, 
                        hpp, 
                        harga, 
                        qty, 
                        jumlah, 
                        fee_stokis, 
                        created_at
                    ) SELECT 
                        '$id_deposit',
                        c.id_produk,
                        p.nama_produk,
                        p.hpp,
                        p.harga,
                        c.qty,
                        p.harga*c.qty,
                        (ps.persentase_fee/100)*(p.harga*c.qty),
                        '$created_at'
                    FROM mlm_stokis_deposit_cart c
                    LEFT JOIN mlm_stokis_member sm ON c.id_stokis = sm.id
                    LEFT JOIN mlm_stokis_paket ps ON sm.id_paket = ps.id
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id                    
                    WHERE c.id_stokis = '$id_stokis'
                    AND c.id_stokis_tujuan = '$id_stokis_tujuan'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        public function index($id_deposit){
            $sql = "SELECT 
                    dt.*, 
                    p.sku,
                    p.qty*dt.qty as total_produk,
                    p.satuan,
                    CONCAT_WS(' ', j.name, ' - ', p.nama_produk, p.qty, p.satuan) AS nama_produk_detail,
                    CONCAT_WS(' ', p.sku, ' - ', p.nama_produk) AS nama_produk_sku
                    FROM mlm_stokis_deposit_detail dt
                    LEFT JOIN mlm_produk p ON dt.id_produk = p.id 
                    LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                    WHERE dt.id_deposit = '$id_deposit'
                    AND dt.deleted_at IS NULL
                    ORDER BY dt.id ASC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

    }
?>