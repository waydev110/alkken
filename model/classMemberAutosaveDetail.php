<?php
    require_once 'classConnection.php';

    class classMemberAutosaveDetail{
        public function create($id_member, $id_stokis, $id_order, $created_at){
            $sql = "INSERT INTO mlm_member_autosave_detail (
                        id_order, 
                        id_produk, 
                        jenis_produk,
                        nama_produk, 
                        hpp, 
                        harga, 
                        qty, 
                        jumlah, 
                        created_at
                    ) SELECT 
                        '$id_order',
                        c.id_produk,
                        p.id_produk_jenis,
                        p.nama_produk,
                        p.hpp,
                        p.harga,
                        c.qty,
                        p.harga*c.qty,
                        '$created_at'
                    FROM mlm_cart_autosave c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id                    
                    WHERE c.id_member = '$id_member'
                    AND c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL
                    ";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function create_detail($id_order, $qty, $harga, $created_at){
            $sql = "INSERT INTO mlm_member_autosave_detail (
                        id_order, 
                        id_produk, 
                        nama_produk, 
                        jumlah_hu, 
                        hpp, 
                        harga, 
                        qty, 
                        jumlah,
                        total_hu, 
                        poin_reward, 
                        bonus_generasi, 
                        created_at
                    ) VALUES ( 
                        '$id_order',
                        2,
                        2, 
                        'Parfum',
                        1,
                        0,
                        330000,
                        $qty,
                        330000*$qty,
                        $qty,
                        0,
                        1000,
                        '$created_at'
                    )";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function index($id_order){
            $sql  = "SELECT dt.*, p.gambar, p.nama_produk
                        FROM mlm_member_autosave_detail dt
                        LEFT JOIN mlm_produk p ON dt.id_produk = p.id 
                        
                        WHERE dt.id_order = '$id_order'
                        AND dt.deleted_at IS NULL
                        ORDER BY dt.id ASC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function total_hu($id_order){
            $sql  = "SELECT COALESCE(SUM(total_hu), 0) AS total_hu
                        FROM mlm_member_autosave_detail
                        WHERE id_order = '$id_order'
                        AND deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total_hu;
        }
        public function benefit_produk($id_order){
            $sql  = "SELECT COALESCE(SUM(total_hu), 0) AS jumlah_hu,
                        COALESCE(SUM(poin_reward), 0) AS poin_reward,
                        COALESCE(SUM(bonus_generasi), 0) AS bonus_generasi
                        FROM mlm_member_autosave_detail
                        WHERE id_order = '$id_order'
                        AND deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query;
        }

        public function get_order_detail($id_order){
            $sql  = "SELECT c.*, 
                            p.gambar, 
                            p.nama_produk,
                            p.hpp, 
                            p.harga,
                            0 as jumlah_hu,
                            0 as poin_reward,
                            p.bonus_sponsor,
                            p.bonus_cashback,
                            p.bonus_generasi,
                            p.bonus_sponsor_monoleg,
                            p.bonus_poin_cashback,
                            p.fee_stokis
                        FROM mlm_member_autosave_detail c
                        LEFT JOIN mlm_produk p ON c.id_produk = p.id 
                        
                        WHERE c.id_order = '$id_order'
                        AND c.deleted_at IS NULL
                        ORDER BY c.id ASC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }


        public function delete($id_order){
            $sql  = "DELETE FROM mlm_member_autosave_detail WHERE id_order = '$id_order'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>