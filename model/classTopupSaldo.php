<?php
require_once "classConnection.php";

class classTopupSaldo
{
    private $nominal;
    private $kode_unik;
    private $total_bayar;
    private $status;
    private $bank_transfer;
    private $id_member;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function get_nominal(){
		return $this->nominal;
	}

	public function set_nominal($nominal){
		$this->nominal = $nominal;
	}
    
    public function get_kode_unik(){
		return $this->kode_unik;
	}

	public function set_kode_unik($kode_unik){
		$this->kode_unik = $kode_unik;
	}
    
    public function get_total_bayar(){
		return $this->total_bayar;
	}

	public function set_total_bayar($total_bayar){
		$this->total_bayar = $total_bayar;
	}
    
    public function get_status(){
		return $this->status;
	}

	public function set_status($status){
		$this->status = $status;
	}
    
    public function get_bank_transfer(){
		return $this->bank_transfer;
	}

	public function set_bank_transfer($bank_transfer){
		$this->bank_transfer = $bank_transfer;
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

    public function index_member($id_member){
        $sql = "SELECT t.*, r.no_rekening, r.cabang_rekening, r.atas_nama_rekening, b.nama_bank 
                FROM mlm_topup_saldo t 
                LEFT JOIN mlm_rekening_perusahaan r ON t.bank_transfer = r.id 
                LEFT JOIN mlm_bank b ON r.id_bank = b.id 
                WHERE t.id_member = '$id_member' 
                AND t.deleted_at is null 
                ORDER BY t.id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function index(){
        $sql = "SELECT t.*, r.no_rekening, r.cabang_rekening, r.atas_nama_rekening, b.nama_bank 
                FROM mlm_topup_saldo t 
                LEFT JOIN mlm_rekening_perusahaan r ON t.bank_transfer = r.id 
                LEFT JOIN mlm_bank b ON r.id_bank = b.id 
                WHERE t.status = '0' 
                AND t.deleted_at is null ORDER BY t.id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function laporan(){
        $sql = "SELECT t.*, r.no_rekening, r.cabang_rekening, r.atas_nama_rekening, b.nama_bank 
                FROM mlm_topup_saldo t 
                LEFT JOIN mlm_rekening_perusahaan r ON t.bank_transfer = r.id 
                LEFT JOIN mlm_bank b ON r.id_bank = b.id 
                WHERE t.status = '1' 
                AND t.deleted_at is null ORDER BY t.id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_transfer($id, $updated_at){
        $sql = "UPDATE mlm_topup_saldo 
                SET status = '1', updated_at = '$updated_at'
                WHERE status = '0'
                AND id = '$id' 
                AND deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_affected_rows($sql);
        return $query;
    }

    public function update_reject($id, $updated_at){
        $sql = "UPDATE mlm_topup_saldo 
                SET status = '2', updated_at = '$updated_at'
                WHERE status = '0'
                AND id = '$id' 
                AND deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_affected_rows($sql);
        return $query;
    }
    
    public function show($id){
        $sql = "SELECT * FROM mlm_topup_saldo
                WHERE id = '$id' 
                AND deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function create()
    {
        $sql =
            "INSERT INTO mlm_topup_saldo (
                    nominal, 
                    kode_unik, 
                    total_bayar, 
                    status, 
                    bank_transfer, 
                    id_member, 
                    created_at
                ) values (
                    '".$this->get_nominal()."', 
                    '".$this->get_kode_unik()."', 
                    '".$this->get_total_bayar()."', 
                    '".$this->get_status()."', 
                    '".$this->get_bank_transfer()."', 
                    '".$this->get_id_member()."', 
                    '".$this->get_created_at()."'
                )";
                $c = new classConnection();
                    // echo $sql;
        $query = $c->_query_insert($sql);
        return $query;
    }
}
