<?php 
require_once 'classConnection.php';
require_once 'classStokisPaket.php';
require_once 'classStokisMember.php';

class classStokisTransferCart{

    private $id;
    private $id_stokis;
    private $id_stokis_tujuan;
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

	public function get_id_stokis_tujuan(){
		return $this->id_stokis_tujuan;
	}

	public function set_id_stokis_tujuan($id_stokis_tujuan){
		$this->id_stokis_tujuan = $id_stokis_tujuan;
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
        $sql  = "INSERT INTO mlm_stokis_transfer_cart (
                    id_stokis_tujuan, 
                    id_stokis, 
                    id_produk, 
                    qty, 
                    status, 
                    created_at
                ) VALUES (
                    '".$this->get_id_stokis_tujuan()."', 
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
        $sql  = "UPDATE mlm_stokis_transfer_cart SET
                    qty = qty+'".$this->get_qty()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id_stokis = '".$this->get_id_stokis()."'
                    AND id_stokis_tujuan = '".$this->get_id_stokis_tujuan()."'
                    AND id_produk = '".$this->get_id_produk()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_qty(){
        $sql  = "UPDATE mlm_stokis_transfer_cart SET
                    qty = '".$this->get_qty()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_stokis = '".$this->get_id_stokis()."'
                    AND id_stokis_tujuan = '".$this->get_id_stokis_tujuan()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function update_status(){
        $sql  = "UPDATE mlm_stokis_transfer_cart SET
                    status = '".$this->get_status()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE status = '0'
                    AND id_stokis = '".$this->get_id_stokis()."'
                    AND id_stokis_tujuan = '".$this->get_id_stokis_tujuan()."'
                    AND deleted_at IS NULL
                    ";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function delete(){
        $sql  = "UPDATE mlm_stokis_transfer_cart SET
                    deleted_at = '".$this->get_deleted_at()."' 
                    WHERE id = '".$this->get_id()."'
                    AND id_stokis = '".$this->get_id_stokis()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }


    public function total_cart($id_stokis){
        $sql  = "SELECT COUNT(*) AS total 
                    FROM mlm_stokis_transfer_cart 
                    WHERE id_stokis = '$id_stokis'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function total_harga($id_stokis){
        $sql  = "SELECT COALESCE(SUM(p.harga*c.qty),0) AS total_harga 
                    FROM mlm_stokis_transfer_cart c
                    LEFT JOIN mlm_produk_harga p ON c.id_produk = p.id
                    WHERE c.id_stokis = '$id_stokis'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total_harga;
    }

    public function cek_keranjang($id_stokis, $id_stokis_tujuan, $id_produk){
        $sql  = "SELECT COUNT(*) AS total 
                    FROM mlm_stokis_transfer_cart 
                    WHERE id_stokis = '$id_stokis'
                    AND id_stokis_tujuan = '$id_stokis_tujuan'
                    AND id_produk = '$id_produk'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function total_qty($id_stokis, $id_stokis_tujuan, $id_produk){
        $sql  = "SELECT COALESCE(SUM(qty),0) AS total 
                    FROM mlm_stokis_transfer_cart 
                    WHERE id_stokis = '$id_stokis'
                    AND id_stokis_tujuan = '$id_stokis_tujuan'
                    AND id_produk = '$id_produk'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    
    public function get_cart($id_stokis, $id_stokis_tujuan){
        $sql  = "SELECT c.*, 
                    p.gambar, 
                    p.nama_produk, 
                    p.harga, 
                    p.fee_stokis, 
                    p.qty as qty_produk, 
                    p.satuan, 
                    j.name
                    FROM mlm_stokis_transfer_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id  
                    LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id  
                    WHERE c.id_stokis = '$id_stokis'
                    AND c.id_stokis_tujuan = '$id_stokis_tujuan'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL
                    ORDER BY c.id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function delete_cart($id_stokis, $id_stokis_tujuan){
        $sql  = "DELETE FROM mlm_stokis_transfer_cart 
                    WHERE id_stokis = '$id_stokis'
                    AND id_stokis_tujuan = '$id_stokis_tujuan'
                    AND status = '0'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function total_order($id_stokis, $id_stokis_tujuan){
        $sql  = "SELECT COALESCE(SUM(p.harga*c.qty),0) AS total
                    FROM mlm_stokis_transfer_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    
                    WHERE c.id_stokis = '$id_stokis'
                    AND c.id_stokis_tujuan = '$id_stokis_tujuan'
                    AND c.status = '0'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function total_diskon($id_stokis, $id_stokis_tujuan, $id = ''){
        $csm = new classStokisMember();
        $csp = new classStokisPaket();
        $stokis = $csm->show($id_stokis);
        $persentase_fee = 0;
        if($stokis){
            $paket_stokis = $csp->show($stokis->id_paket);
            if($paket_stokis){
                $persentase_fee = $paket_stokis->persentase_fee;
            }
        }
        $stokis_tujuan = $csm->show($id_stokis_tujuan);
        $persentase_fee_tujuan = 0;
        if($stokis_tujuan){
            $paket_stokis = $csp->show($stokis_tujuan->id_paket);
            if($paket_stokis){
                $persentase_fee_tujuan = $paket_stokis->persentase_fee;
            }
        }
        $persentase_fee = ($persentase_fee - $persentase_fee_tujuan)/100;
        if($persentase_fee > 0){
            $sql  = "SELECT COALESCE(SUM(p.harga*c.qty*$persentase_fee),0) AS total
                        FROM mlm_stokis_transfer_cart c
                        LEFT JOIN mlm_produk p ON c.id_produk = p.id 
                        
                        WHERE c.id_stokis = '$id_stokis'
                        AND c.id_stokis_tujuan = '$id_stokis_tujuan'
                        AND CASE WHEN LENGTH('$id') > 0 THEN c.id = '$id' ELSE 1 END
                        AND c.status = '0'
                        AND c.deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total;

        } else {
            return 0;
        }
    }
}