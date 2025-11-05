<?php 
require_once 'classConnection.php';

class classStokisJualPinCart{

    private $id;
    private $id_member;
    private $id_stokis;
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
        $sql  = "INSERT INTO mlm_stokis_jual_pin_cart (
                    id_stokis, 
                    id_member, 
                    id_produk, 
                    qty, 
                    status, 
                    created_at
                ) VALUES (
                    '".$this->get_id_stokis()."', 
                    '".$this->get_id_member()."', 
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
        $sql  = "UPDATE mlm_stokis_jual_pin_cart SET
                    qty = qty+'".$this->get_qty()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id_member = '".$this->get_id_member()."'
                    AND id_produk = '".$this->get_id_produk()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_qty(){
        $sql  = "UPDATE mlm_stokis_jual_pin_cart SET
                    qty = '".$this->get_qty()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_member = '".$this->get_id_member()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function update_status(){
        $sql  = "UPDATE mlm_stokis_jual_pin_cart SET
                    status = '".$this->get_status()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE status = '0'
                    AND id_member = '".$this->get_id_member()."'
                    AND id_stokis = '".$this->get_id_stokis()."'
                    AND deleted_at IS NULL
                    ";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function delete(){
        $sql  = "UPDATE mlm_stokis_jual_pin_cart SET
                    deleted_at = '".$this->get_deleted_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_member = '".$this->get_id_member()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function cek_keranjang($id_member, $id_produk){
        $sql  = "SELECT COUNT(*) AS total 
                    FROM mlm_stokis_jual_pin_cart 
                    WHERE id_member = '$id_member'
                    AND id_produk = '$id_produk'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function cek_jenis_produk($id_member, $id_produk_jenis){
        $sql  = "SELECT COUNT(*) AS total 
                    FROM mlm_stokis_jual_pin_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND p.id_produk_jenis != '$id_produk_jenis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function jumlah_jenis_produk($id_member, $id_stokis){
        $sql  = "SELECT p.id_produk_jenis 
                    FROM mlm_stokis_jual_pin_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL
                    GROUP BY p.id_produk_jenis";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function keranjang($id_member, $id_produk){
        $sql  = "SELECT *
                    FROM mlm_stokis_jual_pin_cart 
                    WHERE id_member = '$id_member'
                    AND id_produk = '$id_produk'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function get_cart($id_member, $id_stokis, $id_plan){
        $sql  = "SELECT c.*, 
                    CONCAT_WS(' ', j.name, ' - ', p.nama_produk, p.qty, p.satuan) AS nama_produk_detail,
                    p.gambar, 
                    p.nama_produk, 
                    p.hpp, 
                    p.harga, 
                    p.bonus_sponsor,
                    p.bonus_cashback,
                    p.bonus_generasi,
                    p.bonus_upline,
                    p.bonus_sponsor_monoleg,
                    p.nilai_produk, 
                    p.poin_pasangan,
                    p.poin_reward,
                    p.fee_founder,
                    p.fee_stokis, 
                    p.qty as qty_produk, 
                    p.satuan, 
                    j.name
                    FROM mlm_stokis_jual_pin_cart c
                    JOIN mlm_produk p ON c.id_produk = p.id  
                    JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                    JOIN mlm_produk_plan pp ON pp.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND p.deleted_at IS NULL 
                    AND pp.id_plan = '$id_plan'
                    AND c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL
                    ORDER BY c.id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function delete_cart($id_member, $id_stokis){
        $sql  = "DELETE FROM mlm_stokis_jual_pin_cart 
                    WHERE id_member = '$id_member'
                    AND id_stokis = '$id_stokis'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function delete_produk_cart($id_member, $id_stokis, $id_produk){
        $sql  = "DELETE FROM mlm_stokis_jual_pin_cart 
                    WHERE id_member = '$id_member'
                    AND id_stokis = '$id_stokis'
                    AND id_produk = '$id_produk'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function total_qty($id_member, $id_stokis, $id_plan){
        $sql  = "SELECT COALESCE(SUM(c.qty),0) AS total
                    FROM mlm_stokis_jual_pin_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    JOIN mlm_produk_plan pp ON pp.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND p.deleted_at IS NULL 
                    AND pp.id_plan = '$id_plan'
                    AND c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    public function total_order($id_member, $id_stokis, $id_plan){
        $sql  = "SELECT COALESCE(SUM(p.harga*c.qty),0) AS total
                    FROM mlm_stokis_jual_pin_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    JOIN mlm_produk_plan pp ON pp.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND p.deleted_at IS NULL 
                    AND pp.id_plan = '$id_plan'
                    AND c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    public function total_nilai_produk($id_member, $id_stokis, $id_plan){
        $sql  = "SELECT COALESCE(SUM(p.nilai_produk*c.qty),0) AS total
                    FROM mlm_stokis_jual_pin_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    JOIN mlm_produk_plan pp ON pp.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND p.deleted_at IS NULL 
                    AND pp.id_plan = '$id_plan'
                    AND c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    public function cek_produk_wajib($id_member, $id_stokis, $id_produk){
        $sql  = "SELECT COALESCE(SUM(p.nilai_produk*c.qty),0) AS total
                    FROM mlm_stokis_jual_pin_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    JOIN mlm_produk_plan pp ON pp.id_produk = p.id
                    WHERE c.id_member = '$id_member'
                    AND p.deleted_at IS NULL 
                    AND c.id_produk = '$id_produk'
                    AND c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function produk_diskon($id_produk, $qty){
        $sql  = "SELECT p.*
                    FROM mlm_produk_diskon p
                    WHERE p.id_produk = '$id_produk'
                    AND p.qty <= '$qty'
                    AND p.deleted_at IS NULL
                    ORDER BY p.id DESC
                    LIMIT 1";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }
}