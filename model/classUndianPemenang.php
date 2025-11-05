<?php 
require_once 'classConnection.php';

class classUndianPemenang{
    private $id_member;
    private $kupon_id;
    private $jenis_kupon;
    private $periode;
    private $doorprize;
    private $status_transfer;
    private $created_at;
    private $updated;
    private $deleted_at;

    public function get_id_member(){
		return $this->id_member;
	}

	public function set_id_member($id_member){
		$this->id_member = $id_member;
	}
    
    public function get_kupon_id(){
		return $this->kupon_id;
	}

	public function set_kupon_id($kupon_id){
		$this->kupon_id = $kupon_id;
	}
    
    public function get_jenis_kupon(){
		return $this->jenis_kupon;
	}

	public function set_jenis_kupon($jenis_kupon){
		$this->jenis_kupon = $jenis_kupon;
	}
    
    public function get_periode(){
		return $this->periode;
	}

	public function set_periode($periode){
		$this->periode = $periode;
	}
    
    public function get_doorprize(){
		return $this->doorprize;
	}

	public function set_doorprize($doorprize){
		$this->doorprize = $doorprize;
	}
    
    public function get_status_transfer(){
		return $this->status_transfer;
	}

	public function set_status_transfer($status_transfer){
		$this->status_transfer = $status_transfer;
	}
    
    public function get_created_at(){
		return $this->created_at;
	}

	public function set_created_at($created_at){
		$this->created_at = $created_at;
	}
    
    public function get_updated(){
		return $this->updated;
	}

	public function set_updated($updated){
		$this->updated = $updated;
	}
    
    public function get_deleted_at(){
		return $this->deleted_at;
	}

	public function set_deleted_at($deleted_at){
		$this->deleted_at = $deleted_at;
	}
    
    public function create()
    {
        $sql 	= "INSERT INTO mlm_undian_pemenang(
                        id_member,
                        kupon_id,
                        jenis_kupon,
                        periode,
                        doorprize,
                        status_transfer,
                        created_at
                    ) 
                    values (
                        '".$this->get_id_member()."',
                        '".$this->get_kupon_id()."',
                        '".$this->get_jenis_kupon()."',
                        '".$this->get_periode()."',
                        '".$this->get_doorprize()."',
                        '".$this->get_status_transfer()."',
                        '".$this->get_created_at()."'
                    )";
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }

	public function show_pemenang($jenis_kupon, $periode){
		$sql  = "SELECT k.* FROM mlm_undian_pemenang k
                    WHERE k.jenis_kupon = '$jenis_kupon' 
                    AND k.periode = '$periode'";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function index($jenis_kupon){
		$sql  = "SELECT * FROM mlm_undian_pemenang k
                    LEFT JOIN mlm_undian_periode p ON k.periode = p.id
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    WHERE k.jenis_kupon = '$jenis_kupon'
                    AND k.status_transfer = '0'
                    ORDER BY k.created_at DESC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function index_transfer($jenis_kupon){
		$sql  = "SELECT k.id, m.id_member, m.nama_member, k.doorprize, p.start_date, p.end_date, k.created_at FROM mlm_undian_pemenang k
                    LEFT JOIN mlm_undian_periode p ON k.periode = p.id
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    WHERE k.jenis_kupon = '$jenis_kupon'
                    AND k.status_transfer = '0'
                    ORDER BY k.created_at DESC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function index_laporan($jenis_kupon){
		$sql  = "SELECT * FROM mlm_undian_pemenang k
                    LEFT JOIN mlm_undian_periode p ON k.periode = p.id
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    WHERE k.jenis_kupon = '$jenis_kupon'
                    AND k.status_transfer = '1'
                    ORDER BY k.created_at DESC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

    public function update_transfer($id, $updated)
    {
        $sql = "UPDATE mlm_undian_pemenang 
                SET updated = '$updated', status_transfer = '1'
                WHERE id = '$id' AND status_transfer = '0'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

	public function show_master($id){
		$sql  = "SELECT k.* FROM mlm_undian_master k
                    WHERE k.id = '$id'";
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
        return $query;
	}
}