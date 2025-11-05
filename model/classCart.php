<?php 
require_once 'classConnection.php';

class classCart{

    private $id;
    private $id_member;
    private $id_stokis;
    private $id_produk;
    private $qty;
    private $status;
    private $checked;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function get_id(){
		return $this->id;
	}

	public function set_id($id){
		$this->id = $id;
	}

	public function get_id_member(){
		return $this->id_member;
	}

	public function set_id_member($id_member){
		$this->id_member = $id_member;
	}

	public function get_id_stokis(){
		return $this->id_stokis;
	}

	public function set_id_stokis($id_stokis){
		$this->id_stokis = $id_stokis;
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
    
    public function get_checked(){
		return $this->checked;
	}

	public function set_checked($checked){
		$this->checked = $checked;
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

    public function total_order($id_member){
        $sql  = "SELECT COALESCE(SUM(p.harga*c.qty),0) AS total
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    
                    WHERE c.id_member = '$id_member'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function order($id_member){
        $sql  = "SELECT COALESCE(SUM(p.harga*c.qty), 0) AS nominal
                    FROM mlm_cart c
                    JOIN mlm_produk p ON c.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function group_by_stokis($id_member){
        $sql  = "SELECT c.id_stokis, COALESCE(SUM(p.harga*c.qty), 0) AS nominal
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    
                    WHERE c.id_member = '$id_member'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL
                    GROUP BY c.id_stokis
                    ORDER BY c.id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function stokis($id_member){
        $sql  = "SELECT s.* 
                    FROM mlm_cart c
                    LEFT JOIN mlm_stokis_member s
                    ON c.id_stokis = s.id
                    WHERE c.id_member = '$id_member'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL
                    GROUP BY s.id_stokis";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function stokis_checkout($id_member){
        $sql  = "SELECT s.* 
                    FROM mlm_cart c
                    LEFT JOIN mlm_stokis_member s
                    ON c.id_stokis = s.id
                    WHERE c.id_member = '$id_member'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL
                    GROUP BY s.id_stokis";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function index($id_member, $id_stokis = ''){
        $sql  = "SELECT c.*, p.nama_produk, p.gambar, p.harga
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p
                    ON c.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND CASE WHEN LENGTH('$id_stokis') > 0 THEN c.id_stokis = '$id_stokis' ELSE 1 END
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function index_checkout($id_member, $id_stokis = ''){
        $sql  = "SELECT c.*, p.nama_produk, p.gambar, p.harga 
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p
                    ON c.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND CASE WHEN LENGTH('$id_stokis') > 0 THEN c.id_stokis = '$id_stokis' ELSE 1 END
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function checkout($id_member){
        $sql  = "SELECT c.*, p.nama_produk, p.gambar, p.harga 
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p
                    ON c.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function show($id){
        $sql  = "SELECT c.*, p.nama_produk, p.gambar, p.harga
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p
                    ON c.id_produk = p.id
                    WHERE c.id = '$id'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function show_by_stokis($id_stokis){
        $sql  = "SELECT c.*, p.nama_produk, p.gambar, p.harga 
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p
                    ON c.id_produk = p.id
                    WHERE c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }


    public function create(){
        $sql  = "INSERT INTO mlm_cart (
                    id_member, 
                    id_stokis, 
                    id_produk, 
                    qty, 
                    status, 
                    created_at
                ) VALUES (
                    '".$this->get_id_member()."', 
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
        $sql  = "UPDATE mlm_cart SET
                    qty = qty+".$this->get_qty().", 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id_member = '".$this->get_id_member()."'
                    AND id_produk = '".$this->get_id_produk()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_qty(){
        $sql  = "UPDATE mlm_cart SET
                    qty = '".$this->get_qty()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_member = '".$this->get_id_member()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_check(){
        $sql  = "UPDATE mlm_cart SET
                    checked = '".$this->get_checked()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_member = '".$this->get_id_member()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_check_by_stokis(){
        $sql  = "UPDATE mlm_cart SET
                    checked = '".$this->get_checked()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id_stokis = '".$this->get_id_stokis()."'
                    AND id_member = '".$this->get_id_member()."'
                    AND status = '0'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_status(){
        $sql  = "UPDATE mlm_cart SET
                    status = '".$this->get_status()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE checked = '".$this->get_checked()."'
                    AND status = '0'
                    AND id_member = '".$this->get_id_member()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function delete(){
        $sql  = "UPDATE mlm_cart SET
                    deleted_at = '".$this->get_deleted_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_member = '".$this->get_id_member()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }


    public function total_cart($id_member){
        $sql  = "SELECT COUNT(*) AS total 
                    FROM mlm_cart 
                    WHERE id_member = '$id_member'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function total_harga($id_member){
        $sql  = "SELECT COALESCE(SUM(p.harga*c.qty),0) AS total_harga 
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total_harga;
    }

    public function cek_keranjang($id_member, $id_produk){
        $sql  = "SELECT COUNT(*) AS total 
                    FROM mlm_cart 
                    WHERE id_member = '$id_member'
                    AND id_produk = '$id_produk'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
}