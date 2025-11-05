<?php 
require_once 'classConnection.php';

class classBonusUnilevel{
    public function create($dari_member, $nominal_bonus, $bulan, $max, $max_autosave, $created_at){  
        $id_perusahaan = [
                            1,
                            17,
                            28,
                            32,
                            13313,
                        ];
        $log_file = '../../../log/bonus_unilevel/log-'.$bulan.'.txt';
        $log = '';      
        $c = new classConnection();   
        $sql ="CALL GenerasiSponsor($dari_member)";
        $query = $c->_query($sql);
        $total_record = $query->num_rows;
        $log .= "Total Generasi :".$total_record."\n\n";
        if($total_record > 0){
            $generasi = 1;
            while($row = $query->fetch_object()){
                $sponsor = $row->sponsor;
                $log .= "Sponsor :".$sponsor."\n";
                if($generasi > $max){
                    break;
                }
                // Jika sponsor adalah perusahaan, lewati cek_tutup_poin
                if (in_array($sponsor, $id_perusahaan)) {
                    $cek_tutup_poin = $max_autosave; // Anggap sudah mencukupi
                    $log .= "Sponsor termasuk id_perusahaan, lewati cek_tutup_poin\n";
                } else {
                    $cek_tutup_poin = $this->cek_tutup_poin($sponsor, $bulan);
                    $log .= "Total Autosave :".$cek_tutup_poin."\n";
                }
                if($cek_tutup_poin >= $max_autosave){    
                    $cek_bonus = $this->cek_bonus($sponsor, $dari_member, $bulan.'-01');   
                    $log .= "Cek Bonus :".$cek_bonus."\n";         
                    if($cek_bonus == 0){
                        $sql = "INSERT INTO mlm_bonus_unilevel (
                                id_member,
                                bulan,
                                nominal,
                                total,
                                generasi,
                                dari_member,
                                status_transfer,
                                created_at
                            ) values (
                                '$sponsor', 
                                '$bulan-01',       
                                '$nominal_bonus',
                                '$nominal_bonus',
                                '$generasi',     
                                '$dari_member',          
                                '0',     
                                '$created_at'
                            )";
                        // $log .= "SQL :".$sql."\n";
                        $create = $c->_query($sql);
                        if($create){
                            $log .= "Create Bonus Unilevel :".$nominal_bonus."\n";
                            $log .= "Generasi :".$generasi."\n";
                        }
                    }
                    $generasi++;
                } else {
                    $log .= "Autosave tidak mencukupi\n\n";
                }
            }
        }
        file_put_contents($log_file, $log, FILE_APPEND);
        return true;
    }

    public function cek_tutup_poin($id_member, $bulan)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN status = 'd'
                        THEN nominal
                        ELSE 0 
                    END),0) AS saldo
                    FROM mlm_wallet 
                    WHERE id_member = '$id_member' 
                    AND LEFT(created_at, 7) = '$bulan'
                    AND deleted_at IS NULL";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->saldo;
        }
        return 0;
    }

    public function cek_bonus($id_member, $dari_member, $bulan)
    {
        $sql = "SELECT COUNT(*) AS total 
                    FROM mlm_bonus_unilevel 
                    WHERE id_member = '$id_member' 
                    AND dari_member = '$dari_member'
                    AND bulan = '$bulan'
                    AND deleted_at IS NULL";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->total;
        }
        return 0;
    }

    public function update_status_transfer($bulan)
    {
        $sql = "UPDATE mlm_bonus_unilevel k
                JOIN mlm_member m ON k.id_member = m.id
                JOIN mlm_plan pl ON m.id_plan = pl.id
                LEFT JOIN (
                            SELECT id_member, 
                                   SUM(nominal) AS wallet_nominal, 
                                   LEFT(created_at, 7) AS wallet_month
                            FROM mlm_wallet
                            WHERE jenis_saldo = 'poin' 
                                  AND status = 'd' 
                                  AND deleted_at IS NULL
                            GROUP BY id_member, LEFT(created_at, 7)
                ) w ON k.id_member = w.id_member AND '$bulan' = w.wallet_month
                SET k.status_transfer = '0'
                WHERE k.status_transfer = '-1' 
                AND k.deleted_at IS NULL
                AND w.wallet_nominal >= pl.max_autosave";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->total;
        }
        return 0;
    }
}