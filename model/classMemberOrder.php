<?php 
require_once 'classConnection.php';

class classMemberOrder{
    private $id;
    private $id_member;
    private $nominal;
    private $id_stokis;
    private $id_kodeaktivasi;
    private $status;
    private $jasa_ekspedisi;
    private $no_resi;
    private $biaya_kirim;
    private $alamat_kirim;
    private $keterangan;
    private $created_at;
    private $tgl_kirim_produk;
    private $tgl_proses;
    private $bukti_bayar;
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
    
    public function get_nominal(){
		return $this->nominal;
	}

	public function set_nominal($nominal){
		$this->nominal = $nominal;
	}
    
    public function get_id_stokis(){
		return $this->id_stokis;
	}

	public function set_id_stokis($id_stokis){
		$this->id_stokis = $id_stokis;
	}
    
    public function get_id_kodeaktivasi(){
		return $this->id_kodeaktivasi;
	}

	public function set_id_kodeaktivasi($id_kodeaktivasi){
		$this->id_kodeaktivasi = $id_kodeaktivasi;
	}
    
    public function get_status(){
		return $this->status;
	}

	public function set_status($status){
		$this->status = $status;
	}
    
    public function get_jasa_ekspedisi(){
		return $this->jasa_ekspedisi;
	}

	public function set_jasa_ekspedisi($jasa_ekspedisi){
		$this->jasa_ekspedisi = $jasa_ekspedisi;
	}
    
    public function get_no_resi(){
		return $this->no_resi;
	}

	public function set_no_resi($no_resi){
		$this->no_resi = $no_resi;
	}
    
    public function get_biaya_kirim(){
		return $this->biaya_kirim;
	}

	public function set_biaya_kirim($biaya_kirim){
		$this->biaya_kirim = $biaya_kirim;
	}
    
    public function get_alamat_kirim(){
		return $this->alamat_kirim;
	}

	public function set_alamat_kirim($alamat_kirim){
		$this->alamat_kirim = $alamat_kirim;
	}
    
    public function get_keterangan(){
		return $this->keterangan;
	}

	public function set_keterangan($keterangan){
		$this->keterangan = $keterangan;
	}
    
    public function get_created_at(){
		return $this->created_at;
	}

	public function set_created_at($created_at){
		$this->created_at = $created_at;
	}
    
    public function get_tgl_kirim_produk(){
		return $this->tgl_kirim_produk;
	}

	public function set_tgl_kirim_produk($tgl_kirim_produk){
		$this->tgl_kirim_produk = $tgl_kirim_produk;
	}
    
    public function get_tgl_proses(){
		return $this->tgl_proses;
	}

	public function set_tgl_proses($tgl_proses){
		$this->tgl_proses = $tgl_proses;
	}
    
    public function get_bukti_bayar(){
		return $this->bukti_bayar;
	}

	public function set_bukti_bayar($bukti_bayar){
		$this->bukti_bayar = $bukti_bayar;
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
        $sql  = "SELECT o.*, m.id_member as member_id, m.nama_member, sm.nama_stokis, 
                        sm.id as id_stokis, ks.nama_kota, sm.no_handphone as no_hp_stokis
                    FROM mlm_member_order o
                    LEFT JOIN mlm_member m ON o.id_member = m.id
                    LEFT JOIN mlm_stokis_member sm ON o.id_stokis = sm.id
                    LEFT JOIN mlm_kota ks ON sm.id_kota = ks.id
                    WHERE o.deleted_at IS NULL
                    AND o.id_member = '$id_member'
                    ORDER BY o.id DESC";
                    // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function index($status = ''){
        $sql  = "SELECT o.*, m.id_member as member_id, m.nama_member, sm.nama_stokis, 
                        sm.id_stokis, ks.nama_kota as kota_stokis, sm.no_handphone as hp_stokis 
                    FROM mlm_member_order o
                    LEFT JOIN mlm_member m ON o.id_member = m.id
                    LEFT JOIN mlm_stokis_member sm ON o.id_stokis = sm.id
                    LEFT JOIN mlm_kota ks ON sm.id_kota = ks.id
                    WHERE o.deleted_at IS NULL
                    AND o.status LIKE '$status%'
                    ORDER BY o.id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function index_stokis($id_stokis, $status = ''){
        $sql  = "SELECT o.*, m.id_member as member_id, m.nama_member, sm.nama_stokis, 
                        sm.id_stokis, ks.nama_kota as kota_stokis, sm.no_handphone as hp_stokis 
                    FROM mlm_member_order o
                    LEFT JOIN mlm_member m ON o.id_member = m.id
                    LEFT JOIN mlm_stokis_member sm ON o.id_stokis = sm.id
                    LEFT JOIN mlm_kota ks ON sm.id_kota = ks.id
                    WHERE o.deleted_at IS NULL
                    AND o.id_stokis = '$id_stokis'
                    AND o.status LIKE '$status%'
                    ORDER BY o.id DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function delete($id){
        $sql  = "DELETE FROM mlm_member_order 
                    WHERE id = '$id'
                    AND id_member = '".$this->get_id_member()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function delete_detail($id_order){
        $sql  = "DELETE FROM mlm_member_order 
                    WHERE id_order = '$id_order'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function show($id, $id_member = ''){
            $sql  = "SELECT o.*, 
                        o.id_stokis as stokis_id,
                        s.nama_stokis,
                        s.id_stokis,
                        s.no_handphone as hp_stokis,
                        kt.nama_kota as kota_stokis,
                        p.nama_provinsi,
                        k.nama_kota,
                        kc.nama_kecamatan,
                        kl.nama_kelurahan,
                        j.jasa_ekspedisi as nama_jasa_ekspedisi
                        FROM mlm_member_order o
                        LEFT JOIN mlm_stokis_member s ON o.id_stokis = s.id
                        LEFT JOIN mlm_kota kt ON s.id_kota = kt.id
                        LEFT JOIN mlm_provinsi p ON o.id_provinsi = p.id
                        LEFT JOIN mlm_kota k ON o.id_kota = k.id
                        LEFT JOIN mlm_kecamatan kc ON o.id_kecamatan = kc.id
                        LEFT JOIN mlm_kelurahan kl ON o.id_kelurahan = kl.id
                        LEFT JOIN mlm_jasa_ekspedisi j ON o.jasa_ekspedisi = j.id 
                        WHERE CASE WHEN LENGTH('$id_member') > 0 THEN o.id_member = '$id_member' ELSE 1 END
                        AND o.id = '$id'";
                        // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function show_stokis($id, $id_stokis = ''){
            $sql  = "SELECT o.*, 
                        o.id_stokis as stokis_id,
                        s.nama_stokis,
                        s.id_stokis,
                        s.no_handphone as hp_stokis,
                        kt.nama_kota as kota_stokis,
                        p.nama_provinsi,
                        k.nama_kota,
                        kc.nama_kecamatan,
                        kl.nama_kelurahan,
                        j.jasa_ekspedisi as nama_jasa_ekspedisi
                        FROM mlm_member_order o
                        LEFT JOIN mlm_stokis_member s ON o.id_stokis = s.id
                        LEFT JOIN mlm_kota kt ON s.id_kota = kt.id
                        LEFT JOIN mlm_provinsi p ON o.id_provinsi = p.id
                        LEFT JOIN mlm_kota k ON o.id_kota = k.id
                        LEFT JOIN mlm_kecamatan kc ON o.id_kecamatan = kc.id
                        LEFT JOIN mlm_kelurahan kl ON o.id_kelurahan = kl.id
                        LEFT JOIN mlm_jasa_ekspedisi j ON o.jasa_ekspedisi = j.id 
                        WHERE CASE WHEN LENGTH('$id_stokis') > 0 THEN o.id_stokis = '$id_stokis' ELSE 1 END
                        AND o.id = '$id'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function show_order($id, $id_member){
        $sql  = "SELECT * FROM mlm_member_order 
                    WHERE id = '$id'
                    AND id_member= '$id_member'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function index_detail($id){
        $sql  = "SELECT d.*, p.nama_produk, p.gambar FROM mlm_member_order_detail d
                    LEFT JOIN mlm_produk p ON d.id_produk = p.id
                    
                    WHERE d.id_order = '$id'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function create_detail($id_order){
        $sql  = "INSERT INTO mlm_member_order_detail (
                    id_order,
                    id_produk,
                    harga_produk,
                    qty_produk,
                    sub_total_produk, 
                    created_at
                ) SELECT 
                    '$id_order',
                    c.id_produk,
                    p.harga,
                    c.qty,
                    p.harga*c.qty,
                    '".$this->get_created_at()."'
                    FROM mlm_cart c
                    LEFT JOIN mlm_produk p ON c.id_produk = p.id
                    WHERE c.id_member = '".$this->get_id_member()."'
                    AND c.status = '0'
                    AND c.checked = '1'
                    AND c.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function batalkan_pesanan(){
        $sql  = "UPDATE mlm_member_order SET
                    status = '".$this->get_status()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE status = '-1'
                    AND id  = '".$this->get_id()."'
                    AND id_member = '".$this->get_id_member()."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function delete_wallet(){
        $sql  = "UPDATE mlm_wallet 
                    SET deleted_at = '".$this->get_deleted_at()."'
                    WHERE dari_member = '".$this->get_id()."'
                    AND jenis_saldo = 'ppob'
                    AND type = 'order_produk'
                    AND status = 'k'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

	public function showdetail($id){
        $sql  = "SELECT d.*, p.nama_produk, p.gambar FROM mlm_member_order_detail d
                    LEFT JOIN mlm_produk p ON d.id_produk = p.id
                    
                    WHERE d.id_order = '$id'";
        $c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}
    
    public function update_status($id){
		$sql 	= "UPDATE mlm_member_order 
                    SET status = '".$this->get_status()."', 
                    tgl_proses = CASE WHEN LENGTH('".$this->get_tgl_proses()."') > 0 THEN '".$this->get_tgl_proses()."'  ELSE tgl_proses END,
                    updated_at = '".$this->get_updated_at()."'
                    WHERE id = '$id'";
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }
    
    public function save_resi($id){
		$sql 	= "UPDATE mlm_member_order 
                    SET 
                    status = '".$this->get_status()."', 
                    jasa_ekspedisi = '".$this->get_jasa_ekspedisi()."', 
                    no_resi = '".$this->get_no_resi()."', 
                    biaya_kirim = '".$this->get_biaya_kirim()."',  
                    tgl_kirim_produk = '".$this->get_updated_at()."', 
                    updated_at = '".$this->get_updated_at()."'
                    where id = '$id'";
                    // echo $sql;
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }
    
    public function save_resi_stokis($id, $id_stokis){
		$sql 	= "UPDATE mlm_member_order 
                    SET 
                    status = '".$this->get_status()."', 
                    jasa_ekspedisi = '".$this->get_jasa_ekspedisi()."', 
                    no_resi = '".$this->get_no_resi()."', 
                    biaya_kirim = '".$this->get_biaya_kirim()."',  
                    tgl_kirim_produk = '".$this->get_updated_at()."', 
                    updated_at = '".$this->get_updated_at()."'
                    where id = '$id'
                    AND id_stokis = '$id_stokis'";
                    // echo $sql;
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }

    public function get_detail_order($id_order){
		$sql 	= "SELECT 
                        d.*, 
                        r.id_member, 
                        p.generasi_sponsor, 
                        p.generasi_upline
                    FROM mlm_member_order_detail d
                    JOIN mlm_member_order r ON d.id_order = r.id
                    LEFT JOIN mlm_produk p ON d.id_produk = p.id
                    WHERE d.id_order = '$id_order' 
                    AND d.deleted_at IS NULL";
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }
    public function benefit_produk($id_order){
        $sql  = "SELECT COALESCE(SUM(total_hu), 0) AS jumlah_hu,
                    COALESCE(SUM(bonus_poin), 0) AS bonus_poin,
                    COALESCE(SUM(bonus_generasi), 0) AS bonus_generasi
                    FROM mlm_member_order_detail
                    WHERE id_order = '$id_order'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function pending($id, $id_member){
        $sql  = "SELECT * FROM mlm_member_order 
                    WHERE id_member = '$id_member'
                    AND id = '$id'
                    AND status = '-1'";
        $c    = new classConnection();
        $query 	= $c->_query_fetch($sql);
        return $query;
    }

    public function update_bukti_bayar(){
        $sql  = "UPDATE mlm_member_order 
                    SET bukti_bayar = '".$this->get_bukti_bayar()."',
                    status = '".$this->get_status()."'
                    WHERE id_member = '".$this->get_id_member()."'
                    AND id = '".$this->get_id()."'
                    AND status = '-1'";
        $c    = new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }

    public function konfirmasi_pesanan(){
        $sql  = "UPDATE mlm_member_order 
                    SET status = '".$this->get_status()."', updated_at = '".$this->get_updated_at()."'
                    WHERE id_member = '".$this->get_id_member()."'
                    AND id = '".$this->get_id()."'
                    AND status = '2'";
        $c    = new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }
}