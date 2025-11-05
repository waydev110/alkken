<?php 
require_once 'classConnection.php';

class classWallet{

    private $id;
    private $id_member;
    private $jenis_saldo;
    private $nominal;
    private $type;
    private $keterangan;
    private $status;
    private $status_transfer;
    private $dari_member;
    private $id_kodeaktivasi;
    private $dibaca;
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
    
    public function get_nominal(){
		return $this->nominal;
	}

	public function set_nominal($nominal){
		$this->nominal = $nominal;
	}
    
    public function get_type(){
		return $this->type;
	}

	public function set_type($type){
		$this->type = $type;
	}
    
    public function get_keterangan(){
		return $this->keterangan;
	}

	public function set_keterangan($keterangan){
		$this->keterangan = $keterangan;
	}
    
    public function get_status(){
		return $this->status;
	}

	public function set_status($status){
		$this->status = $status;
	}
    
    public function get_status_transfer(){
		return $this->status_transfer;
	}

	public function set_status_transfer($status_transfer){
		$this->status_transfer = $status_transfer;
	}
    
    public function get_dari_member(){
		return $this->dari_member;
	}

	public function set_dari_member($dari_member){
		$this->dari_member = $dari_member;
	}
    
    public function get_id_kodeaktivasi(){
		return $this->id_kodeaktivasi;
	}

	public function set_id_kodeaktivasi($id_kodeaktivasi){
		$this->id_kodeaktivasi = $id_kodeaktivasi;
	}
    
    public function get_dibaca(){
		return $this->dibaca;
	}

	public function set_dibaca($dibaca){
		$this->dibaca = $dibaca;
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
		$sql 	= "INSERT INTO mlm_wallet (
                        id_member, 
                        jenis_saldo, 
                        nominal, 
                        type, 
                        keterangan, 
                        status, 
                        status_transfer, 
                        dari_member, 
                        id_kodeaktivasi, 
                        dibaca, 
                        created_at
                    ) values (
		                '".$this->get_id_member()."',
                        '".$this->get_jenis_saldo()."',
                        '".$this->get_nominal()."',
                        '".$this->get_type()."',
                        '".$this->get_keterangan()."',
                        '".$this->get_status()."',
                        '".$this->get_status_transfer()."',
                        '".$this->get_dari_member()."',
                        '".$this->get_id_kodeaktivasi()."',
                        '".$this->get_dibaca()."',
                        '".$this->get_created_at()."'
                        )";
		$c 		= new classConnection();
		$query 	= $c->_query_insert($sql);
		return $query;
	}
        
    public function saldo($id, $jenis_saldo){
        $sql  = "SELECT 
                COALESCE(SUM(CASE 
                    WHEN w.status = 'd' 
                    THEN w.nominal
                    ELSE 0 
                END) - 
                SUM(CASE 
                    WHEN w.status = 'k' 
                    THEN w.nominal
                    ELSE 0 
                END),0) AS saldo 
                FROM mlm_wallet w 
                WHERE w.id_member = '$id' AND jenis_saldo = '$jenis_saldo' AND w.deleted_at is null";
        
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->saldo;
    }
    
    public function index_member($id){
        $sql  = "SELECT id_member, SUM(nominal) as nominal, type, keterangan, status, dari_member, created_at FROM mlm_wallet 
                WHERE id_member = '$id' AND status='d' AND deleted_at is null 
                GROUP BY id_member, type, status, dari_member, created_at ORDER BY created_at DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function total_bonus($id, $bulan){
        $sql  = "SELECT COALESCE(SUM(nominal), 0) as total_bonus FROM mlm_wallet 
                WHERE id_member = '$id' AND status='d' AND deleted_at is null AND LEFT(created_at, 7) = '$bulan'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total_bonus;
    }
    
    public function index_transfer($jenis_saldo, $status_transfer){
        $sql  = "SELECT *
                    FROM mlm_wallet 
                    WHERE status = 'k' 
                    AND jenis_saldo = '$jenis_saldo'
                    AND type = 'penarikan'
                    AND status_transfer = '$status_transfer'
                    AND deleted_at is null
                    ORDER BY id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function show($id){
        $sql  = "SELECT * FROM mlm_wallet 
                    WHERE id = '$id'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }
    
    public function cek_tupo($id, $id_member){
        $sql  = "SELECT COUNT(*) AS total FROM mlm_wallet 
                    WHERE id_kodeaktivasi = '$id' 
                    AND id_member = '$id_member'
                    AND jenis_saldo = 'poin'
                    AND type = 'tupo_automaintain'
                    AND status = 'd'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    
    public function update_nominal($id, $nominal, $keterangan, $updated_at){
        $sql  = "UPDATE mlm_wallet 
                    SET nominal = nominal+$nominal, keterangan = CONCAT(keterangan, '$keterangan'), updated_at = '$updated_at'
                    WHERE id = '$id'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    
    public function update_transfer($id){
        $sql  = "UPDATE mlm_wallet 
                    SET status_transfer = '1', updated_at = '".$this->get_updated_at()."'
                    WHERE id = '$id'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function cancel_transfer($id){
        $sql  = "UPDATE mlm_wallet 
                    SET status_transfer = '2', updated_at = '".$this->get_updated_at()."'
                    WHERE id = '$id'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function delete($id){
        $sql  = "DELETE FROM mlm_wallet WHERE id = '$id'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function saldo_poin_keluar(){
        $sql  = "SELECT m.id_member, m.nama_member, m.nama_samaran, w.nominal, w.keterangan, w.created_at 
                    FROM mlm_wallet w 
                    LEFT JOIN mlm_member m
                        ON w.id_member = m.id
                    WHERE w.jenis_saldo = 'poin'
                    AND w.deleted_at is null
                    ORDER BY w.created_at DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function saldo_autosave(){
        $sql  = "SELECT w.id_member as member_id, m.id_member, m.nama_member, m.nama_samaran, 
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS masuk,
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS keluar, 
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS sisa 
                    FROM mlm_wallet w 
                    LEFT JOIN mlm_member m
                        ON w.id_member = m.id
                    WHERE w.jenis_saldo = 'poin' 
                    AND w.deleted_at is null
                    GROUP BY w.id_member
                    ORDER BY w.id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function saldo_reedem(){
        $sql  = "SELECT w.id_member as member_id, m.id_member, m.nama_member, m.nama_samaran, 
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS masuk,
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS keluar, 
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS sisa 
                    FROM mlm_wallet w 
                    LEFT JOIN mlm_member m
                        ON w.id_member = m.id
                    WHERE w.jenis_saldo = 'reedem' 
                    AND w.deleted_at is null
                    GROUP BY w.id_member
                    ORDER BY w.id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function saldo_wallet($jenis_saldo){
        $sql  = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS masuk,
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS keluar, 
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS sisa 
                    FROM mlm_wallet w
                    WHERE w.jenis_saldo = '$jenis_saldo' 
                    AND w.deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }
        
    public function member_saldo_autosave($bulan){
        $sql  = "SELECT w.id_member,
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd' 
                        THEN w.nominal
                        ELSE 0 
                    END)) AS saldo 
                FROM mlm_wallet w 
                WHERE w.jenis_saldo = 'poin'
                AND w.type != 'tupo_automaintain'
                AND LEFT(w.created_at, 7) = '$bulan'
                AND w.deleted_at is null
                GROUP BY w.id_member";
        
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function riwayat_saldo($id_member, $jenis_saldo, $status, $start){
        $sql  = "SELECT *
                    FROM mlm_wallet 
                    WHERE id_member = '$id_member' 
                    AND jenis_saldo = '$jenis_saldo'
                    AND CASE WHEN LENGTH('$status')>0 THEN status = '$status' ELSE 1 END
                    AND deleted_at is null
                    ORDER BY created_at DESC
                    LIMIT $start, 10";
                    // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function total_saldo($id_member, $jenis_saldo, $status, $bulan=''){
        $sql  = "SELECT COALESCE(SUM(nominal), 0) AS total
                    FROM mlm_wallet 
                    WHERE id_member = '$id_member' 
                    AND jenis_saldo = '$jenis_saldo'
                    AND CASE WHEN LENGTH('$status') THEN status = '$status' ELSE 1 END
                    AND CASE WHEN LENGTH('$bulan') THEN LEFT(created_at, 7) = '$bulan' ELSE 1 END
                    AND deleted_at is null";
                    // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    
    public function create_wallet($id_member, $jenis_saldo, $nominal, $type, $status, $id_kodeaktivasi, $keterangan, $created_at){ 
        $sql = "INSERT INTO mlm_wallet (
                    id_member, 
                    jenis_saldo, 
                    nominal, 
                    type, 
                    status, 
                    id_kodeaktivasi, 
                    keterangan, 
                    created_at
                ) values (
                    '$id_member', 
                    '$jenis_saldo',
                    '$nominal',
                    '$type',
                    '$status',    
                    '$id_kodeaktivasi',     
                    '$keterangan',       
                    '$created_at'
                )";      
        $c = new classConnection();   
        return $c->_query($sql);
    }
}