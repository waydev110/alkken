<?php
    require_once 'classConnection.php';

    class classStokisProduk{
        
        public function create_deposit($id_deposit, $id_stokis, $created_at){
            $sql = "INSERT INTO mlm_stokis_produk (
                        id_stokis, 
                        id_produk, 
                        type, 
                        status,
                        qty, 
                        id_relasi, 
                        asal_tabel, 
                        keterangan, 
                        created_at
                    ) SELECT 
                        '$id_stokis',
                        c.id_produk,
                        'deposit', 
                        'd',
                        c.qty,
                        c.id,
                        'mlm_stokis_deposit_detail',
                        'Deposit Order',
                        '$created_at'
                    FROM mlm_stokis_deposit_detail c
                    WHERE c.id_deposit = '$id_deposit'
                    AND c.deleted_at IS NULL
                    ";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function create($id_jual_pin, $id_stokis, $created_at){
            $sql = "INSERT INTO mlm_stokis_produk (
                        id_stokis, 
                        id_produk, 
                        type, 
                        status,
                        qty, 
                        id_relasi, 
                        asal_tabel, 
                        keterangan, 
                        created_at
                    ) SELECT 
                        '$id_stokis',
                        c.id_produk,
                        'jual_pin', 
                        'k',
                        c.qty,
                        c.id,
                        'mlm_stokis_jual_pin_detail',
                        'Penjualan',
                        '$created_at'
                    FROM mlm_stokis_jual_pin_detail c
                    WHERE c.id_jual_pin = '$id_jual_pin'
                    AND c.deleted_at IS NULL
                    ";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function create_transfer($id_transfer, $status, $id_stokis, $created_at){
            $sql = "INSERT INTO mlm_stokis_produk (
                        id_stokis, 
                        id_produk, 
                        type, 
                        status,
                        qty, 
                        id_relasi, 
                        asal_tabel, 
                        keterangan, 
                        created_at
                    ) SELECT 
                        '$id_stokis',
                        c.id_produk,
                        'transfer_stok', 
                        '$status',
                        c.qty,
                        c.id,
                        'mlm_stokis_transfer_detail',
                        'Transfer Stok',
                        '$created_at'
                    FROM mlm_stokis_transfer_detail c
                    WHERE c.id_transfer = '$id_transfer'
                    AND c.deleted_at IS NULL
                    ";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function create_order($id_deposit, $status, $id_stokis, $created_at){
            $sql = "INSERT INTO mlm_stokis_produk (
                        id_stokis, 
                        id_produk, 
                        type, 
                        status,
                        qty, 
                        id_relasi, 
                        asal_tabel, 
                        keterangan, 
                        created_at
                    ) SELECT 
                        '$id_stokis',
                        c.id_produk,
                        'order', 
                        '$status',
                        c.qty,
                        c.id,
                        'mlm_stokis_deposit_detail',
                        'Stokis Order',
                        '$created_at'
                    FROM mlm_stokis_deposit_detail c
                    WHERE c.id_deposit = '$id_deposit'
                    AND c.deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function create_member_order($id_order, $status, $id_stokis, $created_at){
            $sql = "INSERT INTO mlm_stokis_produk (
                        id_stokis, 
                        id_produk, 
                        type, 
                        status,
                        qty, 
                        id_relasi, 
                        asal_tabel, 
                        keterangan, 
                        created_at
                    ) SELECT 
                        '$id_stokis',
                        c.id_produk,
                        'member_order', 
                        '$status',
                        c.qty,
                        c.id,
                        'mlm_member_order_detail',
                        'Member Order',
                        '$created_at'
                    FROM mlm_member_order_detail c
                    WHERE c.id_order = '$id_order'
                    AND c.deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function produk_detail($id_deposit){
            $sql = "SELECT c.*
                        FROM mlm_stokis_deposit_detail c
                        WHERE c.id_deposit = '$id_deposit'
                        AND c.deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        
        public function index_jual_pin($id_stokis, $id_plan, $keyword, $jenis_plan =''){
            $sql  = "SELECT p.*, 
                        j.name,
                        (SELECT COALESCE(SUM(CASE 
                                WHEN ps.status = 'd' 
                                    THEN ps.qty
                                    ELSE 0 
                                END) - SUM(CASE 
                                WHEN ps.status = 'k' 
                                    THEN ps.qty
                                    ELSE 0 
                                END), 0)
                                FROM mlm_stokis_produk ps
                                WHERE ps.id_produk = p.id
                                AND ps.id_stokis = '$id_stokis'
                                AND ps.deleted_at IS NULL) AS jumlah_stock
                        FROM mlm_produk p
                        JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                        WHERE p.deleted_at IS NULL 
                        AND p.nama_produk LIKE '%$keyword%' 
                        AND p.id IN (SELECT id_produk FROM mlm_produk_plan WHERE id_plan = '$id_plan')
                        AND CASE WHEN LENGTH ('$jenis_plan') > 0 THEN j.id = '$jenis_plan' ELSE 1 END
                        HAVING jumlah_stock > 0
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
        
        public function index_transfer($id_stokis, $keyword){
            $sql  = "SELECT p.*,
                        j.name,
                        (SELECT COALESCE(SUM(CASE 
                                WHEN ps.status = 'd' 
                                    THEN ps.qty
                                    ELSE 0 
                                END) - SUM(CASE 
                                WHEN ps.status = 'k' 
                                    THEN ps.qty
                                    ELSE 0 
                                END), 0)
                                FROM mlm_stokis_produk ps
                                WHERE ps.id_produk = p.id
                                AND ps.id_stokis = '$id_stokis'
                                AND ps.deleted_at IS NULL) AS jumlah_stock
                        FROM mlm_produk p    
                        LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                        WHERE p.deleted_at IS NULL 
                        AND p.nama_produk LIKE '%$keyword%'
                        GROUP BY p.id 
                        HAVING jumlah_stock > 0
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_stok($id_stokis){
            $sql  = "SELECT 
                        p.*,
                        CONCAT_WS(' ', j.name, ' - ', p.nama_produk, p.qty, p.satuan) AS nama_produk_detail,
                        (SELECT COALESCE(SUM(CASE 
                                WHEN ps.status = 'd' 
                                    THEN ps.qty
                                    ELSE 0 
                                END) - SUM(CASE 
                                WHEN ps.status = 'k' 
                                    THEN ps.qty
                                    ELSE 0 
                                END), 0)
                                FROM mlm_stokis_produk ps
                                WHERE ps.id_produk = p.id
                                AND ps.id_stokis = '$id_stokis'
                                AND ps.deleted_at IS NULL) AS jumlah_stock
                        FROM mlm_produk p
                        LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                        WHERE p.deleted_at IS NULL
                        HAVING jumlah_stock > 0
                        ORDER BY p.id DESC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function mutasi_stok($id_stokis, $id_produk){
            if($id_produk <> ''){
                $id_produk = " AND ps.id_produk = '$id_produk'";
            }
            $sql  = "SELECT
                            p.sku,
                            CONCAT_WS(' ', j.name, ' - ', p.nama_produk, p.qty, p.satuan) AS nama_produk_detail,
                            ps.qty, 
                            ps.status, 
                            ps.keterangan, 
                            ps.created_at
                        FROM mlm_stokis_produk ps
                        LEFT JOIN mlm_produk p ON ps.id_produk = p.id 
                        LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                        WHERE ps.deleted_at IS NULL
                        AND ps.id_stokis = '$id_stokis'
                        $id_produk
                        ORDER BY ps.id DESC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function stok_produk($id_stokis, $id_produk){
            $sql = "SELECT COALESCE(SUM(CASE 
                    WHEN ps.status = 'd' 
                        THEN ps.qty
                        ELSE 0 
                    END) - SUM(CASE 
                    WHEN ps.status = 'k' 
                        THEN ps.qty
                        ELSE 0 
                    END), 0) AS stok_produk
                    FROM mlm_stokis_produk ps
                    WHERE ps.id_produk = '$id_produk'
                    AND ps.id_stokis = '$id_stokis'
                    AND ps.deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->stok_produk;
        }

        public function delete($id_deposit, $id_stokis, $status){
            $sql = "DELETE FROM mlm_stokis_produk sp
                        LEFT JOIN mlm_stokis_deposit_detail dd
                        ON sp.id_relasi = dd.id
                        WHERE sp.id_stokis = '$id_stokis'
                        AND sp.status = '$status'
                        AND dd.id_deposit = '$id_deposit'
                        AND sp.asal_tabel = 'mlm_stokis_deposit_detail'";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
    }
?>