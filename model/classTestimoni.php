<?php 
require_once 'classConnection.php';

class classTestimoni{
	private $approved;
	private $testimoni;
	private $id_member;
	private $created_at;

	public function get_approved(){
		return $this->approved;
	}

	public function set_approved($approved){
		$this->approved = $approved;
	}
	public function get_testimoni(){
		return $this->testimoni;
	}

	public function set_testimoni($testimoni){
		$this->testimoni = $testimoni;
	}

	public function get_id_member(){
		return $this->id_member;
	}

	public function set_id_member($id_member){
		$this->id_member = $id_member;
	}

	public function get_created_at(){
		return $this->created_at;
	}

	public function set_created_at($created_at){
		$this->created_at = $created_at;
	}

	public function index(){
		$sql 	= "SELECT t.*,m.id_member, m.nama_samaran, p.nama_plan, p.gambar from mlm_testimoni t LEFT JOIN mlm_member m ON t.id_member = m.id LEFT JOIN mlm_plan p ON m.id_plan = p.id where t.deleted_at is null ORDER BY t.id DESC";
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
	}

	public function hide($id){
		$sql = "UPDATE mlm_testimoni SET approved = '".$this->get_approved()."' WHERE id='$id'";
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
	}

	public function index_member($start = 0){
        $sql 	= "SELECT t.*, m.id_member, m.nama_samaran, pl.nama_plan, pl.gambar 
                    FROM mlm_testimoni t 
                    JOIN mlm_member m ON t.id_member = m.id 
                    LEFT JOIN mlm_plan pl ON m.id_plan = pl.id where t.approved = '1' 
                    AND t.deleted_at is null ORDER BY t.id DESC LIMIT $start, 10";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
	}

	public function show_all(){
		$sql 	= "SELECT t.*,m.id_member, m.nama_samaran, pl.nama_plan, pl.gambar from mlm_testimoni t LEFT JOIN mlm_member m ON t.id_member = m.id LEFT JOIN mlm_plan pl ON m.id_plan = pl.id where t.approved = '1' and t.deleted_at is null ORDER BY t.id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
	}
	
	public function count(){
		$sql 	= "SELECT t.*,m.id_member, m.nama_samaran, pl.nama_plan, pl.gambar from mlm_testimoni t LEFT JOIN mlm_member m ON t.id_member = m.id LEFT JOIN mlm_plan pl ON m.id_plan = pl.id where t.approved = '1' and t.deleted_at is null ORDER BY t.id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
		if($query){
			return $query->num_rows;
		}else{
			return false;
		}
	}

	public function loadmore($id){
		$sql 	= "SELECT t.*,m.id_member, m.nama_samaran, pl.nama_plan, pl.gambar from mlm_testimoni t LEFT JOIN mlm_member m ON t.id_member = m.id LEFT JOIN mlm_plan pl ON m.id_plan = pl.id LEFT JOIN mlm_setbonusreward e ON m.id_peringkat = e.id where t.approved = '1' and  t.id < '$id' and t.deleted_at is null ORDER BY t.id DESC LIMIT 5";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
	}

	public function create(){
		$testimoni = $this->get_testimoni();
		$id_member = $this->get_id_member();
		$created_at = $this->get_created_at();
		$approved = 1;
		$sql = "INSERT INTO mlm_testimoni (testimoni, id_member, created_at, approved) VALUES ('$testimoni', '$id_member', '$created_at', '$approved')";
		// echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
	}
}