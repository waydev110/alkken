<?php
require_once "classConnection.php";

class classMember
{
    private $id_member;
    private $id_plan;
    private $id_produk_jenis;
    private $id_paket;
    private $id_peringkat;
    private $user_member;
    private $nama_samaran;
    private $nama_member;
    private $kode_aktivasi;
    private $tgl_lahir_member;
    private $angka_elemen;
    private $tempat_lahir_member;
    private $jns_kel_member;
    private $no_ktp_member;
    private $telp_member;
    private $hp_member;
    private $pass_member;
    private $pin_member;
    private $sponsor;
    private $upline;
    private $posisi;
    private $kaki_kiri;
    private $kaki_kanan;
    private $jumlah_kiri;
    private $jumlah_kanan;
    private $reposisi;
    private $founder;
    private $email_member;
    private $no_rekening;
    private $atas_nama_rekening;
    private $cabang_rekening;
    private $id_bank;
    private $status_member;
    private $id_provinsi;
    private $id_kota;
    private $id_kecamatan;
    private $id_kelurahan;
    private $rt;
    private $rw;
    private $alamat_member;
    private $kodepos_member;
    private $username_marketplace;
    private $address_coin;
    private $profile_updated;
    private $level;
    private $group_akun;
    private $created_at;  
    private $updated_at;
    private $deleted_at;
    
    public function get_id_member(){
		return $this->id_member;
	}

	public function set_id_member($id_member){
		$this->id_member = $id_member;
	}
    
    public function get_id_plan(){
		return $this->id_plan;
	}

	public function set_id_plan($id_plan){
		$this->id_plan = $id_plan;
	}
    
    public function get_id_produk_jenis(){
		return $this->id_produk_jenis;
	}

	public function set_id_produk_jenis($id_produk_jenis){
		$this->id_produk_jenis = $id_produk_jenis;
	}
    
    public function get_id_paket(){
		return $this->id_paket;
	}

	public function set_id_paket($id_paket){
		$this->id_paket = $id_paket;
	}
    
    public function get_id_peringkat(){
		return $this->id_peringkat;
	}

	public function set_id_peringkat($id_peringkat){
		$this->id_peringkat = $id_peringkat;
	}
    
    public function get_user_member(){
		return $this->user_member;
	}

	public function set_user_member($user_member){
		$this->user_member = $user_member;
	}
    
    public function get_nama_samaran(){
		return $this->nama_samaran;
	}

	public function set_nama_samaran($nama_samaran){
		$this->nama_samaran = $nama_samaran;
	}
    
    public function get_nama_member(){
		return $this->nama_member;
	}

	public function set_nama_member($nama_member){
		$this->nama_member = $nama_member;
	}
    
    public function get_kode_aktivasi(){
		return $this->kode_aktivasi;
	}

	public function set_kode_aktivasi($kode_aktivasi){
		$this->kode_aktivasi = $kode_aktivasi;
	}
    
    public function get_tgl_lahir_member(){
		return $this->tgl_lahir_member;
	}

	public function set_tgl_lahir_member($tgl_lahir_member){
		$this->tgl_lahir_member = $tgl_lahir_member;
	}
    
    public function get_angka_elemen(){
		return $this->angka_elemen;
	}

	public function set_angka_elemen($angka_elemen){
		$this->angka_elemen = $angka_elemen;
	}
    
    public function get_tempat_lahir_member(){
		return $this->tempat_lahir_member;
	}

	public function set_tempat_lahir_member($tempat_lahir_member){
		$this->tempat_lahir_member = $tempat_lahir_member;
	}
    
    public function get_jns_kel_member(){
		return $this->jns_kel_member;
	}

	public function set_jns_kel_member($jns_kel_member){
		$this->jns_kel_member = $jns_kel_member;
	}
    
    public function get_no_ktp_member(){
		return $this->no_ktp_member;
	}

	public function set_no_ktp_member($no_ktp_member){
		$this->no_ktp_member = $no_ktp_member;
	}
    
    public function get_telp_member(){
		return $this->telp_member;
	}

	public function set_telp_member($telp_member){
		$this->telp_member = $telp_member;
	}
    
    public function get_hp_member(){
		return $this->hp_member;
	}

	public function set_hp_member($hp_member){
		$this->hp_member = $hp_member;
	}
    
    public function get_pass_member(){
		return $this->pass_member;
	}

	public function set_pass_member($pass_member){
		$this->pass_member = $pass_member;
	}
    
    public function get_pin_member(){
		return $this->pin_member;
	}

	public function set_pin_member($pin_member){
		$this->pin_member = $pin_member;
	}
    
    public function get_sponsor(){
		return $this->sponsor;
	}

	public function set_sponsor($sponsor){
		$this->sponsor = $sponsor;
	}
    
    public function get_upline(){
		return $this->upline;
	}

	public function set_upline($upline){
		$this->upline = $upline;
	}
    
    public function get_posisi(){
		return $this->posisi;
	}

	public function set_posisi($posisi){
		$this->posisi = $posisi;
	}
    
    public function get_kaki_kiri(){
		return $this->kaki_kiri;
	}

	public function set_kaki_kiri($kaki_kiri){
		$this->kaki_kiri = $kaki_kiri;
	}
    
    public function get_kaki_kanan(){
		return $this->kaki_kanan;
	}

	public function set_kaki_kanan($kaki_kanan){
		$this->kaki_kanan = $kaki_kanan;
	}
    
    public function get_jumlah_kiri(){
		return $this->jumlah_kiri;
	}

	public function set_jumlah_kiri($jumlah_kiri){
		$this->jumlah_kiri = $jumlah_kiri;
	}
    
    public function get_jumlah_kanan(){
		return $this->jumlah_kanan;
	}

	public function set_jumlah_kanan($jumlah_kanan){
		$this->jumlah_kanan = $jumlah_kanan;
	}
    
    public function get_reposisi(){
		return $this->reposisi;
	}

	public function set_reposisi($reposisi){
		$this->reposisi = $reposisi;
	}
    
    public function get_founder(){
		return $this->founder;
	}

	public function set_founder($founder){
		$this->founder = $founder;
	}
    
    public function get_email_member(){
		return $this->email_member;
	}

	public function set_email_member($email_member){
		$this->email_member = $email_member;
	}
    
    public function get_no_rekening(){
		return $this->no_rekening;
	}

	public function set_no_rekening($no_rekening){
		$this->no_rekening = $no_rekening;
	}
    
    public function get_atas_nama_rekening(){
		return $this->atas_nama_rekening;
	}

	public function set_atas_nama_rekening($atas_nama_rekening){
		$this->atas_nama_rekening = $atas_nama_rekening;
	}
    
    public function get_cabang_rekening(){
		return $this->cabang_rekening;
	}

	public function set_cabang_rekening($cabang_rekening){
		$this->cabang_rekening = $cabang_rekening;
	}
    
    public function get_id_bank(){
		return $this->id_bank;
	}

	public function set_id_bank($id_bank){
		$this->id_bank = $id_bank;
	}
    
    public function get_status_member(){
		return $this->status_member;
	}

	public function set_status_member($status_member){
		$this->status_member = $status_member;
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
    
    public function get_rt(){
		return $this->rt;
	}

	public function set_rt($rt){
		$this->rt = $rt;
	}
    
    public function get_rw(){
		return $this->rw;
	}

	public function set_rw($rw){
		$this->rw = $rw;
	}
    
    public function get_alamat_member(){
		return $this->alamat_member;
	}

	public function set_alamat_member($alamat_member){
		$this->alamat_member = $alamat_member;
	}
    
    public function get_kodepos_member(){
		return $this->kodepos_member;
	}

	public function set_kodepos_member($kodepos_member){
		$this->kodepos_member = $kodepos_member;
	}
    
    public function get_username_marketplace(){
		return $this->username_marketplace;
	}

	public function set_username_marketplace($username_marketplace){
		$this->username_marketplace = $username_marketplace;
	}
    
    public function get_address_coin(){
		return $this->address_coin;
	}

	public function set_address_coin($address_coin){
		$this->address_coin = $address_coin;
	}
    
    public function get_profile_updated(){
		return $this->profile_updated;
	}

	public function set_profile_updated($profile_updated){
		$this->profile_updated = $profile_updated;
	}
    
    public function get_level(){
		return $this->level;
	}

	public function set_level($level){
		$this->level = $level;
	}
    
    public function get_group_akun(){
		return $this->group_akun;
	}

	public function set_group_akun($group_akun){
		$this->group_akun = $group_akun;
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

    public function create()
    {
        $sql =
            "INSERT INTO mlm_member (
                    id_member, 
                    id_plan, 
                    id_produk_jenis,
                    id_paket, 
                    id_peringkat, 
                    user_member, 
                    nama_samaran, 
                    nama_member, 
                    kode_aktivasi, 
                    tgl_lahir_member, 
                    angka_elemen, 
                    tempat_lahir_member, 
                    jns_kel_member, 
                    no_ktp_member, 
                    telp_member, 
                    hp_member, 
                    pass_member, 
                    pin_member, 
                    sponsor, 
                    upline, 
                    posisi, 
                    kaki_kiri, 
                    kaki_kanan, 
                    jumlah_kiri, 
                    jumlah_kanan, 
                    reposisi, 
                    founder, 
                    email_member, 
                    no_rekening, 
                    atas_nama_rekening, 
                    cabang_rekening, 
                    id_bank, 
                    status_member, 
                    id_provinsi, 
                    id_kota, 
                    id_kecamatan, 
                    id_kelurahan, 
                    rt, 
                    rw, 
                    alamat_member, 
                    kodepos_member, 
                    profile_updated, 
                    level, 
                    group_akun, 
                    created_at
                ) values (
                    '".$this->get_id_member()."',
                    '".$this->get_id_plan()."',
                    '".$this->get_id_produk_jenis()."',
                    '".$this->get_id_paket()."',
                    '".$this->get_id_peringkat()."',
                    '".$this->get_user_member()."',
                    '".$this->get_nama_samaran()."',
                    '".$this->get_nama_member()."',
                    '".$this->get_kode_aktivasi()."',
                    '".$this->get_tgl_lahir_member()."',
                    '".$this->get_angka_elemen()."',
                    '".$this->get_tempat_lahir_member()."',
                    '".$this->get_jns_kel_member()."',
                    '".$this->get_no_ktp_member()."',
                    '".$this->get_telp_member()."',
                    '".$this->get_hp_member()."',
                    '".$this->get_pass_member()."',
                    '".$this->get_pin_member()."',
                    '".$this->get_sponsor()."',
                    '".$this->get_upline()."',
                    '".$this->get_posisi()."',
                    '".$this->get_kaki_kiri()."',
                    '".$this->get_kaki_kanan()."',
                    '".$this->get_jumlah_kiri()."',
                    '".$this->get_jumlah_kanan()."',
                    '".$this->get_reposisi()."',
                    '".$this->get_founder()."',
                    '".$this->get_email_member()."',
                    '".$this->get_no_rekening()."',
                    '".$this->get_atas_nama_rekening()."',
                    '".$this->get_cabang_rekening()."',
                    '".$this->get_id_bank()."',
                    '".$this->get_status_member()."',
                    '".$this->get_id_provinsi()."',
                    '".$this->get_id_kota()."',
                    '".$this->get_id_kecamatan()."',
                    '".$this->get_id_kelurahan()."',
                    '".$this->get_rt()."',
                    '".$this->get_rw()."',
                    '".$this->get_alamat_member()."',
                    '".$this->get_kodepos_member()."',
                    '".$this->get_profile_updated()."',
                    '".$this->get_level()."',
                    '".$this->get_group_akun()."',
                    '".$this->get_created_at()."'
                )";
        $c = new classConnection();
        $query = $c->_query_insert($sql);
        return $query;
    }

    public function datatable($request){
        $c    = new classConnection();

        $col = [
                    'm.id', 
                    'm.id_member', 
                    'm.nama_member', 
                    'm.created_at',
                    's.id',
                    'pin_count.total_pin',
                    'm.id'];  
        $data_search =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'm.nama_samaran',
            'c.nama_kota',
            'm.hp_member',
            'm.user_member'
            );
        
        $sql ="SELECT 
                    m.id, 
                    m.id_member, 
                    m.reposisi, 
                    m.group_akun,
                    pl.nama_plan, 
                    pl.gambar as icon_plan, 
                    pj.short_name,
                    m.hp_member, 
                    m.nama_member, 
                    m.user_member, 
                    m.nama_samaran,
                    d.nama_provinsi, 
                    c.nama_kota, 
                    e.nama_kecamatan, 
                    m.created_at, 
                    m.pass_member, 
                    m.pin_member,
                    m.sponsor,
                    s.id_member as id_sponsor,
                    s.nama_samaran as nama_samaran_sponsor,
                    s.nama_member as nama_sponsor,
                    fs.name as nama_founder,
                    pin_count.total_pin,
                    bm.total_sponsori
                FROM mlm_member as m
                LEFT JOIN mlm_member as s ON m.sponsor = s.id 
                LEFT JOIN mlm_bonus_founder_setting as fs ON m.founder = fs.id 
                LEFT JOIN mlm_plan as pl ON m.id_plan = pl.id 
                LEFT JOIN mlm_produk_jenis as pj ON m.id_produk_jenis = pj.id 
                LEFT JOIN mlm_kota as c ON m.id_kota = c.id 
                LEFT JOIN mlm_provinsi as d ON m.id_provinsi = d.id 
                LEFT JOIN mlm_kecamatan as e ON m.id_kecamatan = e.id 
                LEFT JOIN (
                    SELECT id_member, COUNT(*) AS total_pin 
                    FROM mlm_kodeaktivasi 
                    WHERE status_aktivasi = '0' AND deleted_at IS NULL 
                    GROUP BY id_member
                ) AS pin_count ON m.id = pin_count.id_member
                LEFT JOIN (
                        SELECT sponsor, COUNT(*) AS total_sponsori
                        FROM mlm_member
                        WHERE id_plan IN (16, 17)
                        AND deleted_at IS NULL
                        AND reposisi = '0'
                        GROUP BY sponsor
                    ) bm ON m.id = bm.sponsor
                WHERE m.status_member = '1' 
                AND m.deleted_at IS NULL";
        $query  = $c->_query($sql);

        $totalData=$query->num_rows;
        if(is_numeric($request['provinsi'])){
            $sql.=" AND m.id_provinsi = '".$request['provinsi']."' ";
        }
        if(is_numeric($request['kota'])){
            $sql.=" AND m.id_kota = '".$request['kota']."' ";
        }
        if(is_numeric($request['kecamatan'])){
            $sql.=" AND m.id_kecamatan = '".$request['kecamatan']."' ";
        }
        if(is_numeric($request['id_plan'])){
            $sql.=" AND m.id_plan = '".$request['id_plan']."' ";
        }
        if(is_numeric($request['id_produk_jenis'])){
            $sql.=" AND m.id_produk_jenis = '".$request['id_produk_jenis']."' ";
        }
        if(is_numeric($request['founder'])){
            $sql.=" AND m.founder = '".$request['founder']."' ";
        }
        if(is_numeric($request['reposisi'])){
            $sql.=" AND m.reposisi = '".$request['reposisi']."' ";
        }
        if(is_numeric($request['qualified'])){
            if($request['qualified'] == '1'){
                $sql.=" AND m.id_plan IN (16,17) AND bm.total_sponsori >= 2";
            } else {
                $sql.=" AND m.id_plan IN (16,17) AND (bm.total_sponsori < 2 OR bm.total_sponsori IS NULL)";   
            }
        }

        if(!empty($request['keyword'])){
            $array_search = array();
            foreach ($data_search as $key => $value) {
                $array_search[] ="$value LIKE '%".$request['keyword']."%'";
            }
            $sql_search = implode(' OR ', $array_search);
            $sql.=" AND (".$sql_search.")";
        }

        $query  = $c->_query($sql);

        $totalFilter=$query->num_rows;
        $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
        if($request['length'] > 0){
            $sql.="  LIMIT ". $request['start'].",".$request['length']."  ";
        }
        $query  = $c->_query($sql);
        $data=array();
        $no = $request['start'] + 1;
        while($row = $query->fetch_object()){
            if($row->user_member == '' || $row->user_member == NULL){
                $user_member = '';
            } else {
                $user_member = '<strong>Username : </strong><span id="user_member'.$row->id.'">'.$row->user_member.'</span> <button class="btn btn-xs  btn-transparent ml-2" onclick="copyToClipboard('."'#user_member$row->id'".')"><i class="fa fa-copy"></i></button>';
            }
            $id = '<strong>ID : </strong><span id="id'.$row->id.'">'.$row->id.'</span> <button class="btn btn-xs  btn-transparent ml-2" onclick="copyToClipboard('."'#id$row->id'".')"><i class="fa fa-copy"></i></button>';
            $id_member = '<br><strong>ID Member : </strong><span id="id_member'.$row->id.'">'.$row->id_member.'</span> <button class="btn btn-xs  btn-transparent ml-2" onclick="copyToClipboard('."'#id_member$row->id'".')"><i class="fa fa-copy"></i></button><br>';
            $password = '<br><strong>Password : </strong><span id="pass_member'.$row->id.'">'.base64_decode($row->pass_member).'</span> <button class="btn btn-xs btn-transparent ml-2" onclick="copyToClipboard('."'#pass_member$row->id'".')"><i class="fa fa-copy"></i></button>';
            $pin = '<br><strong>PIN : </strong><span id="pin_member'.$row->id.'">'.base64_decode($row->pin_member).'</span> <button class="btn btn-xs  btn-transparent ml-2" onclick="copyToClipboard('."'#pin_member$row->id'".')"><i class="fa fa-copy"></i></button>';
            $group_akun = '<br><strong>Group Akun : </strong><span id="group_akun'.$row->id.'">'.$row->group_akun.'</span> <button class="btn btn-xs  btn-transparent ml-2" onclick="copyToClipboard('."'#group_akun$row->id'".')"><i class="fa fa-copy"></i></button>';
            
            $hp_member = '<br><strong>No WA : </strong><span id="hp_member'.$row->id.'">'.$row->hp_member.'</span> <button class="btn btn-xs  btn-transparent ml-2" onclick="copyToClipboard('."'#hp_member$row->id'".')"><i class="fa fa-copy"></i></button><br>';
            $plan = '<img src="../images/plan/'.$row->icon_plan.'" width="60"><br><strong>'.$row->nama_plan.'</strong><br><strong>'.$row->short_name.'</strong><br><strong>'.$row->nama_founder.'</strong>';
            $reposisi = '<br><strong>Reposisi : '.($row->reposisi == '1' ? 'Ya':'Tidak').'</strong>';
            
            $nama_member= '<br><strong>Nama Member : </strong><br>'.strtoupper($row->nama_member);
            $id_sponsor = $row->sponsor == 'master' ? '' : '<strong>ID Member : </strong><br><span id="id_sponsor'.$row->sponsor.'">'.$row->id_sponsor.'</span> <button class="btn btn-xs  btn-transparent ml-2" onclick="copyToClipboard('."'#id_sponsor$row->sponsor'".')"><i class="fa fa-copy"></i></button>';
            $nama_sponsor= $row->sponsor == 'master' ? 'Master' : '<strong>Nama Lengkap : </strong><br>'.strtoupper($row->nama_sponsor);
            
            $provinsi = $row->nama_provinsi == '' ? '' : 'Provinsi '.$row->nama_provinsi.'<br>';
            $nama_kota = $row->nama_kota == '' ? '' : $row->nama_kota.'<br>';
            $nama_kecamatan = $row->nama_provinsi == '' ? '' : 'Kecamatan '.$row->nama_kecamatan;
            $alamat = $provinsi.$nama_kota.$nama_kecamatan;
            
            $subdata=array();
            $subdata[]= $no; //id           
            $subdata[]= $plan;
            $subdata[]= $id.$id_member.$user_member.$password.$pin.$group_akun.$reposisi; 
            $subdata[]= $nama_member.$hp_member.'<strong>Alamat :</strong><br>'.$alamat;
            $subdata[]= date('Y-m-d H:i', strtotime($row->created_at));
            $subdata[]= $id_sponsor.'<br>'.$nama_sponsor;
            $subdata[]= currency($row->total_pin);
            $subdata[]='
                <a href="index.php?go=member_edit&id='.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                <a onclick="sendsmsmember('.'"'.$row->id.'"'.')" class="btn btn-info btn-xs"><i class="fa fa-envelope"></i></a>
                <a target="_blank" href="index.php?go=bypass_login&id='.base64_encode($row->id).'" class="btn btn-danger btn-xs bypass"><i class="fa fa-sign-in"></i></a>
            ';
            $data[]=$subdata;
            $no++;
        }

        $json_data=array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "data"              =>  $data
        );
        return json_encode($json_data);
    }

    public function datatable_elemen($request){
        $c    = new classConnection();
        $c->openConnection();
        
        $col = [
                    'm.id', 
                    'm.id_member',
                    'm.nama_member',
                    'm.tgl_lahir_member',
                    'm.angka_elemen',
                    'e.nama_elemen', 
                    'm.jumlah_kiri', 
                    'm.jumlah_kanan', 
                    'm.id'
                ];
        
        $sql ="SELECT 
                    m.id, 
                    m.id_member, 
                    m.nama_member, 
                    m.tgl_lahir_member, 
                    m.angka_elemen,
                    e.nama_elemen,
                    m.jumlah_kiri, 
                    m.jumlah_kanan
                FROM mlm_member m
                LEFT JOIN mlm_elemen e ON m.angka_elemen = e.id 
                WHERE m.deleted_at IS NULL";
        $query  = $c->koneksi->query($sql);
    
        $totalData=$query->num_rows;
        
        if(!empty($request['keyword'])){
            $sql.=" AND (m.id_member Like '".$request['keyword']."%' ";
            $sql.=" OR m.nama_member Like '".$request['keyword']."%' ";
            $sql.=" OR e.nama_elemen Like '".$request['keyword']."%' )";
            
        }
        if(is_numeric($request['angka_elemen'])){
            $sql.=" AND m.angka_elemen = '".$request['angka_elemen']."' ";
        }
        // if(!empty($request['notif'])){
        //     if($request['notif'] == '1'){
        //         $sql.=" AND m.usia = TIMESTAMPDIFF(YEAR, m.tgl_lahir_member, CURDATE())";
        //     }
        //     if($request['notif'] == '2'){
        //         $sql.=" AND (m.usia <> TIMESTAMPDIFF(YEAR, m.tgl_lahir_member, CURDATE()) OR m.usia IS NULL) ";
        //     }
        // }
        if(strlen($request['tgl_lahir_member']) > 0){
            $sql.=" AND RIGHT(m.tgl_lahir_member, 5) = '".date('m-d', strtotime($request['tgl_lahir_member']))."' ";
        }
        $query  = $c->koneksi->query($sql);
        $totalFilter=$query->num_rows;
        $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
        if($request['length'] > 0){
            $sql.="  LIMIT ". $request['start'].",".$request['length']."  ";
        }
        
    
        $query  = $c->koneksi->query($sql);
        
        $data=array();
        
        // echo ($query);
        $no = $request['start'] + 1;
        while($row = $query->fetch_object()){
            $subdata=array();
            $subdata[]=$no; //id
            $subdata[]= '<a href="?go=member_detail&id='.base64_encode($row->id).'">'.$row->id_member.' | '.$row->id.'</a>';
            $subdata[]= $row->nama_member;
            $subdata[]= $row->tgl_lahir_member;
            $subdata[]= $row->angka_elemen;
            $subdata[]= $row->nama_elemen;
            $subdata[]= $row->jumlah_kiri;
            $subdata[]= $row->jumlah_kanan;
            $subdata[]="
              <a onclick='sendsmsbirthday(".$row->id.")' class='btn btn-info btn-xs'><i class='fab fa-whatsapp'></i></a>
              <a target='_blank' href='index.php?go=bypass_login&id=".base64_encode($row->id)."' class='btn btn-danger btn-xs bypass'><i class='fa fa-sign-in'></i></a>
            ";
            $data[]=$subdata;
            $no ++;  
        }
    
        $json_data=array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "data"              =>  $data
        );
        return json_encode($json_data);
        #echo $sql;
      }


    
    public function datatable_download($request){
        $c    = new classConnection();

        $col = [
                    'a.id', 
                    'a.nama_member', 
                    'a.id_member',  
                    'a.hp_member', 
                    'p.nama_peringkat',
                    's.nama_member', 
                    's.id_member',  
                    's.hp_member'
                    ];  
        $data_search =array(
            'a.id',
            'a.id_member',
            'a.nama_member',
            'a.nama_samaran',
            'c.nama_kota',
            'a.hp_member',
            'a.user_member',
            's.id_member',
            's.nama_member',
            's.nama_samaran'
            );
        
        $sql ="SELECT 
                    a.id, 
                    a.id_member, 
                    a.reposisi, 
                    a.group_akun,
                    pl.nama_plan, 
                    pk.gambar as icon_paket, 
                    pl.gambar as icon_plan, 
                    pk.nama_paket, 
                    p.gambar, 
                    p.nama_peringkat, 
                    a.hp_member, 
                    a.nama_member, 
                    a.user_member, 
                    a.nama_samaran,
                    d.nama_provinsi, 
                    c.nama_kota, 
                    e.nama_kecamatan, 
                    a.created_at, 
                    a.pass_member, 
                    a.pin_member,
                    a.sponsor,
                    s.id_member as id_sponsor,
                    s.nama_samaran as nama_samaran_sponsor,
                    s.nama_member as nama_sponsor,
                    s.hp_member as hp_sponsor,
                    fs.name as nama_founder
                FROM mlm_member as a 
                LEFT JOIN mlm_member as s ON a.sponsor = s.id 
                LEFT JOIN mlm_bonus_founder_setting as fs ON a.founder = fs.id 
                LEFT JOIN mlm_paket as pk ON a.id_paket = pk.id 
                LEFT JOIN mlm_plan as pl ON a.id_plan = pl.id 
                LEFT JOIN mlm_peringkat as p ON a.id_peringkat = p.id 
                LEFT JOIN mlm_kota as c ON a.id_kota = c.id 
                LEFT JOIN mlm_provinsi as d ON a.id_provinsi = d.id 
                LEFT JOIN mlm_kecamatan as e ON a.id_kecamatan = e.id 
                WHERE a.status_member = '1' and a.deleted_at is null";
        $query  = $c->_query($sql);

        $totalData=$query->num_rows;
        if(is_numeric($request['provinsi'])){
            $sql.=" AND a.id_provinsi = '".$request['provinsi']."' ";
        }
        if(is_numeric($request['kota'])){
            $sql.=" AND a.id_kota = '".$request['kota']."' ";
        }
        if(is_numeric($request['kecamatan'])){
            $sql.=" AND a.id_kecamatan = '".$request['kecamatan']."' ";
        }
        if(is_numeric($request['id_plan'])){
            $sql.=" AND a.id_plan = '".$request['id_plan']."' ";
        }
        if(is_numeric($request['id_peringkat'])){
            $sql.=" AND a.id_peringkat = '".$request['id_peringkat']."' ";
        }
        if(is_numeric($request['founder'])){
            $sql.=" AND a.founder = '".$request['founder']."' ";
        }
        if(is_numeric($request['reposisi'])){
            $sql.=" AND a.reposisi = '".$request['reposisi']."' ";
        }
        // if(is_numeric($request['status_member'])){
        //     $sql.=" AND s.status_member = '".$request['status_member']."' ";
        // }
        // if($request['reposisi'] == '0' || $request['reposisi'] == '1'){
        //     $sql.=" AND a.reposisi = '".$request['reposisi']."' ";
        // }

        if(!empty($request['keyword'])){
            $array_search = array();
            foreach ($data_search as $key => $value) {
                $array_search[] ="$value LIKE '%".$request['keyword']."%'";
            }
            $sql_search = implode(' OR ', $array_search);
            $sql.=" AND (".$sql_search.")";
        }

        $query  = $c->_query($sql);

        $totalFilter=$query->num_rows;
        $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
        if($request['length'] > 0){
            $sql.="  LIMIT ". $request['start'].",".$request['length']."  ";
        }
        $query  = $c->_query($sql);
        $data=array();
        $no = $request['start'] + 1;
        while($row = $query->fetch_object()){
            $subdata=array();
            $subdata[]= $no;   
            $subdata[]= $row->nama_member;  
            $subdata[]= $row->id_member;  
            $subdata[]= $row->nama_peringkat == NULL ? 'Non Peringkat' : $row->nama_peringkat;  
            $subdata[]= $row->hp_member; 
            $subdata[]= $row->sponsor == 'master' ? 'Master' : $row->nama_sponsor; 
            $subdata[]= $row->sponsor == 'master' ? 'Master' : $row->id_sponsor; 
            $subdata[]= $row->sponsor == 'master' ? '-' : $row->hp_sponsor; 
            
            
            $data[]=$subdata;
            $no++;
        }

        $json_data=array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "data"              =>  $data
        );
        return json_encode($json_data);
    }
    
    public function update_reposisi($id){
        $sql  = "UPDATE mlm_member SET  
                    reposisi = '0', 
                    id_peringkat = '2'
                where id='$id'";
        $c    = new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }

    public function index(){
        $sql  = "SELECT * FROM mlm_member WHERE deleted_at IS NULL ORDER BY id ASC";
        $c    = new classConnection();
        $query 	= $c->_query($sql);
        return $query;
    }

    public function show_by_id($id_member)
    {
        $sql = "SELECT * FROM mlm_member
                WHERE
                id_member = '$id_member' AND
                deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }
    public function history($kode_aktivasi)
    {
        $sql = "SELECT m.id as member_id, m.id_member, m.nama_member, m.level, m.created_at,
                        s.id as sponsor_id, s.id_member as id_sponsor, s.nama_member as nama_sponsor 
                    FROM mlm_member m
                    LEFT JOIN mlm_member s ON m.sponsor = s.id
                    WHERE
                    m.kode_aktivasi = '$kode_aktivasi'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }
    
    public function daftar_elemen(){
        $sql  = "SELECT * FROM mlm_elemen ORDER BY id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function update($id)
    {
        $sql =
            "UPDATE mlm_member SET
                    id_member = CASE WHEN LENGTH('".$this->get_id_member()."') > 0 THEN '".$this->get_id_member()."'  ELSE id_member END,
                    id_plan = CASE WHEN LENGTH('".$this->get_id_plan()."') > 0 THEN '".$this->get_id_plan()."'  ELSE id_plan END,
                    id_produk_jenis = CASE WHEN LENGTH('".$this->get_id_produk_jenis()."') > 0 THEN '".$this->get_id_produk_jenis()."'  ELSE id_produk_jenis END,
                    user_member = CASE WHEN LENGTH('".$this->get_user_member()."') > 0 THEN '".$this->get_user_member()."'  ELSE user_member END,
                    nama_samaran = CASE WHEN LENGTH('".$this->get_nama_samaran()."') > 0 THEN '".$this->get_nama_samaran()."'  ELSE nama_samaran END,
                    nama_member = CASE WHEN LENGTH('".$this->get_nama_member()."') > 0 THEN '".$this->get_nama_member()."'  ELSE nama_member END,
                    kode_aktivasi = CASE WHEN LENGTH('".$this->get_kode_aktivasi()."') > 0 THEN '".$this->get_kode_aktivasi()."'  ELSE kode_aktivasi END,
                    tgl_lahir_member = CASE WHEN LENGTH('".$this->get_tgl_lahir_member()."') > 0 THEN '".$this->get_tgl_lahir_member()."'  ELSE tgl_lahir_member END,
                    angka_elemen = CASE WHEN LENGTH('".$this->get_angka_elemen()."') > 0 THEN '".$this->get_angka_elemen()."'  ELSE angka_elemen END,
                    tempat_lahir_member = CASE WHEN LENGTH('".$this->get_tempat_lahir_member()."') > 0 THEN '".$this->get_tempat_lahir_member()."'  ELSE tempat_lahir_member END,
                    jns_kel_member = CASE WHEN LENGTH('".$this->get_jns_kel_member()."') > 0 THEN '".$this->get_jns_kel_member()."'  ELSE jns_kel_member END,
                    no_ktp_member = CASE WHEN LENGTH('".$this->get_no_ktp_member()."') > 0 THEN '".$this->get_no_ktp_member()."'  ELSE no_ktp_member END,
                    telp_member = CASE WHEN LENGTH('".$this->get_telp_member()."') > 0 THEN '".$this->get_telp_member()."'  ELSE telp_member END,
                    hp_member = CASE WHEN LENGTH('".$this->get_hp_member()."') > 0 THEN '".$this->get_hp_member()."'  ELSE hp_member END,
                    pass_member = CASE WHEN LENGTH('".$this->get_pass_member()."') > 0 THEN '".$this->get_pass_member()."'  ELSE pass_member END,
                    pin_member = CASE WHEN LENGTH('".$this->get_pin_member()."') > 0 THEN '".$this->get_pin_member()."'  ELSE pin_member END,
                    sponsor = CASE WHEN LENGTH('".$this->get_sponsor()."') > 0 THEN '".$this->get_sponsor()."'  ELSE sponsor END,
                    upline = CASE WHEN LENGTH('".$this->get_upline()."') > 0 THEN '".$this->get_upline()."'  ELSE upline END,
                    posisi = CASE WHEN LENGTH('".$this->get_posisi()."') > 0 THEN '".$this->get_posisi()."'  ELSE posisi END,
                    kaki_kiri = CASE WHEN LENGTH('".$this->get_kaki_kiri()."') > 0 THEN '".$this->get_kaki_kiri()."'  ELSE kaki_kiri END,
                    kaki_kanan = CASE WHEN LENGTH('".$this->get_kaki_kanan()."') > 0 THEN '".$this->get_kaki_kanan()."'  ELSE kaki_kanan END,
                    jumlah_kiri = CASE WHEN LENGTH('".$this->get_jumlah_kiri()."') > 0 THEN '".$this->get_jumlah_kiri()."'  ELSE jumlah_kiri END,
                    jumlah_kanan = CASE WHEN LENGTH('".$this->get_jumlah_kanan()."') > 0 THEN '".$this->get_jumlah_kanan()."'  ELSE jumlah_kanan END,
                    reposisi = CASE WHEN LENGTH('".$this->get_reposisi()."') > 0 THEN '".$this->get_reposisi()."'  ELSE reposisi END,
                    email_member = CASE WHEN LENGTH('".$this->get_email_member()."') > 0 THEN '".$this->get_email_member()."'  ELSE email_member END,
                    no_rekening = CASE WHEN LENGTH('".$this->get_no_rekening()."') > 0 THEN '".$this->get_no_rekening()."'  ELSE no_rekening END,
                    atas_nama_rekening = CASE WHEN LENGTH('".$this->get_atas_nama_rekening()."') > 0 THEN '".$this->get_atas_nama_rekening()."'  ELSE atas_nama_rekening END,
                    cabang_rekening = CASE WHEN LENGTH('".$this->get_cabang_rekening()."') > 0 THEN '".$this->get_cabang_rekening()."'  ELSE cabang_rekening END,
                    id_bank = CASE WHEN LENGTH('".$this->get_id_bank()."') > 0 THEN '".$this->get_id_bank()."'  ELSE id_bank END,
                    status_member = CASE WHEN LENGTH('".$this->get_status_member()."') > 0 THEN '".$this->get_status_member()."'  ELSE status_member END,
                    id_provinsi = CASE WHEN LENGTH('".$this->get_id_provinsi()."') > 0 THEN '".$this->get_id_provinsi()."'  ELSE id_provinsi END,
                    id_kota = CASE WHEN LENGTH('".$this->get_id_kota()."') > 0 THEN '".$this->get_id_kota()."'  ELSE id_kota END,
                    id_kecamatan = CASE WHEN LENGTH('".$this->get_id_kecamatan()."') > 0 THEN '".$this->get_id_kecamatan()."'  ELSE id_kecamatan END,
                    id_kelurahan = CASE WHEN LENGTH('".$this->get_id_kelurahan()."') > 0 THEN '".$this->get_id_kelurahan()."'  ELSE id_kelurahan END,
                    rt = CASE WHEN LENGTH('".$this->get_rt()."') > 0 THEN '".$this->get_rt()."'  ELSE rt END,
                    rw = CASE WHEN LENGTH('".$this->get_rw()."') > 0 THEN '".$this->get_rw()."'  ELSE rw END,
                    alamat_member = CASE WHEN LENGTH('".$this->get_alamat_member()."') > 0 THEN '".$this->get_alamat_member()."'  ELSE alamat_member END,
                    kodepos_member = CASE WHEN LENGTH('".$this->get_kodepos_member()."') > 0 THEN '".$this->get_kodepos_member()."'  ELSE kodepos_member END,
                    profile_updated = CASE WHEN LENGTH('".$this->get_profile_updated()."') > 0 THEN '".$this->get_profile_updated()."'  ELSE profile_updated END,
                    username_marketplace = CASE WHEN LENGTH('".$this->get_username_marketplace()."') > 0 THEN '".$this->get_username_marketplace()."'  ELSE username_marketplace END,
                    address_coin = CASE WHEN LENGTH('".$this->get_address_coin()."') > 0 THEN '".$this->get_address_coin()."'  ELSE address_coin END,
                    level = CASE WHEN LENGTH('".$this->get_level()."') > 0 THEN '".$this->get_level()."'  ELSE level END,
                    group_akun = CASE WHEN LENGTH('".$this->get_group_akun()."') > 0 THEN '".$this->get_group_akun()."'  ELSE group_akun END,
                updated_at = CASE WHEN LENGTH('".$this->get_updated_at()."' ) > 0 THEN '".$this->get_updated_at()."'   ELSE updated_at END,
                profile_updated = '1'
            WHERE id = '$id'";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM mlm_member WHERE id = '$id'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }
    public function update_paket($id, $id_paket)
    {
        $sql = "UPDATE mlm_member SET id_paket = $id_paket WHERE id = '$id'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function admin_config($part)
    {
        $sql = "SELECT value from mlm_admin_configs where part = '$part' and deleted_at is null";
        $c = new classConnection();
        $data = $c->_query_fetch($sql);
        if ($data) {
            return $data->value;
        } else {
            return false;
        }
    }

    public function cek_id($id)
    {
        $sql = "SELECT id_member from mlm_member where id_member = '$id' and deleted_at is null";
        $c = new classConnection();
        $query = $c->_query($sql);
        $data = $query->num_rows;
        if ($query) {
            return $data;
        } else {
            return false;
        }
    }
    public function cek_titik($id_member)
    {
        $sql = "SELECT COUNT(*) AS total from mlm_member where LEFT(id_member, 10) = LEFT('$id_member', 10)";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if ($query) {
            return $query->total + 1;
        } else {
            return false;
        }
    }

    public function show_id($id_member)
    {
        $sql = "SELECT id from mlm_member where id_member = '$id_member' and deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->id;
        }
        return $query;
    }

    public function show_id_by_user_and_id($id_member)
    {
        $sql = "SELECT id from mlm_member where (id_member = '$id_member' OR user_member = '$id_member') and deleted_at is null LIMIT 1";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function show_id_by_user($user_member)
    {
        $sql = "SELECT id from mlm_member where user_member = '$user_member' and deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function generate_id_member($len, $posfix)
    {
        $charset = "0123456789";
        $result = "";
        $prefix = strtoupper($this->admin_config("akronim_member"));

        $charArray = str_split($charset);
        for ($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            $result .= "" . $charArray[$randItem];
        }

        $id_member = $prefix . $result . $posfix;

        $cek = $this->cek_id($id_member);
        if ($cek == 1) {
            return $this->generate_id_member(5, $posfix);
        } else {
            return $id_member;
        }
    }

    public function generate_group_akun($prefix, $len)
    {
        $charset = "0123456789";
        $result = "";

        $charArray = str_split($charset);
        for ($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            $result .= "" . $charArray[$randItem];
        }

        $group_id = $prefix.$result;

        return $group_id;
    }

    public function show($id)
    {
        $sql = "SELECT * FROM mlm_member
        WHERE
        id = '$id' AND
        deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }
    public function cek_nomor_rekening($no_rekening)
    {
        $sql = "SELECT group_akun FROM mlm_member WHERE no_rekening = '$no_rekening' LIMIT 1";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->group_akun;
        }
        return false;
    }
    

    public function show_nama($id_member)
    {
        $sql = "SELECT id, id_member, nama_member FROM mlm_member
        WHERE id_member = '$id_member' AND
        deleted_at is null";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }
    public function jumlah_akun($group_akun)
    {
        $sql = "SELECT COUNT(*) AS total FROM mlm_member
        WHERE group_akun = '$group_akun'";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function show_field($field, $id)
    {
        $sql = "SELECT $field FROM mlm_member
        WHERE id = '$id' AND deleted_at is null";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->$field;
    }

    public function detail($id)
    {
        $sql = "SELECT m.*, 
                    pl.nama_plan,
                    pj.short_name,
                    pl.bg_color,
                    pl.tingkat,
                    pl.max_autosave,
                    ms.nama_paket,
                    ms.poin as poin_paket,
                    ms.gambar as icon_paket,
                    pl.gambar as icon_plan,
                    pl.minimal_wd,
                    pl.maximal_wd,
                    pl.max_pasangan,
                    pl.max_autosave,
                    pr.nama_peringkat,
                    pr.gambar,
                    k.nama_kota, 
                    p.nama_provinsi,
                    c.nama_kecamatan,
                    l.nama_kelurahan,
                    b.nama_bank,
                    s.id_member as id_sponsor,
                    s.nama_member as nama_sponsor, 
                    s.user_member as username_sponsor,
                    s.nama_samaran as nama_samaran_sponsor,
                    s.hp_member as hp_sponsor,  
                    u.id_member as id_upline,
                    u.nama_member as nama_upline, 
                    u.user_member as username_upline,
                    u.nama_samaran as nama_samaran_upline,
                    u.hp_member as hp_upline
                    FROM mlm_member m
                    LEFT JOIN mlm_member s ON m.sponsor = s.id
                    LEFT JOIN mlm_member u ON m.upline = u.id
                    LEFT JOIN mlm_bank b ON m.id_bank = b.id
                    LEFT JOIN mlm_plan pl ON m.id_plan = pl.id
                    LEFT JOIN mlm_produk_jenis pj ON m.id_produk_jenis = pj.id
                    LEFT JOIN mlm_paket ms ON m.id_paket = ms.id
                    LEFT JOIN mlm_peringkat pr ON m.id_peringkat = pr.id
                    LEFT JOIN mlm_provinsi p ON m.id_provinsi = p.id
                    LEFT JOIN mlm_kota k ON m.id_kota = k.id
                    LEFT JOIN mlm_kecamatan c ON m.id_kecamatan = c.id
                    LEFT JOIN mlm_kelurahan l ON m.id_kelurahan = l.id
                    WHERE
                    m.id = '$id' AND
                    m.deleted_at is null";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function new_member()
    {
        $sql = "SELECT m.*, 
                    pr.nama_peringkat, k.nama_kota, b.nama_bank,
                    s.id_member as id_sponsor,
                    s.nama_member as nama_sponsor 
                    FROM mlm_member m
        LEFT JOIN mlm_member s ON m.sponsor = s.id
        LEFT JOIN mlm_bank b ON m.id_bank = b.id
        LEFT JOIN mlm_peringkat pr ON m.id_peringkat = pr.id
        LEFT JOIN mlm_kota k ON m.id_kota = k.id
        WHERE m.deleted_at is null
        AND LEFT(m.created_at, 10) = '".date('Y-m-d')."'
        ORDER BY m.created_at DESC";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function genealogy($id, $session_id = null)
    {
        $sql = "SELECT a.*
                    FROM mlm_member a 
                    WHERE (a.id='$id' OR a.id_member='$id' OR a.user_member='$id' OR a.nama_samaran='$id') 
                    AND a.id >= '$session_id' 
                    AND a.deleted_at IS NULL LIMIT 1";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function genealogy_member($id)
    {
        $sql = "CALL getDownline($id)";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function genealogy_level($id)
    {
        $sql = "CALL getDownlineLevel($id)";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function toDownline($id, $posisi)
    {
        $sql = "CALL toDownline($id, '$posisi')";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function getEndLevel($id)
    {
        $sql = "CALL getEndLevel($id)";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function top_sponsor($bulan = '')
    {
        $sql = "SELECT m.id, m.id_member, m.nama_samaran, m.nama_member, k.nama_kota, p.nama_plan, p.gambar, jumlah 
                    FROM mlm_member m 
                    LEFT JOIN mlm_plan p
                    ON m.id_plan = p.id
                    LEFT JOIN (SELECT 
              		s.sponsor as id_member,
                  		COUNT(s.sponsor) as jumlah
                  		FROM mlm_member s 
                        WHERE s.reposisi = '0'
              		GROUP BY s.sponsor) j ON j.id_member = m.id
                    LEFT JOIN mlm_kota k ON m.id_kota = k.id
                    WHERE CASE WHEN LENGTH('$bulan') > 0 THEN LEFT(m.created_at, 7) = '$bulan' ELSE 1 END 
                    AND m.deleted_at IS NULL AND m.status_member = '1' AND jumlah > 0
                    ORDER BY jumlah DESC LIMIT 5";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function top_ro($bulan = '')
    {
        $sql = "SELECT m.id, m.id_member, m.nama_samaran, m.nama_member, k.nama_kota, p.nama_plan, p.gambar, COALESCE(SUM(ka.harga), 0) AS jumlah 
                    FROM mlm_kodeaktivasi ka
                    LEFT JOIN mlm_member m ON ka.id_member = m.id 
                    LEFT JOIN mlm_plan p ON m.id_plan = p.id
                    LEFT JOIN mlm_kota k ON m.id_kota = k.id
                    WHERE CASE WHEN LENGTH('$bulan') > 0 THEN LEFT(ka.updated_at, 7) = '$bulan' ELSE 1 END 
                    AND ka.jenis_aktivasi = '1' 
                    AND ka.status_aktivasi = '1'
                    AND m.deleted_at IS NULL AND m.status_member = '1'
                    GROUP BY ka.id_member
                    ORDER BY jumlah DESC LIMIT 5";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function get_downline($sponsor)
    {
        $sql = "SELECT m.id, 
                        m.id_member, 
                        m.nama_member, 
                        m.nama_samaran, 
                        m.level, 
                        pk.gambar as icon_paket, 
                        pk.nama_paket, 
                        p.gambar, 
                        p.nama_peringkat, 
                        m.reposisi, 
                        m.created_at
                FROM mlm_member m
                LEFT JOIN mlm_paket pk
                ON m.id_paket = pk.id
                LEFT JOIN mlm_peringkat p
                ON m.id_peringkat = p.id
                WHERE m.sponsor = $sponsor 
                ORDER BY m.id ASC";
                // echo $sql;
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function cek_field_unique($field, $value, $id)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_member WHERE $field = '$value' AND id <> '$id'";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function cek_wa($value)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_member WHERE hp_member LIKE '%$value'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function cek_email($value)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_member WHERE email_member = '$value'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function cek_username_marketplace($id_member, $value)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_member WHERE username_marketplace = '$value' AND id <> '$id_member'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function cek_address_coin($id_member, $value)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_member WHERE address_coin = '$value' AND id <> '$id_member'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function cek_posisi($id)
    {
        $sql = "SELECT kaki_kiri, kaki_kanan FROM mlm_member 
                WHERE id = '$id' AND deleted_at is null";
        $c = new classConnection();
        $query = $c->_query($sql);
        if ($query) {
            $data = $query->fetch_object();
            if (empty($data->kaki_kiri)) {
                return "kiri";
            } elseif (empty($data->kaki_kanan)) {
                return "kanan";
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function cek_posisi_kaki($id, $posisi)
    {
        $posisi = 'kaki_'.$posisi;
        $sql = "SELECT $posisi FROM mlm_member 
                WHERE id = '$id' AND deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query) {
            if (empty($query->$posisi)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function update_kaki($upline, $insert, $posisi)
    {
        $sql = "UPDATE mlm_member SET kaki_$posisi = '$insert' WHERE id = '$upline'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function upgrade_plan($id_member, $id_plan, $id_plan_sebelumnya, $id_kodeaktivasi, $reposisi, $created_at)
    {
        $sql = "UPDATE mlm_member SET id_plan = '$id_plan', reposisi = '$reposisi' WHERE id = '$id_member'";
        $c = new classConnection();
        $query = $c->_query($sql);

        if($query) {        
            $sql = "INSERT INTO mlm_member_plan 
                        (id_member,
                        id_plan_sebelumnya,
                        id_plan,
                        manual_upgrade,
                        id_kodeaktivasi,
                        type,
                        created_at)
                        values
                        (
                            '$id_member',
                            '$id_plan_sebelumnya',
                            '$id_plan',
                            '1',
                            '$id_kodeaktivasi',
                            'upgrade',
                            '$created_at'
                        )";
            $query  = $c->_query($sql);
            return $query;
        } else {
            return false;
        }
    }

    public function upgrade_produk_jenis($id_member, $id_produk_jenis)
    {
        $sql = "UPDATE mlm_member SET id_produk_jenis = '$id_produk_jenis' WHERE id = '$id_member'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function update_jumlah_kaki($id_member, $id_plan)
    {
        $sql ="CALL GenerasiUpline($id_member)";
        $c = new classConnection();
        $generasi = $c->_query($sql);
        $total_record = $generasi->num_rows;
        if($total_record > 0){
            while($row = $generasi->fetch_object()){
                $upline = $row->upline;
                $posisi = $row->posisi;
                $sql = "UPDATE mlm_member SET jumlah_$posisi = jumlah_$posisi+1 where id ='$upline'";
                $query = $c->_query($sql);
                
                $sql = "SELECT COUNT(*) AS total 
                            FROM mlm_member_downline 
                            WHERE id_member = '$upline' 
                            AND id_plan = '$id_plan'";
                $jumlah_member = $c->_query_fetch($sql);
                if($jumlah_member->total == 0){
                    $sql = "INSERT INTO mlm_member_downline (
                                    id_member,
                                    id_plan,
                                    jumlah_$posisi,
                                    created_at
                                ) VALUES (
                                    '$upline',
                                    '$id_plan',
                                    1,
                                    '".date('Y-m-d H:i:s')."'
                                )";
                    $query = $c->_query($sql);
                } else {
                    $sql = "UPDATE mlm_member_downline SET jumlah_$posisi = jumlah_$posisi+1 
                                WHERE id_member ='$upline'
                                AND id_plan = '$id_plan'";
                    $query = $c->_query($sql);
                }
            }
        }        
        return true;
    }

    public function upgrade_jumlah_kaki($id_member, $id_plan_sebelumnya, $id_plan)
    {
        $sql ="CALL GenerasiUpline($id_member)";
        $c = new classConnection();
        $generasi = $c->_query($sql);
        $total_record = $generasi->num_rows;
        if($total_record > 0){
            while($row = $generasi->fetch_object()){
                $upline = $row->upline;
                $posisi = $row->posisi;
                
                $sql = "SELECT COUNT(*) AS total 
                            FROM mlm_member_downline 
                            WHERE id_member = '$upline' 
                            AND id_plan = '$id_plan'";
                $jumlah_member = $c->_query_fetch($sql);
                if($jumlah_member->total == 0){
                    $sql = "INSERT INTO mlm_member_downline (
                                    id_member,
                                    id_plan,
                                    jumlah_$posisi,
                                    created_at
                                ) VALUES (
                                    '$upline',
                                    '$id_plan',
                                    1,
                                    '".date('Y-m-d H:i:s')."'
                                )";
                    $query = $c->_query($sql);
                } else {
                    $sql = "UPDATE mlm_member_downline SET jumlah_$posisi = jumlah_$posisi+1 
                                WHERE id_member ='$upline'
                                AND id_plan = '$id_plan'";
                    $query = $c->_query($sql);
                }
                
                $sql = "SELECT COUNT(*) AS total 
                            FROM mlm_member_downline 
                            WHERE id_member = '$upline' 
                            AND id_plan = '$id_plan_sebelumnya'";
                $jumlah_member = $c->_query_fetch($sql);
                if($jumlah_member->total == 0){
                    $sql = "INSERT INTO mlm_member_downline (
                                    id_member,
                                    id_plan,
                                    jumlah_$posisi,
                                    created_at
                                ) VALUES (
                                    '$upline',
                                    '$id_plan_sebelumnya',
                                    0,
                                    '".date('Y-m-d H:i:s')."'
                                )";
                    $query = $c->_query($sql);
                } else {
                    $sql = "UPDATE mlm_member_downline SET jumlah_$posisi = jumlah_$posisi-1 
                                WHERE id_member ='$upline'
                                AND id_plan = '$id_plan_sebelumnya'";
                    $query = $c->_query($sql);
                }
            }
        }        
        return true;
    }
    
    public function data_sponsori($id)
    {
        $sql = "SELECT m.* from mlm_member m
                WHERE m.sponsor = '$id' and m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function sponsori($sponsor)
    {
        $sql = "SELECT COALESCE(COUNT(id), 0) AS total 
                    FROM mlm_member
                    WHERE sponsor = '$sponsor'
                    AND reposisi = '0'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function sponsori_reposisi($sponsor)
    {
        $sql = "SELECT COALESCE(COUNT(id), 0) AS total 
                    FROM mlm_member
                    WHERE sponsor = '$sponsor'
                    AND reposisi = '1'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function sponsori_all($sponsor)
    {
        $sql = "SELECT COALESCE(COUNT(id), 0) AS total 
                    FROM mlm_member
                    WHERE sponsor = '$sponsor'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function jumlah_member($id_member, $id_plan)
    {
        $sql = "SELECT COALESCE(jumlah_kiri, 0) AS jumlah_kiri, COALESCE(jumlah_kanan, 0) AS jumlah_kanan FROM mlm_member_downline m
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function jumlah_poin_reward($id_member, $id_plan)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS reward_kiri, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END),0) AS reward_kanan  
                    FROM mlm_member_poin_reward m
                    LEFT JOIN mlm_kodeaktivasi k ON m.id_kodeaktivasi = k.id
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function jumlah_poin_reward_sponsor($id_member, $id_plan)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS reward_kiri, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END),0) AS reward_kanan  
                    FROM mlm_member_poin_reward_paket m
                    LEFT JOIN mlm_kodeaktivasi k ON m.id_kodeaktivasi = k.id
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }
    

    public function jumlah_poin_reward_pribadi($id_member, $id_plan)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.status = 'd' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS poin_reward  
                    FROM mlm_member_poin_reward m
                    LEFT JOIN mlm_kodeaktivasi k ON m.id_kodeaktivasi = k.id
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function jumlah_poin_pasangan($id_member, $id_plan)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS potensi_kiri, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END),0) AS potensi_kanan 
                    FROM mlm_member_poin_pasangan m
                    LEFT JOIN mlm_kodeaktivasi k ON m.id_kodeaktivasi = k.id
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function jumlah_poin_pasangan_level($id_member, $id_plan)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS potensi_kiri, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END),0) AS potensi_kanan 
                    FROM mlm_member_poin_pasangan_level m
                    LEFT JOIN mlm_kodeaktivasi k ON m.id_kodeaktivasi = k.id
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function total_poin_pasangan($id_member, $id_plan)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS jumlah_kiri, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END),0) AS jumlah_kanan 
                    FROM mlm_member_poin_pasangan m
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function jumlah_poin_paket($id_member)
    {
        $sql = "SELECT 
                    COALESCE(SUM(m.poin), 0) AS total
                    FROM mlm_member_poin_paket m
                    WHERE m.id_member = '$id_member' 
                    AND m.status = 'd'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function jumlah_poin_ro($id_member, $jenis_aktivasi)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_kodeaktivasi_history h
                WHERE h.id_member = '$id_member' 
                AND h.jenis_aktivasi = '$jenis_aktivasi'
                AND h.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function jumlah_poin_ro_reward($id_member, $jenis_aktivasi)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_kodeaktivasi_history h
                LEFT JOIN mlm_plan pl ON h.jenis_aktivasi = pl.id
                WHERE h.id_member = '$id_member'
                AND ((pl.id = '$jenis_aktivasi' AND pl.reward = '1') OR pl.parent_reward = '$jenis_aktivasi')
                AND h.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }
    
    
    public function data_sponsor($id_member, $sponsor, $upline)
    {
        $sql = "CALL getSponsor($id_member, '$sponsor',' $upline')";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }
    

    public function create_poin_binary($dari_member, $jumlah_hu, $id_kodeaktivasi, $created_at){
        $c = new classConnection();   
        $sql ="CALL GenerasiUpline($dari_member)";
        $generasi_upline = $c->_query($sql);
        $total_record = $generasi_upline->num_rows;
        if($total_record > 0){
            while($row = $generasi_upline->fetch_object()){
                $upline = $row->upline;
                $posisi = $row->posisi;
                $sql = "INSERT INTO mlm_member_poin 
                        (id_member,
                        posisi,
                        poin,
                        id_kodeaktivasi,
                        type,
                        status,
                        created_at)
                        values
                        (
                            '$upline',
                            '$posisi',
                            '$jumlah_hu',
                            '$id_kodeaktivasi',
                            'posting',
                            'd',
                            '$created_at'
                        )";
                $c->_query($sql);
            }
        }
        return true;
    }

    public function create_poin_paket($id_member, $paket_sebelumnya, $jumlah_hu, $id_kodeaktivasi, $created_at){
        $c = new classConnection();   
        $sql = "INSERT INTO mlm_member_poin_paket 
                (id_member,
                poin,
                id_kodeaktivasi,
                type,
                status,
                created_at)
                values
                (
                    '$id_member',
                    '$jumlah_hu',
                    '$id_kodeaktivasi',
                    'posting',
                    'd',
                    '$created_at'
                )";
        $query = $c->_query($sql);
        if($query){
            $sql = "SELECT COALESCE(SUM(poin), 0) AS total
                        FROM mlm_member_poin_paket
                        WHERE id_member = '$id_member' 
                        AND status = 'd'
                        AND deleted_at IS NULL";
            $poin = $c->_query_fetch($sql);
            $total = $poin->total;
            $sql = "SELECT id
                        FROM mlm_paket
                        WHERE poin = '$total'
                        AND deleted_at IS NULL
                        ORDER BY id DESC
                        LIMIT 1";
            $paket = $c->_query_fetch($sql);
            if($paket){
                $paket_upgrade = $paket->id;
                if($paket_upgrade > $paket_sebelumnya){
                    $sql = "INSERT INTO mlm_member_paket 
                            (id_member,
                            paket_sebelumnya,
                            paket,
                            manual_upgrade,
                            id_kodeaktivasi,
                            type,
                            created_at)
                            values
                            (
                                '$id_member',
                                '$paket_sebelumnya',
                                '$paket_upgrade',
                                '0',
                                '$id_kodeaktivasi',
                                'posting',
                                '$created_at'
                            )";
                    $create = $c->_query($sql);
                    if($create){
                        $sql = "UPDATE mlm_member SET id_paket = '$paket_upgrade'
                                    WHERE id = '$id_member'";
                        $upgrade = $c->_query($sql);
                    }
                }
            }
        }
        return $query;
    }

    public function cek_upline($upline, $sponsor)
    {
        $sql = "WITH recursive mlm_member_downline as
                    (
                        SELECT id, id_member, nama_samaran, nama_member, upline, level, deleted_at FROM mlm_member WHERE id = '$upline' 
                        UNION
                        SELECT m.id, m.id_member, m.nama_samaran, m.nama_member, m.upline, m.level, m.deleted_at
                        FROM mlm_member_downline r 
                        JOIN mlm_member m 
                        ON r.upline = m.id
                    )
                SELECT TO_BASE64(id) as id, id_member, nama_samaran, nama_member, upline, level FROM mlm_member_downline WHERE id = '$sponsor' AND deleted_at IS NULL";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function get_root($group_akun)
    {
        $sql = "SELECT id FROM mlm_member WHERE group_akun = '$group_akun' AND group_akun IS NOT NULL AND group_akun <> '' ORDER BY id ASC LIMIT 1";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->id;
    }
    
    public function sum_tanggal_lahir($tanggal_lahir){
        $arr_date = str_split($tanggal_lahir, 1);
        $hasil = array_sum($arr_date);
        if($hasil > 9){
            return $this->sum_tanggal_lahir($hasil);
        } else {
            return $hasil;
        }
    }
    
    public function maks_flush_in($id_plan){
        $sql = "SELECT max_pasangan FROM mlm_bonus_pasangan_setting 
                WHERE id_plan = '$id_plan'";
        // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->max_pasangan;
        }
        return 0;
    }
    
    public function cek_peringkat($id_member, $id_kodeaktivasi, $created_at){
        $peringkat = 1;
        $create = $this->update_peringkat($id_member, $id_kodeaktivasi, '0', $peringkat, $created_at);
        if($create > 0){
            $sql ="CALL GenerasiSponsor($id_member)";
            $c = new classConnection();
            $generasi_sponsor = $c->_query($sql);
            $total_record = $generasi_sponsor->num_rows;                
            if($total_record > 0){
                while($row = $generasi_sponsor->fetch_object()){
                    $sponsor = $row->sponsor;                
                    $peringkat_sebelumnya = $this->show($sponsor)->id_peringkat;
                    if($peringkat_sebelumnya > 0){
                        $peringkat_baru = $peringkat+1;
                        if($peringkat_baru > $peringkat_sebelumnya){
                            $sql = "SELECT * 
                                    FROM mlm_peringkat 
                                    WHERE id = '$peringkat_baru'";
                            $master_peringkat = $c->_query_fetch($sql);
                            if($master_peringkat){
                                $sponsori_peringkat = $master_peringkat->sponsori;
                                $total_sponsori_peringkat = $master_peringkat->poin;
                                $sql = "SELECT COUNT(DISTINCT group_akun) AS total 
                                        FROM mlm_member 
                                        WHERE id_peringkat = '$sponsori_peringkat'
                                        AND sponsor = '$sponsor'
                                        AND deleted_at IS NULL";
                                        $c->_query($sql);
                                $total_sponsori = $c->_query_fetch($sql)->total;
                                if($total_sponsori >= $total_sponsori_peringkat){
                                    $this->update_peringkat($sponsor, $id_kodeaktivasi, $peringkat_sebelumnya, $peringkat_baru, $created_at);   
                                    $peringkat++;
                                } else {
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
        return 0;
    }
    
    public function update_peringkat($id_member, $id_kodeaktivasi, $peringkat_sebelumnya, $peringkat, $created_at){
        $sql = "INSERT INTO mlm_member_peringkat
                (
                    id_member,
                    peringkat_sebelumnya,
                    peringkat,
                    manual_upgrade,
                    id_kodeaktivasi,
                    type,
                    created_at
                ) VALUES (
                    '$id_member',
                    '$peringkat_sebelumnya',
                    '$peringkat',
                    '0',
                    '$id_kodeaktivasi',
                    'klaim_reward',
                    '$created_at'
                )";
        $c = new classConnection();
        $query = $c->_query_insert($sql);
        if($query > 0){
            $sql = "UPDATE mlm_member SET id_peringkat = '$peringkat'
                        WHERE id = '$id_member'";
            $query = $c->_query($sql);
            return $query;
        }
        return 0;
    }

    public function peringkat($id_member){
        $sql = "SELECT p.nama_peringkat
                    FROM mlm_member m 
                    LEFT JOIN mlm_peringkat p
                    ON m.id_peringkat = p.id
                    WHERE m.id = '$id_member'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query && $query->nama_peringkat <> NULL){
            return $query->nama_peringkat;
        } else {
            return '-';
        }
    }

    public function create_member_plan($id_member, $id_plan_sebelumnya, $id_plan, $created_at){
        $sql = "INSERT INTO mlm_member_plan 
                    (id_member,
                    id_plan_sebelumnya,
                    id_plan,
                    manual_upgrade,
                    id_kodeaktivasi,
                    type,
                    created_at)
                    values
                    (
                        '$id_member',
                        '$id_plan_sebelumnya',
                        '$id_plan',
                        '1',
                        '0',
                        'by admin',
                        '$created_at'
                    )";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function cek_username($user_member, $current_user_member){

		$sql = "SELECT COUNT(*) AS total from mlm_member where user_member = '$user_member' 
                AND user_member <> '$current_user_member'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        if($query->total == 0) {
            return true;
        }
        return false;
	}

    public function generasi_upline($id_member){

		$sql = "CALL GenerasiUpline('$id_member')";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
	}

    public function info_ro($member_id, $jenis_aktivasi){
        $bulan = date('Y-m');
		$sql = "SELECT COUNT(*) AS total, MAX(created_at) AS created_at 
		            FROM mlm_kodeaktivasi_history 
		            WHERE id_member = '$member_id' 
		            AND jenis_aktivasi = '$jenis_aktivasi'
		            AND LEFT(created_at, 7) = '$bulan'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
	}

    public function cek_sponsori_netreborn($id_member)
    {
        $sql = "SELECT COUNT(*) AS total
                    FROM mlm_member m
                    JOIN mlm_member s ON m.sponsor = s.id
                    WHERE m.id_plan IN (16, 17)
                    AND s.id_plan IN  (16, 17)
                    AND m.sponsor = '$id_member'
                    AND m.deleted_at IS NULL
                    AND m.reposisi = '0'
                    AND s.reposisi = '0'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query->total >= 2) {
            return true;
        } else {
            return false;
        }
    }
}
