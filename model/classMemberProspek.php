<?php 
require_once 'classConnection.php';

class classMemberProspek{    
    public function index($sponsor_id)
    {
        $sql = "SELECT 
                    m.id,
                    m.nama_member,
                    m.nama_samaran,
                    m.hp_member,
                    m.id_produk,
                    m.sponsor,
                    m.nominal,
                    s.id_member as id_sponsor,
                    s.nama_samaran as nama_samaran_sponsor,
                    s.nama_member as nama_sponsor,
                    s.hp_member as hp_sponsor,
                    p.nama_produk,
                    m.created_at
                    FROM mlm_member_prospek m
                    JOIN mlm_member s ON m.sponsor = s.id
                    JOIN mlm_produk p ON m.id_produk = p.id
                    WHERE
                    m.sponsor = '$sponsor_id'
                    AND m.status_member = '0' 
                    AND m.deleted_at is null ORDER BY m.created_at ASC";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function show($id, $sponsor_id)
    {
        $sql = "SELECT 
                    m.id,
                    m.nama_member,
                    m.nama_samaran,
                    m.hp_member,
                    m.id_produk,
                    m.sponsor,
                    s.id_member as id_sponsor,
                    s.nama_samaran as nama_samaran_sponsor,
                    s.nama_member as nama_sponsor,
                    s.hp_member as hp_sponsor,
                    m.created_at
                    FROM mlm_member_prospek m
                    JOIN mlm_member s ON m.sponsor = s.id
                    WHERE m.id = '$id' 
                    AND m.sponsor = '$sponsor_id'
                    AND m.status_member = '0' 
                    AND m.deleted_at is null
                    LIMIT 1";
                    // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function cek_member_prospek($id, $id_sponsor)
    {
        $sql = "SELECT 
                    m.id,
                    m.nama_member,
                    m.nama_samaran,
                    m.hp_member,
                    m.id_produk,
                    m.sponsor,
                    s.id_member as id_sponsor,
                    s.nama_samaran as nama_samaran_sponsor,
                    s.nama_member as nama_sponsor,
                    s.hp_member as hp_sponsor,
                    m.created_at
                    FROM mlm_member_prospek m
                    LEFT JOIN mlm_member s ON m.sponsor = s.id
                    WHERE m.id = '$id_member' 
                    AND m.sponsor = '$id_sponsor'
                    AND m.deleted_at is null
                    LIMIT 1";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }
    public function update($sponsor, $id){
        $sql = "UPDATE mlm_member_prospek m 
                SET status_member = '1'
                WHERE m.sponsor = '$sponsor' AND m.id = '$id' AND m.status_member = '0'";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
    }
}