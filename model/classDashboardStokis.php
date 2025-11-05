<?php
    require_once 'classConnection.php';
    class classDashboardStokis{
        public function pin_order($id_stokis){
            $sql  = "SELECT COUNT(*) AS total FROM mlm_stokis_jual_pin 
                        WHERE id_stokis = '$id_stokis' AND deleted_at IS NULL";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query->total;
        }
        
        public function saldo($id_stokis){
            $sql  = "SELECT (COALESCE(SUM(CASE WHEN status = 'd'
                                THEN nominal
                                ELSE 0 
                                END), 0) - 
                            COALESCE(SUM(CASE WHEN status = 'k'
                                THEN nominal
                                ELSE 0 
                                END), 0)) AS saldo
                             FROM mlm_stokis_wallet 
                        WHERE id_stokis = '$id_stokis' AND deleted_at IS NULL";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            if($query){
                return $query->saldo;
            }
            return 0;
        }
        
        public function stok_produk($id_stokis, $status = ''){
            $sql  = "SELECT COALESCE(SUM(CASE WHEN status = 'd'
                                THEN qty
                                ELSE 0 
                                END), 0) AS debet,
                            COALESCE(SUM(CASE WHEN status = 'k'
                                THEN qty
                                ELSE 0 
                                END), 0) AS kredit
                             FROM mlm_stokis_produk 
                        WHERE id_stokis = '$id_stokis' AND deleted_at IS NULL";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            if($query){
                switch ($status) {
                    case 'debet':
                        return $query->debet;
                        break;
                    case 'kredit':
                        return $query->kredit;
                        break;
                    
                    default:
                        return $query->debet-$query->kredit;
                        break;
                }
            }
            return 0;
        }
    }
?>