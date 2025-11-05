<?php 
require_once ("classConnection.php");

class classWithdraw{

    private $id_member;
    private $jenis_saldo;
    private $jenis_penarikan;
    private $jumlah;
    private $admin;
    private $total;
    private $status_transfer;
    private $id_wallet;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function get_id_member(){
		return $this->id_member;
	}

	public function set_id_member($id_member){
		$this->id_member = $id_member;
	}

    public function get_jenis_saldo(){
		return $this->jenis_saldo;
	}

	public function set_jenis_saldo($jenis_saldo){
		$this->jenis_saldo = $jenis_saldo;
	}

    public function get_jenis_penarikan(){
		return $this->jenis_penarikan;
	}

	public function set_jenis_penarikan($jenis_penarikan){
		$this->jenis_penarikan = $jenis_penarikan;
	}

    public function get_jumlah(){
		return $this->jumlah;
	}

	public function set_jumlah($jumlah){
		$this->jumlah = $jumlah;
	} 
    
    public function get_admin(){
		return $this->admin;
	}

	public function set_admin($admin){
		$this->admin = $admin;
	} 
    
    public function get_total(){
		return $this->total;
	}

	public function set_total($total){
		$this->total = $total;
	} 
    public function get_status_transfer(){
		return $this->status_transfer;
	}

	public function set_status_transfer($status_transfer){
		$this->status_transfer = $status_transfer;
	}
    public function get_id_wallet(){
		return $this->id_wallet;
	}

	public function set_id_wallet($id_wallet){
		$this->id_wallet = $id_wallet;
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
		$sql 	= "INSERT INTO mlm_penarikan 
                    (
                        id_member, 
                        jenis_saldo, 
                        jenis_penarikan, 
                        jumlah, 
                        admin, 
                        total, 
                        status_transfer, 
                        id_wallet, 
                        created_at
                    ) values 
                    ('".$this->get_id_member()."', 
                    '".$this->get_jenis_saldo()."', 
                    '".$this->get_jenis_penarikan()."', 
                    '".$this->get_jumlah()."', 
                    '".$this->get_admin()."', 
                    '".$this->get_total()."', 
                    '".$this->get_status_transfer()."', 
                    '".$this->get_id_wallet()."', 
                    '".$this->get_created_at()."')";
		$c 		= new classConnection();
		$query 	= $c->_query($sql);
		return $query;
	}
    
    public function index_member($id, $jenis_saldo){
        $sql  = "SELECT * FROM mlm_penarikan 
                WHERE id_member = '$id' 
                AND jenis_saldo = '$jenis_saldo' 
                AND  deleted_at is null ORDER BY id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function index_member_poin($id){
        $sql  = "SELECT * FROM mlm_penarikan 
                WHERE id_member = '$id' 
                AND (jenis_saldo = 'poin'
                OR jenis_saldo = 'coin') 
                AND  deleted_at is null ORDER BY id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function saldo($id){
        $sql  = "SELECT 
                COALESCE(SUM(w.jumlah),0) AS saldo 
                FROM mlm_penarikan w 
                WHERE w.id_member = '$id' AND w.deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->saldo;
    }

    public function total_wd($id, $jenis_saldo){
        $sql  = "SELECT 
                COALESCE(SUM(w.jumlah),0) AS jumlah 
                FROM mlm_penarikan w 
                WHERE w.id_member = '$id' 
                AND w.jenis_saldo = '$jenis_saldo'
                AND w.status_transfer <= 1
                AND w.deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->jumlah;
    }

    public function total_wd_today($id, $jenis_saldo, $tanggal){
        $sql  = "SELECT 
                COALESCE(SUM(w.jumlah),0) AS jumlah 
                FROM mlm_penarikan w 
                WHERE w.id_member = '$id' 
                AND w.jenis_saldo = '$jenis_saldo'
                AND w.status_transfer <= 1
                AND LEFT(w.created_at, 10) = '$tanggal' 
                AND w.deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->jumlah;
    }

    public function cek_pending_wd($id_member, $jenis_saldo){
        $sql  = "SELECT COUNT(*) AS total 
                FROM mlm_penarikan w 
                WHERE w.id_member = '$id_member' 
                AND w.jenis_saldo = '$jenis_saldo'
                AND w.status_transfer = '0'
                AND w.deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function rate_coin(){
        $sql  = "SELECT rupiah FROM mlm_rate_coin ORDER BY created_at DESC LIMIT 1";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        if($query){
            return $query->rupiah;
        }
        return 0;
    }

    public function limit_penarikan($id_member, $jenis_saldo){
        $sql  = "SELECT 
        
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS total                
                FROM mlm_saldo_penarikan w
                WHERE w.id_member = '$id_member' 
                AND w.jenis_saldo = '$jenis_saldo' 
                AND w.deleted_at is null
                ";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function total_penarikan($id_member, $jenis_saldo){
        $sql  = "SELECT         
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS total                
                FROM mlm_saldo_penarikan w
                WHERE w.id_member = '$id_member' 
                AND w.jenis_saldo = '$jenis_saldo' 
                AND w.deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function index_transfer($jenis_penarikan){
        $sql  = "SELECT * FROM mlm_penarikan 
                WHERE status_transfer = '0' 
                AND jenis_penarikan = '$jenis_penarikan' 
                AND deleted_at is null ORDER BY id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function index_laporan($jenis_penarikan){
        $sql  = "SELECT * FROM mlm_penarikan 
                WHERE status_transfer = '1' 
                AND jenis_penarikan = '$jenis_penarikan' 
                ORDER BY updated_at DESC";
        $c    = new classConnection();
        // echo $sql;
        $query  = $c->_query($sql);
        return $query;
    }

    public function index_cancel($jenis_penarikan){
        $sql  = "SELECT * FROM mlm_penarikan 
                WHERE status_transfer = '2' AND jenis_penarikan = '$jenis_penarikan' ORDER BY updated_at DESC";
        $c    = new classConnection();
        // echo $sql;
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function update_transfer($id){
        $sql  = "UPDATE mlm_penarikan 
                    SET status_transfer = '1',
                    updated_at = '".$this->get_updated_at()."'
                WHERE id = $id";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function cancel_transfer($id){
        $sql  = "UPDATE mlm_penarikan SET status_transfer = '2',
                    updated_at = '".$this->get_updated_at()."'
                WHERE id = $id";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function show($id){
        $sql  = "SELECT * FROM mlm_penarikan 
                WHERE id = $id";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function total_bonus_status($status_transfer){
        $sql  = "SELECT COALESCE(SUM(total), 0) as total FROM mlm_penarikan
                WHERE status_transfer = '$status_transfer'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return number_format($query->total,0,',','.');
    }

    public function total_bonus(){
        $sql  = "SELECT COALESCE(SUM(total), 0) as total FROM mlm_penarikan ";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return number_format($query->total,0,',','.');
    }
    
    
}