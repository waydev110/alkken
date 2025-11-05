<?php
    require_once 'Model.php';     // File Model

    class Produk extends Model{
        protected $table = 'mlm_produk';

        public function get_produk($keyword){
            $sql  = "SELECT 
                        p.*, 
                        pj.name,
                        COALESCE(GROUP_CONCAT(pl.nama_plan SEPARATOR ', '), '') AS plan_produk
                    FROM mlm_produk p 
                    LEFT JOIN mlm_produk_plan pp ON pp.id_produk = p.id
                    LEFT JOIN mlm_plan pl ON pp.id_plan = pl.id 
                    LEFT JOIN mlm_produk_jenis pj ON p.id_produk_jenis = pj.id 
                    WHERE p.nama_produk LIKE '%$keyword%' 
                    AND p.tampilkan = '1'
                    AND p.deleted_at IS NULL
                    GROUP BY p.id 
                    ORDER BY p.nama_produk ASC";
            return $this->rawQuery($sql);
        }
    }
?>