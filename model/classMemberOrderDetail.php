<?php
    require_once 'classConnection.php';

    class classMemberOrderDetail{
        public function create($id_member, $id_order, $created_at){
            $sql = "INSERT INTO mlm_member_order_detail (
                        id_order, 
                        id_produk, 
                        nama_produk, 
                        hpp, 
                        harga, 
                        qty, 
                        jumlah,
                        created_at
                    ) SELECT 
                        '$id_order',
                        c.id_produk,
                        p.nama_produk,
                        p.hpp,
                        p.harga,
                        c.qty,
                        p.harga*c.qty,
                        '$created_at'
                    FROM mlm_cart c
                    JOIN mlm_produk p ON c.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL
                    ";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        public function index($id_order){
            $sql  = "SELECT dt.*,
                        p.nama_produk,
                        p.gambar,
                        p.sku,
                        p.qty*dt.qty as total_produk,
                        p.satuan,
                        CONCAT_WS(' ', j.name, ' - ', p.nama_produk, p.qty, p.satuan) AS nama_produk_detail
                        FROM mlm_member_order_detail dt
                        LEFT JOIN mlm_produk p ON dt.id_produk = p.id 
                        LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id                         
                        WHERE dt.id_order = '$id_order'
                        AND dt.deleted_at IS NULL
                        ORDER BY dt.id ASC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        public function show_order($id_order, $id_member){
            $sql  = "SELECT dt.*,
                        CONCAT_WS(' ', j.name, ' - ', p.nama_produk, p.qty, p.satuan) AS nama_produk_detail,
                        p.gambar, 
                        p.bonus_sponsor,
                        p.bonus_cashback,
                        p.bonus_generasi,
                        p.bonus_upline,
                        p.bonus_sponsor_monoleg,
                        p.nilai_produk, 
                        p.poin_pasangan,
                        p.poin_reward,
                        p.fee_founder,
                        p.fee_stokis, 
                        p.satuan, 
                        j.name
                        FROM mlm_member_order_detail dt
                        JOIN mlm_member_order o ON dt.id_order = o.id
                        LEFT JOIN mlm_produk p ON dt.id_produk = p.id 
                        LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id                         
                        WHERE o.id = '$id_order'
                        AND o.id_member = '$id_member'
                        AND o.deleted_at IS NULL
                        AND o.status = '3'
                        ORDER BY dt.id ASC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function total_hu($id_order){
            $sql  = "SELECT COALESCE(SUM(total_hu), 0) AS total_hu
                        FROM mlm_member_order_detail
                        WHERE id_order = '$id_order'
                        AND deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total_hu;
        }
        public function benefit_produk($id_order){
            $sql  = "SELECT COALESCE(SUM(total_hu), 0) AS jumlah_hu,
                        COALESCE(SUM(bonus_poin), 0) AS bonus_poin,
                        COALESCE(SUM(bonus_generasi), 0) AS bonus_generasi
                        FROM mlm_member_order_detail
                        WHERE id_order = '$id_order'
                        AND deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query;
        }


        public function delete($id_order){
            $sql  = "DELETE FROM mlm_member_order_detail WHERE id_order = '$id_order'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>