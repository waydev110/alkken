<?php
require_once 'classConnection.php';

class classTransferKodeAktivasi {
    private $id_member_lama;
    private $id_member_baru;
    private $id_kodeaktivasi;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function get_id_member_lama(){
		return $this->id_member_lama;
	}

	public function set_id_member_lama($id_member_lama){
		$this->id_member_lama = $id_member_lama;
	}
	public function get_id_member_baru(){
		return $this->id_member_baru;
	}

	public function set_id_member_baru($id_member_baru){
		$this->id_member_baru = $id_member_baru;
	}
	public function get_id_kodeaktivasi(){
		return $this->id_kodeaktivasi;
	}

	public function set_id_kodeaktivasi($id_kodeaktivasi){
		$this->id_kodeaktivasi = $id_kodeaktivasi;
	}
	public function get_created_at(){
		return $this->created_at;
	}

	public function set_created_at($created_at){
		$this->created_at = $created_at;
	}
	public function get_updated_at(){
		return $this->updated_at;
	}

	public function set_updated_at($updated_at){
		$this->updated_at = $updated_at;
	}
	public function get_deleted_at(){
		return $this->deleted_at;
	}

	public function set_deleted_at($deleted_at){
		$this->deleted_at = $deleted_at;
	}
    
    public function transfer($id){
        $sql  = "SELECT tk.*, k.jumlah_hu, k.harga FROM mlm_kodeaktivasi_transfer tk 
				LEFT JOIN mlm_kodeaktivasi k ON tk.id_kodeaktivasi = k.id 
                WHERE id_member_lama = '$id' AND deleted_at is null ORDER BY id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function terima($id){
        $sql  = "SELECT tk.*, k.jumlah_hu, k.harga FROM mlm_kodeaktivasi_transfer tk 
				LEFT JOIN mlm_kodeaktivasi k ON tk.id_kodeaktivasi = k.id 
                WHERE id_member_baru = '$id' AND deleted_at is null ORDER BY id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
	public function create(){
		$sql 	= "INSERT INTO mlm_kodeaktivasi_transfer (
                        id_member_lama, 
                        id_member_baru, 
                        id_kodeaktivasi, 
                        created_at
                    ) values (
                        '".$this->get_id_member_lama()."', 
                        '".$this->get_id_member_baru()."', 
                        '".$this->get_id_kodeaktivasi()."', 
                        '".$this->get_created_at()."'
                    )
                    ";
		$c 		= new classConnection();
		$query 	= $c->_query_insert($sql);
		return $query;
	}

	public function destroy($id){
		$sql  = "DELETE FROM mlm_kodeaktivasi_transfer WHERE id = '$id'";		
		$c    = new classConnection();
		$query  = $c->_query($sql);
		return $query;
	}

	public function history($id_kodeaktivasi){
		$sql  = "SELECT t.created_at, 
                        m.id_member AS id_member_lama, 
                        m.nama_member AS nama_member_lama,
                        b.id_member AS id_member_baru,
                        b.nama_member AS nama_member_baru 
                    FROM mlm_kodeaktivasi_transfer t
                    LEFT JOIN mlm_member m ON t.id_member_lama = m.id
                    LEFT JOIN mlm_member b ON t.id_member_baru = b.id
                    WHERE t.id_kodeaktivasi = '$id_kodeaktivasi'";	
		$c    = new classConnection();
		$query  = $c->_query($sql);
		return $query;
	}
}