<?php

    require_once 'Model.php';     // File Model
    
    class StokisDeposit extends Model{
        protected $table = 'mlm_stokis_deposit';
        protected $fillable = [
            'id',
            'id_stokis',
            'subtotal',
            'diskon',
            'nominal',
            'status',
            'id_stokis_tujuan',
            'id_admin',
            'keterangan',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
        
    }
?>