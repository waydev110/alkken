<?php
require_once "classConnection.php";

class classMemberPoinPasangan
{
    public function history($id_kodeaktivasi, $type)
    {
        $sql = "SELECT p.poin, p.created_at, m.id_member, m.nama_member, m.level 
                    FROM mlm_member_poin_pasangan p
                    LEFT JOIN mlm_member m ON p.id_member = m.id
                    WHERE p.type = '$type' 
                    AND p.status = 'd' 
                    AND p.id_kodeaktivasi = '$id_kodeaktivasi'
                    ORDER BY p.id ASC";
                    // echo $sql;
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }
}
