<?php
    require_once 'Model.php';     // File Model

    class StokisPaket extends Model{
        protected $table = 'mlm_stokis_paket';

        public function fee_stokis($persentase_fee, $jumlah){
            $fee_stokis = floor($persentase_fee/100*$jumlah);
            return $fee_stokis;
        }
    }
?>