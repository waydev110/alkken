<?php 
require_once 'classConnection.php';

class classBonusRoyaltiOmset{

    public function setting_bonus(){
        $sql = "SELECT * FROM mlm_peringkat
                WHERE percent_royalti > 0";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function omset($bulan, $budget){
        $sql = "SELECT COALESCE(SUM(k.poin_reward*$budget), 0) AS omset 
                    FROM mlm_kodeaktivasi_history h 
                    JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id 
                    WHERE k.jenis_aktivasi = 14
                    AND LEFT(h.created_at, 7) = '$bulan'";
        $c    = new classConnection(); 
        $query  = $c->_query_fetch($sql);
        return $query->omset;
    }
    
    public function total_member_peringkat($last_date, $id_peringkat){
        $sql = "SELECT COUNT(*) AS total 
                    FROM mlm_member_peringkat 
                    WHERE peringkat = '$id_peringkat'
                    AND DATE(created_at) <= '$last_date'
                    AND id_member IN (
                        SELECT h.id_member 
                        FROM mlm_kodeaktivasi_history h
                        JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id 
                        WHERE k.jenis_aktivasi = 14
                        AND DATE_FORMAT(h.created_at, '%Y-%m') = DATE_FORMAT('$last_date', '%Y-%m')
                    )";
        $c    = new classConnection(); 
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    
    public function create_rekap($last_date, $id_peringkat, $total_omset, $persentase, $total_bonus, $total_member, $nominal_bonus, $keterangan, $created_at){
        $sql = "
                INSERT INTO mlm_bonus_royalti_omset_rekap
                    (
                        tgl_rekap,
                        id_peringkat,
                        total_omset,
                        persentase,
                        total_bonus,
                        total_member,
                        nominal_bonus,
                        keterangan,
                        created_at
                    ) VALUES (
                        '$last_date',
                        '$id_peringkat',
                        '$total_omset',
                        '$persentase',
                        '$total_bonus',
                        '$total_member',
                        '$nominal_bonus',
                        '$keterangan',
                        '$created_at'
                    )";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function create_bonus($last_date, $id_peringkat, $nominal_bonus, $created_at){
        $sql = "
                INSERT INTO mlm_bonus_royalti_omset
                    (
                        id_member, 
                        id_peringkat, 
                        bulan, 
                        nominal, 
                        admin, 
                        autosave, 
                        total, 
                        status_transfer, 
                        created_at
                    ) 
                    SELECT 
                        mp.id_member,
                        mp.peringkat,
                        '$last_date',
                        '$nominal_bonus',
                        '$nominal_bonus*0.025',
                        0,
                        '$nominal_bonus*0.975',
                        '0',
                        '$created_at'
                    FROM mlm_member_peringkat mp 
                    WHERE peringkat = '$id_peringkat'
                    AND LEFT(created_at, 10) <= '$last_date'
                    AND (id_member IN (
                        SELECT h.id_member 
                        FROM mlm_kodeaktivasi_history h
                        JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id 
                        WHERE k.jenis_aktivasi = 14
                        AND DATE_FORMAT(h.created_at, '%Y-%m') = DATE_FORMAT('$last_date', '%Y-%m')
                    ) OR id_member IN (1,2,3,17))";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

}
?>