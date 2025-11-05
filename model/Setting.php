<?php
    require_once 'Model.php';

    class Setting extends Model{
        protected $table = 'mlm_admin_configs';
    
        public function show($part){
            $sql = "SELECT value FROM mlm_admin_configs WHERE part = :part LIMIT 1";

            $query = $this->rawQuery($sql, [
                'part' => $part            
            ]);

            $result = $query[0] ?? '';
            return $result->value ?? '';
        }
    }
?>