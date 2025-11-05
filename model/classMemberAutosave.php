<?php 
require_once 'classConnection.php';
class classMemberAutosave{
    protected $attributes = [];

    // Magic method untuk mengakses properti
    public function __get($property) {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
        return null;
    }

    // Magic method untuk mengatur properti
    public function __set($property, $value) {
        $this->attributes[$property] = $value;
    }
    private $id;
    private $id_member;
    private $qty;
    private $nominal;
    private $id_stokis;
    private $id_wallet;
    private $saldo_poin;
    private $status;
    private $jasa_ekspedisi;
    private $no_resi;
    private $biaya_kirim;
    private $id_provinsi;
    private $id_kota;
    private $id_kecamatan;
    private $id_kelurahan;
    private $alamat_kirim;
    private $kodepos;
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
    
    public function get_qty(){
        return $this->qty;
    }

    public function set_qty($qty){
        $this->qty = $qty;
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
    
    public function get_id_wallet(){
        return $this->id_wallet;
    }

    public function set_id_wallet($id_wallet){
        $this->id_wallet = $id_wallet;
    }
    
    public function get_saldo_poin(){
        return $this->saldo_poin;
    }

    public function set_saldo_poin($saldo_poin){
        $this->saldo_poin = $saldo_poin;
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

    public function get_id_provinsi(){
        return $this->id_provinsi;
    }

    public function set_id_provinsi($id_provinsi){
        $this->id_provinsi = $id_provinsi;
    }
    
    public function get_id_kota(){
        return $this->id_kota;
    }

    public function set_id_kota($id_kota){
        $this->id_kota = $id_kota;
    }
    
    public function get_id_kecamatan(){
        return $this->id_kecamatan;
    }

    public function set_id_kecamatan($id_kecamatan){
        $this->id_kecamatan = $id_kecamatan;
    }
    
    public function get_id_kelurahan(){
        return $this->id_kelurahan;
    }

    public function set_id_kelurahan($id_kelurahan){
        $this->id_kelurahan = $id_kelurahan;
    }
    
    public function get_alamat_kirim(){
        return $this->alamat_kirim;
    }

    public function set_alamat_kirim($alamat_kirim){
        $this->alamat_kirim = $alamat_kirim;
    }

    public function get_kodepos(){
        return $this->kodepos;
    }

    public function set_kodepos($kodepos){
        $this->kodepos = $kodepos;
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


    public function create(){
        // Ambil kolom dan nilai dari atribut
        $columns = implode(", ", array_keys($this->attributes));
        
        // Buat array untuk menampung nilai yang telah disanitasi
        $sanitized_values = [];
        
        // Sanitasi nilai-nilai atribut
        foreach ($this->attributes as $value) {
            $sanitized_values[] = "'" . addslashes($value) . "'"; // Sanitasi dengan addslashes
        }
        
        // Gabungkan nilai-nilai tersebut untuk dimasukkan ke dalam query
        $values = implode(", ", $sanitized_values);
        
        // Query SQL untuk insert
        $sql = "INSERT INTO mlm_member_autosave ($columns) VALUES ($values)";
        
        // Koneksi ke database
        $c = new classConnection();
        
        // Jalankan query
        $query = $c->_query_insert($sql);
        
        return $query;
    }

    public function index($status = ''){
        $sql  = "SELECT o.*, m.id_member as member_id, m.nama_member, m.hp_member, j.jasa_ekspedisi as nama_jasa_ekspedisi,
                    d.nama_provinsi, 
                    c.nama_kota, 
                    e.nama_kecamatan, 
                    l.nama_kelurahan
                    FROM mlm_member_autosave o
                    LEFT JOIN mlm_member m ON o.id_member = m.id
                    LEFT JOIN mlm_jasa_ekspedisi j ON o.jasa_ekspedisi = j.id
                    LEFT JOIN mlm_kota as c ON o.id_kota = c.id 
                    LEFT JOIN mlm_provinsi as d ON o.id_provinsi = d.id 
                    LEFT JOIN mlm_kecamatan as e ON o.id_kecamatan = e.id 
                    LEFT JOIN mlm_kelurahan as l ON o.id_kelurahan = l.id 
                    WHERE o.deleted_at IS NULL
                    AND o.status LIKE '$status%'
                    ORDER BY o.id DESC";
                    // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function index_member($id_member){
        $sql  = "SELECT m.*, s.nama_stokis FROM mlm_member_autosave m 
                    LEFT JOIN mlm_stokis_member s ON m.id_stokis = s.id
                    WHERE m.id_member = '$id_member'
                    AND m.deleted_at IS NULL ORDER BY m.id ASC";
        $c    = new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }

    public function delete($id){
        $sql  = "DELETE FROM mlm_member_autosave 
                    WHERE id = '$id'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function delete_detail($id_order){
        $sql  = "DELETE FROM mlm_member_autosave 
                    WHERE id_order = '$id_order'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function show($id){
        $sql  = "SELECT o.*, 
                    j.jasa_ekspedisi as nama_jasa_ekspedisi,                        
                    d.nama_provinsi, 
                    c.nama_kota, 
                    e.nama_kecamatan, 
                    l.nama_kelurahan
                    FROM mlm_member_autosave o
                    LEFT JOIN mlm_kota as c ON o.id_kota = c.id 
                    LEFT JOIN mlm_provinsi as d ON o.id_provinsi = d.id 
                    LEFT JOIN mlm_kecamatan as e ON o.id_kecamatan = e.id 
                    LEFT JOIN mlm_kelurahan as l ON o.id_kelurahan = l.id 
                    LEFT JOIN mlm_jasa_ekspedisi j ON o.jasa_ekspedisi = j.id 
                    WHERE o.id = '$id'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function show_order($id, $id_member){
        $sql  = "SELECT * FROM mlm_member_autosave 
                    WHERE id = '$id'
                    AND id_member= '$id_member'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function index_detail($id){
        $sql  = "SELECT d.*, p.nama_produk, p.gambar FROM mlm_member_autosave_detail d
                    LEFT JOIN mlm_produk p ON d.id_produk = p.id
                    
                    WHERE d.id_order = '$id'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_order($id, $id_member, $qty, $nominal){
        $sql  = "UPDATE mlm_member_autosave 
                    SET qty = qty+$qty, nominal = nominal+$nominal
                    WHERE id = '$id' 
                    AND id_member = '$id_member'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_order_detail($id, $qty, $nominal){
        $sql  = "UPDATE mlm_member_autosave_detail 
                    SET qty = qty+$qty, nominal = nominal+$nominal, total_hu = total_hu+$qty, bonus_generasi = 1000
                    WHERE id_order = '$id";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function batalkan_pesanan(){
        $sql  = "UPDATE mlm_member_autosave SET
                    status = '".$this->get_status()."', 
                    updated_at = '".$this->get_updated_at()."' 
                    WHERE status = '0'
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
        $sql  = "SELECT d.*, p.nama_produk, p.gambar FROM mlm_member_autosave_detail d
                    LEFT JOIN mlm_produk p ON d.id_produk = p.id                    
                    WHERE d.id_order = '$id'";
        $c 		= new classConnection();
		$query 	= $c->_query($sql);
        return $query;
	}
    
    public function update_status($id){
		$sql 	= "UPDATE mlm_member_autosave 
                    SET status = '".$this->get_status()."', 
                    tgl_proses = CASE WHEN LENGTH('".$this->get_tgl_proses()."') > 0 THEN '".$this->get_tgl_proses()."'  ELSE tgl_proses END,
                    updated_at = '".$this->get_updated_at()."'
                    WHERE id = '$id'";
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }
    
    public function save_resi($id){
		$sql 	= "UPDATE mlm_member_autosave 
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

    public function get_detail_order($id_order){
		$sql 	= "SELECT 
                        d.*, 
                        r.id_member, 
                        p.generasi_sponsor, 
                        p.generasi_upline
                    FROM mlm_member_autosave_detail d
                    JOIN mlm_member_autosave r ON d.id_order = r.id
                    LEFT JOIN mlm_produk p ON d.id_produk = p.id
                    WHERE d.id_order = '$id_order' 
                    AND d.deleted_at IS NULL";
        $c 		= new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }
    public function benefit_produk($id_order){
        $sql  = "SELECT COALESCE(SUM(total_hu), 0) AS jumlah_hu,
                    COALESCE(SUM(poin_reward), 0) AS poin_reward,
                    COALESCE(SUM(bonus_generasi), 0) AS bonus_generasi
                    FROM mlm_member_autosave_detail
                    WHERE id_order = '$id_order'
                    AND deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function cek_order($id_member){
        $sql  = "SELECT * FROM mlm_member_autosave 
                    WHERE id_member= '$id_member'
                    AND deleted_at IS NULL
                    AND status = 0
                    AND id_stokis IS NULL
                    LIMIT 1";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function show_member($id, $id_member){
        $sql  = "SELECT o.*, 
                    s.nama_stokis,
                    s.id_stokis,
                    m.nama_member,
                    m.hp_member,
                    p.nama_provinsi,
                    k.nama_kota,
                    kc.nama_kecamatan,
                    kl.nama_kelurahan,
                    j.jasa_ekspedisi as nama_jasa_ekspedisi
                    FROM mlm_member_autosave o
                    LEFT JOIN mlm_member m ON o.id_member = m.id
                    LEFT JOIN mlm_stokis_member s ON o.id_stokis = s.id
                    LEFT JOIN mlm_provinsi p ON o.id_provinsi = p.id
                    LEFT JOIN mlm_kota k ON o.id_kota = k.id
                    LEFT JOIN mlm_kecamatan kc ON o.id_kecamatan = kc.id
                    LEFT JOIN mlm_kelurahan kl ON o.id_kelurahan = kl.id
                    LEFT JOIN mlm_jasa_ekspedisi j ON o.jasa_ekspedisi = j.id 
                    WHERE o.id_member = '$id_member'
                    AND o.id = '$id'";
        $c    = new classConnection();
        $query 	= $c->_query_fetch($sql);
        return $query;
    }

    public function pending($id, $id_member){
        $sql  = "SELECT * FROM mlm_member_autosave 
                    WHERE id_member = '$id_member'
                    AND id = '$id'
                    AND status = '-1'";
        $c    = new classConnection();
        $query 	= $c->_query_fetch($sql);
        return $query;
    }

    public function update_bukti_bayar(){
        $sql  = "UPDATE mlm_member_autosave 
                    SET bukti_bayar = '".$this->get_bukti_bayar()."',
                    status = '".$this->get_status()."',
                    updated_at = '".$this->get_updated_at()."'
                    WHERE id_member = '".$this->get_id_member()."'
                    AND id = '".$this->get_id()."'
                    AND status = '-1'";
        $c    = new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }

    public function batalkan_pesanan_member(){
        $sql  = "UPDATE mlm_member_autosave 
                    SET status = '".$this->get_status()."', updated_at = '".$this->get_updated_at()."'
                    WHERE id_member = '".$this->get_id_member()."'
                    AND id = '".$this->get_id()."'
                    AND status = '-1'";
        $c    = new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }

    public function konfirmasi_pesanan(){
        $sql  = "UPDATE mlm_member_autosave 
                    SET status = '".$this->get_status()."', updated_at = '".$this->get_updated_at()."'
                    WHERE id_member = '".$this->get_id_member()."'
                    AND id = '".$this->get_id()."'
                    AND status = '2'";
        $c    = new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }
}