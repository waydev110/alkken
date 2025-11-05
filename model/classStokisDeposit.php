<?php
    require_once 'classConnection.php';
    class classStokisDeposit{
        private $id;
        private $id_stokis;
        private $subtotal;
        private $diskon;
        private $nominal;
        private $status;
        private $id_stokis_tujuan;
        private $id_admin;
        private $keterangan;        
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
        
        public function get_subtotal(){
            return $this->subtotal;
        }
    
        public function set_subtotal($subtotal){
            $this->subtotal = $subtotal;
        }
        
        public function get_diskon(){
            return $this->diskon;
        }
    
        public function set_diskon($diskon){
            $this->diskon = $diskon;
        }
        
        public function get_nominal(){
            return $this->nominal;
        }
    
        public function set_nominal($nominal){
            $this->nominal = $nominal;
        }
        
        public function get_status(){
            return $this->status;
        }
    
        public function set_status($status){
            $this->status = $status;
        }
        
        public function get_id_stokis_tujuan(){
            return $this->id_stokis_tujuan;
        }
    
        public function set_id_stokis_tujuan($id_stokis_tujuan){
            $this->id_stokis_tujuan = $id_stokis_tujuan;
        }
        
        public function get_id_admin(){
            return $this->id_admin;
        }
    
        public function set_id_admin($id_admin){
            $this->id_admin = $id_admin;
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
    

        public function datatable($request, $status){
            $sort_column =array(
                'd.id',
                'd.created_at',
                's.nama_stokis',
                'd.nominal',
                'd.status',
                'd.updated_at',
                'd.id'
                );

            $data_search =array(
                's.id_stokis',
                's.nama_stokis'
                );

                $sql  = "SELECT 
                            d.*, 
                            s.id_stokis,
                            s.nama_stokis,
                            s.no_handphone,
                            d.nominal,
                            d.status
                        FROM mlm_stokis_deposit d
                        LEFT JOIN mlm_stokis_member s ON d.id_stokis = s.id
                        WHERE d.deleted_at IS NULL
                        AND d.id_stokis_tujuan = '0'
                        AND d.status = '$status'";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;
            
            if(!empty($request['search']['value'])){
                $sql.=" AND (";
                foreach ($data_search as $key => $value) {
                    if($key > 0){
                        $sql.=" OR ";
                    }
                    $sql.="$value LIKE '%".$request['search']['value']."%'";
                }
                $sql.=")";
            }
            $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
            $query 	= $c->_query($sql);
            $totalFilter = $query->num_rows;

            $data=array();
            while($row = $query->fetch_object()){
                switch ($row->status) {
                    case '0':
                        $status_text = '<span class="label label-default rounded-pill">Pending</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-success" onclick="approve('."'".$row->id."'".')"><i class="fa fa-check"></i> Setujui</button>
                        <button type="button" class="btn btn-xs btn-danger" onclick="reject('."'".$row->id."'".')"><i class="fa fa-times"></i> Tolak</button>';
                        break;
                    case '1':
                        $status_text = '<span class="label label-success rounded-pill">Selesai</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    case '2':
                        $status_text = '<span class="label label-danger rounded-pill">Ditolak</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="delete('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    case '3':
                        $status_text = '<span class="label label-default rounded-pill">Dibatalkan</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    
                    default:
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                }
                switch ($row->status_bayar) {
                    case '0':
                        if($row->status > 1){
                            $aksi_bayar = '';
                        } else {
                            $aksi_bayar = '<button type="button" class="btn btn-xs btn-success" onclick="approve_bayar('."'".$row->id."'".')"><i class="fa fa-check"></i> Sudah Bayar</button>';
                        }
                        break;
                    case '1':
                        $aksi_bayar = $row->tgl_bayar;
                        break;
                    default:
                        $aksi_bayar = '';
                        break;
                }
                $subdata=array();
                $subdata[] = code_order($row->id, $row->created_at);
                $subdata[] = $row->created_at;
                $subdata[] = $row->nama_stokis.' ('.$row->id_stokis.')';
                $subdata[] = currency($row->nominal);
                $subdata[] = $aksi_bayar;
                $subdata[] = $status_text;
                $subdata[] = $row->status == 0 ? '<a href="?go=stokis_deposit_invoice&id_deposit='.$row->id.'" id="btnInvoice" class="btn btn-success btn-xs" target="_blank">Invoice</a>' : $row->updated_at;
                $subdata[] = '<button type="button" class="btn btn-xs btn-default" onclick="detail_produk('."'".$row->id."'".')">Detail Produk</button>';
                if($status == 0){
                    $subdata[] = $aksi;
                }
                $data[]    =$subdata;
            }
        
            $json_data = array(
                "draw"              =>  intval($request['draw']),
                "recordsTotal"      =>  intval($totalData),
                "recordsFiltered"   =>  intval($totalFilter),
                "data"              =>  $data
            );
            return $json_data;
        }


        public function datatable_kirim_produk($request, $status){
            $sort_column =array(
                'd.id',
                'd.created_at',
                's.nama_stokis',
                's.nama_stokis_tujuan',
                'd.nominal',
                'd.status_bayar',
                'd.status',
                'd.updated_at',
                'd.id'
                );

            $data_search =array(
                's.id_stokis',
                's.nama_stokis'
                );

                $sql  = "SELECT 
                            d.*, 
                            s.id_stokis,
                            s.nama_stokis,
                            s.no_handphone,
                            t.id_stokis as id_stokis_tujuan,
                            t.nama_stokis as nama_stokis_tujuan,
                            t.no_handphone as no_handphone_stokis_tujuan,
                            d.nominal,
                            d.status,
                            d.status_bayar,
                            d.status_kirim
                        FROM mlm_stokis_deposit d
                        LEFT JOIN mlm_stokis_member s ON d.id_stokis = s.id
                        LEFT JOIN mlm_stokis_member t ON d.id_stokis_tujuan = t.id
                        WHERE d.deleted_at IS NULL
                        AND d.id_stokis_tujuan > 0
                        AND d.status_bayar = 1
                        AND d.status = 1
                        AND d.status_kirim = '$status'";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;
            
            if(!empty($request['search']['value'])){
                $sql.=" AND (";
                foreach ($data_search as $key => $value) {
                    if($key > 0){
                        $sql.=" OR ";
                    }
                    $sql.="$value LIKE '%".$request['search']['value']."%'";
                }
                $sql.=")";
            }
            $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
            $query 	= $c->_query($sql);
            $totalFilter = $query->num_rows;

            $data=array();
            $no = $request['start'];
            while($row = $query->fetch_object()){
                switch ($row->status_kirim) {
                    case '0':
                        $status_text = '<span class="label label-default rounded-pill">Pending</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-success" onclick="kirim_produk('."'".$row->id."'".')"><i class="fa fa-check"></i> Kirim Produk</button>';
                        break;
                    case '1':
                        $status_text = '<span class="label label-success rounded-pill">Dikirim</span>';
                        $aksi = $row->tgl_kirim;
                        break;
                    case '2':
                        $status_text = '<span class="label label-danger rounded-pill">Ditolak</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="delete('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    
                    default:
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                }
                $no++;
                $subdata=array();
                $subdata[] = $no;
                $subdata[] = $row->created_at;
                $subdata[] = $row->nama_stokis.' ('.$row->id_stokis.')';
                $subdata[] = $row->nama_stokis_tujuan.' ('.$row->id_stokis_tujuan.')';
                $subdata[] = currency($row->nominal);
                $subdata[] = $status_text;
                $subdata[] = $row->status == 0 ? '<a href="?go=stokis_deposit_invoice&id_deposit='.$row->id.'" id="btnInvoice" class="btn btn-success btn-xs" target="_blank">Invoice</a>' : $row->updated_at;
                $subdata[] = '<button type="button" class="btn btn-xs btn-default" onclick="detail_produk('."'".$row->id."'".')">Detail Produk</button>';
                if($status == 0){
                    $subdata[] = $aksi;
                }
                $data[]    =$subdata;
            }
        
            $json_data = array(
                "draw"              =>  intval($request['draw']),
                "recordsTotal"      =>  intval($totalData),
                "recordsFiltered"   =>  intval($totalFilter),
                "data"              =>  $data
            );
            return $json_data;
        }

        public function datatable_riwayat($request){
            $sort_column =array(
                'd.id',
                'd.created_at',
                's.id_stokis',
                's.nama_stokis',
                'd.nominal',
                'd.status',
                'd.id',
                'd.id'
                );

            $data_search =array(
                'd.id',
                's.id_stokis',
                's.nama_stokis'
                );

                $sql  = "SELECT 
                            d.id,
                            d.id_stokis as stokis_id, 
                            s.id_stokis,
                            s.nama_stokis,
                            s.no_handphone,
                            d.subtotal,
                            d.diskon,
                            d.nominal,
                            d.status,
                            d.id_stokis_tujuan,
                            d.created_at,
                            d.updated_at
                        FROM mlm_stokis_deposit d
                        JOIN mlm_stokis_deposit_detail x ON x.id_deposit = d.id
                        jOIN mlm_produk p ON x.id_produk = p.id
                        JOIN mlm_stokis_member s ON d.id_stokis = s.id
                        WHERE d.deleted_at IS NULL
                        AND d.id_stokis_tujuan = '0'
                        AND d.status = '1'";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;

            if(!empty($request['bulan'])){
                $sql.=" AND LEFT(d.updated_at, 7) = '".$request['bulan']."' ";
            }
            if(!empty($request['start_date'])){
                $sql.=" AND LEFT(d.updated_at, 10) >= '".$request['start_date']."' ";
            }
            if(!empty($request['end_date'])){
                $sql.=" AND LEFT(d.updated_at, 10) <= '".$request['end_date']."' ";
            }
            if(is_numeric($request['id_stokis'])){
                $sql.=" AND d.id_stokis = '".$request['id_stokis']."' ";
            }
            if(is_numeric($request['id_produk'])){
                $sql.=" AND x.id_produk = '".$request['id_produk']."' ";
            }
            if(is_numeric($request['jenis_produk'])){
                $sql.=" AND p.id_produk_jenis = '".$request['jenis_produk']."' ";
            }
            
            if(!empty($request['keyword'])){
                $array_search = array();
                foreach ($data_search as $key => $value) {
                    $array_search[] ="$value LIKE '%".$request['keyword']."%'";
                }
                $sql_search = implode(' OR ', $array_search);
                $sql.=" AND (".$sql_search.")";
            }
            
            $sql .=" GROUP BY d.id ";
            $query 	= $c->_query($sql);
            $totalFilter = $query->num_rows;
            

            $sql1 = "SELECT COALESCE(SUM(subtotal), 0) AS subtotal, COALESCE(SUM(diskon), 0) AS diskon, COALESCE(SUM(nominal), 0) AS nominal FROM ($sql) AS q";
            $sum = $c->_query_fetch($sql1);
            $subtotal 	= $sum->subtotal;
            $diskon 	= $sum->diskon;
            $nominal 	= $sum->nominal;

            $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
            if($request['length'] > 0){
                $sql.="  LIMIT ". $request['start'].",".$request['length']."  ";
            }
            // echo $sql;
            $query 	= $c->_query($sql);
            $data=array();
            $no = $request['start'];

            $data=array();
            while($row = $query->fetch_object()){
                switch ($row->status) {
                    case '0':
                        $status_text = '<span class="label label-default rounded-pill">Pending</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-success" onclick="approve('."'".$row->id."'".')"><i class="fa fa-check"></i> Setujui</button>
                        <button type="button" class="btn btn-xs btn-danger" onclick="reject('."'".$row->id."'".')"><i class="fa fa-times"></i> Tolak</button>';
                        break;
                    case '1':
                        $status_text = '<span class="label label-success rounded-pill">Selesai</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    case '2':
                        $status_text = '<span class="label label-danger rounded-pill">Ditolak</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="delete('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    case '3':
                        $status_text = '<span class="label label-default rounded-pill">Dibatalkan</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    
                    default:
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                }
                $subdata=array();
                $subdata[] = code_order($row->id, $row->created_at);
                $subdata[] = $row->created_at;
                $subdata[] = $row->id_stokis;
                $subdata[] = $row->nama_stokis;
                $subdata[] = currency($row->subtotal);
                // $subdata[] = currency($row->diskon);
                // $subdata[] = currency($row->nominal);
                $subdata[] = $status_text;
                $subdata[] = $row->updated_at;
                $subdata[] = '<button type="button" class="btn btn-xs btn-default" onclick="detail_produk('."'".$row->id."'".')">Detail Produk</button>';
                $subdata[] = $aksi;
                $data[]    =$subdata;
            }
        
            $json_data = array(
                "draw"              =>  intval($request['draw']),
                "recordsTotal"      =>  intval($totalData),
                "recordsFiltered"   =>  intval($totalFilter),
                "subtotal"           =>  rp($subtotal),
                "diskon"            =>  rp($diskon),
                "nominal"           =>  rp($nominal),
                "data"              =>  $data
            );
            return $json_data;
        }
        

        public function datatable_riwayat_stokis($id_stokis, $request){
            $sort_column =array(
                'd.id',
                's.nama_stokis',
                'd.created_at',
                'd.subtotal',
                'd.diskon',
                'd.nominal',
                'd.status',
                'd.id',
                'd.id'
                );

            $data_search =array(
                's.id_stokis',
                's.nama_stokis'
                );

                $sql  = "SELECT 
                            d.*, 
                            s.id_stokis,
                            s.nama_stokis,
                            s.no_handphone,
                            d.subtotal,
                            d.diskon,
                            d.nominal,
                            d.status
                        FROM mlm_stokis_deposit d
                        LEFT JOIN mlm_stokis_member s ON d.id_stokis_tujuan = s.id
                        WHERE d.deleted_at IS NULL
                        AND d.id_stokis = '$id_stokis'";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;
            
            if(!empty($request['search']['value'])){
                $sql.=" AND (";
                foreach ($data_search as $key => $value) {
                    if($key > 0){
                        $sql.=" OR ";
                    }
                    $sql.="$value LIKE '%".$request['search']['value']."%'";
                }
                $sql.=")";
            }
            $query 	= $c->_query($sql);
            $totalFilter = $query->num_rows;
            $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
            $query 	= $c->_query($sql);

            $data=array();
            while($row = $query->fetch_object()){
                switch ($row->status) {
                    case '0':
                        $status = '<span class="label label-default rounded-pill">Pending</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-danger" onclick="reject('."'".$row->id."'".')"><i class="fa fa-times"></i> Batalkan</button>';
                        break;
                    case '1':
                        $status = '<span class="label label-success rounded-pill">Selesai</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    case '2':
                        $status = '<span class="label label-danger rounded-pill">Ditolak</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    case '3':
                        $status = '<span class="label label-default rounded-pill">Dibatalkan</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    
                    default:
                    $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                }
                $subdata=array();
                $subdata[] = code_order($row->id, $row->created_at);
                $subdata[] = $row->created_at;
                $subdata[] = $row->id_stokis_tujuan == '0' ? 'Perusahaan' : $row->nama_stokis.' ('.$row->id_stokis.')';
                $subdata[] = currency($row->subtotal);
                $subdata[] = currency($row->diskon);
                $subdata[] = currency($row->nominal);
                $subdata[] = $status;
                $subdata[] = $row->status == 0 ? '<a href="?go=stokis_deposit_invoice&id_deposit='.$row->id.'" id="btnInvoice" class="btn btn-success btn-xs" target="_blank">Invoice</a>' : $row->updated_at;
                $subdata[] = '<button type="button" class="btn btn-xs btn-default" onclick="detail_produk('."'".$row->id."'".')">Detail Produk</button>';
                // $subdata[] = $aksi;
                $data[]    =$subdata;
            }
        
            $json_data = array(
                "draw"              =>  intval($request['draw']),
                "recordsTotal"      =>  intval($totalData),
                "recordsFiltered"   =>  intval($totalFilter),
                "data"              =>  $data
            );
            return $json_data;
        }
        public function create()
        {
            $sql 	= "INSERT INTO mlm_stokis_deposit(
                            id_stokis,
                            subtotal,
                            diskon,
                            nominal,
                            status,
                            id_stokis_tujuan,
                            keterangan,
                            created_at
                        ) 
                        values (
                            '".$this->get_id_stokis()."', 
                            '".$this->get_subtotal()."', 
                            '".$this->get_diskon()."', 
                            '".$this->get_nominal()."', 
                            '".$this->get_status()."', 
                            '".$this->get_id_stokis_tujuan()."', 
                            '".$this->get_keterangan()."',  
                            '".$this->get_created_at()."'
                        )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update_status($id){
            $sql  = "UPDATE mlm_stokis_deposit SET
                        id_admin = '".$this->get_id_admin()."', 
                        status = '".$this->get_status()."', 
                        updated_at = '".$this->get_updated_at()."' 
                        WHERE id = '$id'";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        public function update_status_bayar($id){
            $sql  = "UPDATE mlm_stokis_deposit SET
                        id_admin = '".$this->get_id_admin()."', 
                        status_bayar = '".$this->get_status()."', 
                        tgl_bayar = '".$this->get_updated_at()."'
                        WHERE id = '$id'";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        public function update_status_kirim($id){
            $sql  = "UPDATE mlm_stokis_deposit SET
                        id_admin = '".$this->get_id_admin()."', 
                        status_kirim = '".$this->get_status()."', 
                        tgl_kirim = '".$this->get_updated_at()."'
                        WHERE id = '$id'";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT * FROM mlm_stokis_deposit WHERE deleted_at IS NULL ORDER BY id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_stokis_deposit WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function pending($id){
            $sql  = "SELECT * FROM mlm_stokis_deposit 
                        WHERE id = '$id'
                        AND status = '0'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function pending_bayar($id){
            $sql  = "SELECT * FROM mlm_stokis_deposit 
                        WHERE id = '$id'
                        AND status_bayar = '0'
                        AND id_stokis_tujuan > 0";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function pending_kirim($id){
            $sql  = "SELECT * FROM mlm_stokis_deposit 
                        WHERE id = '$id'
                        AND status_kirim = '0'
                        AND id_stokis_tujuan > 0";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function delete($id){
            $sql  = "DELETE FROM mlm_stokis_deposit WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>