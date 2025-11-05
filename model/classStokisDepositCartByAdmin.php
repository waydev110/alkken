<?php 
require_once 'classConnection.php';

class classStokisDepositCartByAdmin{

    private $id;
    private $id_stokis;
    private $id_admin;
    private $id_produk;
    private $qty;
    private $status;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function get_id(){
		return $this->id;
	}

	public function set_id($id){
		$this->id = $id;
	}

	public function get_id_stokis(){
		return $this->id_stokis;
	}

	public function set_id_stokis($id_stokis){
		$this->id_stokis = $id_stokis;
	}

	public function get_id_admin(){
		return $this->id_admin;
	}

	public function set_id_admin($id_admin){
		$this->id_admin = $id_admin;
	}

	public function get_id_produk(){
		return $this->id_produk;
	}

	public function set_id_produk($id_produk){
		$this->id_produk = $id_produk;
	}

	public function get_qty(){
		return $this->qty;
	}

	public function set_qty($qty){
		$this->qty = $qty;
	}
    
    public function get_status(){
		return $this->status;
	}

	public function set_status($status){
		$this->status = $status;
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

    public function create(){
        $sql  = "INSERT INTO mlm_stokis_deposit_cart_by_admin (
                    id_admin, 
                    id_stokis, 
                    id_produk, 
                    qty, 
                    status, 
                    created_at
                ) VALUES (
                    '".$this->get_id_admin()."', 
                    '".$this->get_id_stokis()."', 
                    '".$this->get_id_produk()."', 
                    '".$this->get_qty()."',  
                    '".$this->get_status()."', 
                    '".$this->get_created_at()."'
                )";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function update(){
        $sql  = "UPDATE mlm_stokis_deposit_cart_by_admin SET
                    qty = qty+'".$this->get_qty()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id_stokis = '".$this->get_id_stokis()."'
                    AND id_produk = '".$this->get_id_produk()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_qty(){
        $sql  = "UPDATE mlm_stokis_deposit_cart_by_admin SET
                    qty = '".$this->get_qty()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_stokis = '".$this->get_id_stokis()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function update_status(){
        $sql  = "UPDATE mlm_stokis_deposit_cart_by_admin SET
                    status = '".$this->get_status()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE status = '0'
                    AND id_stokis = '".$this->get_id_stokis()."'
                    AND id_admin = '".$this->get_id_admin()."'
                    AND deleted_at IS NULL
                    ";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function delete(){
        $sql  = "UPDATE mlm_stokis_deposit_cart_by_admin SET
                    deleted_at = '".$this->get_deleted_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_stokis = '".$this->get_id_stokis()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }


    public function total_cart($id_stokis){
        $sql  = "SELECT COUNT(*) AS total 
                    FROM mlm_stokis_deposit_cart_by_admin 
                    WHERE id_stokis = '$id_stokis'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function total_harga($id_stokis){
        $sql  = "SELECT COALESCE(SUM(p.harga*c.qty),0) AS total_harga 
                    FROM mlm_stokis_deposit_cart_by_admin c
                    LEFT JOIN mlm_produk_harga p ON c.id_produk = p.id
                    WHERE c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total_harga;
    }

    public function cek_keranjang($id_stokis, $id_produk){
        $sql  = "SELECT COUNT(*) AS total 
                    FROM mlm_stokis_deposit_cart_by_admin 
                    WHERE id_stokis = '$id_stokis'
                    AND id_produk = '$id_produk'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    public function get_cart($id_stokis, $id_admin){
        $sql  = "SELECT c.*, p.gambar, p.nama_produk, p.harga
                    FROM mlm_stokis_deposit_cart_by_admin c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    
                    WHERE c.id_stokis = '$id_stokis'
                    AND c.id_admin = '$id_admin'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL
                    ORDER BY c.id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function delete_cart($id_stokis, $id_admin){
        $sql  = "DELETE FROM mlm_stokis_deposit_cart_by_admin 
                    WHERE id_stokis = '$id_stokis'
                    AND id_admin = '$id_admin'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function total_order($id_stokis, $id_admin){
        $sql  = "SELECT COALESCE(SUM(p.harga*c.qty),0) AS total
                    FROM mlm_stokis_deposit_cart_by_admin c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    
                    WHERE c.id_stokis = '$id_stokis'
                    AND c.id_admin = '$id_admin'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
}