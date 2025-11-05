<?php
    require_once 'Model.php';

    class RekeningPerusahaan extends Model{
        protected $table = 'mlm_rekening_perusahaan';

        public function index(){
            $sql  = "SELECT r.*, b.logo, b.kode_bank, b.nama_bank 
                        FROM mlm_rekening_perusahaan r
                        LEFT JOIN mlm_bank b
                        ON r.id_bank = b.id
                        WHERE r.deleted_at IS NULL ORDER BY r.id ASC";
            return $this->rawQuery($sql);
        }
    }
?>