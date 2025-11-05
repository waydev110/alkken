<?php 
require_once 'classConnection.php';

class classUndianKupon{

	public function index($jenis_kupon){
		$sql  = "SELECT m.id_member, m.nama_samaran, m.nama_member, m.hp_member, k.kupon_id, k.status, k.created_at 
                    FROM mlm_undian_kupon k
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    WHERE k.jenis_kupon = '$jenis_kupon' 
                    AND k.status = '0'
                    ORDER BY k.created_at DESC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function get_kupon_undian($jenis_kupon, $start_date, $end_date){
		$sql  = "SELECT k.kupon_id FROM mlm_undian_kupon k
                    WHERE k.jenis_kupon = '$jenis_kupon' 
                    AND LEFT(k.created_at, 10) >= '$start_date'
                    AND LEFT(k.created_at, 10) <= '$end_date'
                    AND k.status = '0'";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function update_kupon_undian($jenis_kupon, $start_date, $end_date){
		$sql  = "UPDATE mlm_undian_kupon k
                    SET k.status = '1', k.updated_at = NOW()
                    WHERE k.jenis_kupon = '$jenis_kupon' 
                    AND LEFT(k.created_at, 10) >= '$start_date'
                    AND LEFT(k.created_at, 10) <= '$end_date'
                    AND k.status = '0'";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function reset_kupon_undian($jenis_kupon, $start_date, $end_date){
		$sql  = "UPDATE mlm_undian_kupon k
                    SET k.status = '0', k.updated_at = NOW()
                    WHERE k.jenis_kupon = '$jenis_kupon' 
                    AND LEFT(k.created_at, 10) >= '$start_date'
                    AND LEFT(k.created_at, 10) <= '$end_date'
                    AND k.status = '1'";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function reset_pemenang_undian($jenis_kupon, $periode){
		$sql  = "DELETE FROM mlm_undian_pemenang
                    WHERE jenis_kupon = '$jenis_kupon' 
                    AND periode = '$periode'";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function total_kupon($jenis_kupon){
		$sql  = "SELECT COUNT(*) AS total FROM mlm_undian_kupon k
                    WHERE k.jenis_kupon = '$jenis_kupon' 
                    AND k.status = '0'";
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
        return $query->total;
	}
	public function show_undian($jenis_kupon){
		$sql  = "SELECT m.* FROM mlm_undian_master m 
                    WHERE m.id = '$jenis_kupon' AND m.status = '1'";
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
        return $query;
	}
	public function show_periode($jenis_undian){
		$sql  = "SELECT p.* FROM mlm_undian_periode p 
                    WHERE p.jenis_undian = '$jenis_undian' AND p.status = '1'";
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
        return $query;
	}
	public function show($kupon_id){
		$sql  = "SELECT k.*, m.doorprize FROM mlm_undian_kupon k
                    LEFT JOIN mlm_undian_master m ON k.jenis_kupon = m.id
                    WHERE k.kupon_id = '$kupon_id' 
                    AND k.status = '0'";
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
        return $query;
	}
	public function update($kupon_id, $created_at){
		$sql  = "UPDATE mlm_undian_kupon k
                    SET k.status = '1', k.updated_at = '$created_at'
                    WHERE k.kupon_id = '$kupon_id' 
                    AND k.status = '0'";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

}