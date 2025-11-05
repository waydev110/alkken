<?php
    require_once 'classConnection.php';
    class classStokisOrder{
        private $id;
        private $id_stokis;
        private $nominal;
        private $status;
        private $status_bayar;
        private $id_admin;
        private $keterangan;        
        private $tgl_bayar;    
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
        
        public function get_status_bayar(){
            return $this->status_bayar;
        }
    
        public function set_status_bayar($status_bayar){
            $this->status_bayar = $status_bayar;
        }
        
        public function get_tgl_bayar(){
            return $this->tgl_bayar;
        }
    
        public function set_tgl_bayar($tgl_bayar){
            $this->tgl_bayar = $tgl_bayar;
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
    
        public function datatable($request, $status_bayar, $status, $status_kirim){
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
                            d.status_bayar
                        FROM mlm_stokis_deposit d
                        LEFT JOIN mlm_stokis_member s ON d.id_stokis = s.id
                        LEFT JOIN mlm_stokis_member t ON d.id_stokis_tujuan = t.id
                        WHERE d.deleted_at IS NULL
                        AND d.id_stokis_tujuan > 0
                        AND d.status_bayar = '$status_bayar'
                        AND d.status = '$status'
                        AND d.status_kirim = '$status_kirim'";

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
                switch ($row->status_bayar) {
                    case '0':
                        $status_text = '<span class="label label-default rounded-pill">Pending</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-success" onclick="approve_bayar('."'".$row->id."'".')"><i class="fa fa-check"></i> Approve Bayar</button>
                        <button type="button" class="btn btn-xs btn-danger" onclick="reject('."'".$row->id."'".')"><i class="fa fa-times"></i> Tolak</button>';
                        break;
                    case '1':
                        $status_text = '<span class="label label-success rounded-pill">Dibayar</span>';
                        if($row->status == '1'){
                            $aksi = '<button type="button" class="btn btn-xs btn-success" onclick="approve('."'".$row->id."'".')"><i class="fa fa-check"></i> Kirim</button>'; 
                        
                        } else {
                            $aksi = 'Menunggu';
                        }
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
                $subdata[] = $row->status == 0 ? '<a href="?go=stokis_order_invoice&id_deposit='.$row->id.'" id="btnInvoice" class="btn btn-success btn-xs" target="_blank">Invoice</a>' : $row->updated_at;
                $subdata[] = '<button type="button" class="btn btn-xs btn-default" onclick="detail_produk('."'".$row->id."'".')">Detail Produk</button>';
                $subdata[] = $aksi;
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
                $subdata[] = $row->status == 0 ? '<a href="?go=stokis_order_invoice&id_deposit='.$row->id.'" id="btnInvoice" class="btn btn-success btn-xs" target="_blank">Invoice</a>' : $row->updated_at;
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
                's.nama_stokis',
                'd.created_at',
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
                            d.id,
                            d.id_stokis as stokis_id, 
                            s.id_stokis,
                            s.nama_stokis,
                            s.no_handphone,
                            d.id_stokis_tujuan as stokis_tujuan_id, 
                            st.id_stokis as id_stokis_tujuan,
                            st.nama_stokis as nama_stokis_tujuan,
                            st.no_handphone as no_handphone_tujuan,
                            d.subtotal,
                            d.diskon,
                            d.nominal,
                            d.status,
                            d.created_at,
                            d.updated_at
                        FROM mlm_stokis_deposit d
                        LEFT JOIN mlm_stokis_deposit_detail x ON x.id_deposit = d.id
                        LEFT JOIN mlm_stokis_member s ON d.id_stokis = s.id
                        LEFT JOIN mlm_stokis_member st ON d.id_stokis_tujuan = st.id
                        WHERE d.deleted_at IS NULL
                        AND d.id_stokis_tujuan > 0
                        AND d.status = '1'";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;

            if(!empty($request['bulan'])){
                $sql.=" AND LEFT(d.updated_at, 7) = '".$request['bulan']."' ";
            }
            if(is_numeric($request['id_stokis'])){
                $sql.=" AND d.id_stokis = '".$request['id_stokis']."' ";
            }
            if(is_numeric($request['id_stokis_tujuan'])){
                $sql.=" AND d.id_stokis_tujuan = '".$request['id_stokis_tujuan']."' ";
            }
            if(is_numeric($request['id_produk'])){
                $sql.=" AND x.id_produk = '".$request['id_produk']."' ";
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
                $subdata[] = $row->id;
                $subdata[] = $row->created_at;
                $subdata[] = $row->nama_stokis.' ('.$row->id_stokis.')';
                $subdata[] = $row->nama_stokis_tujuan.' ('.$row->id_stokis_tujuan.')';
                $subdata[] = currency($row->subtotal);
                $subdata[] = currency($row->diskon);
                $subdata[] = currency($row->nominal);
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
        
        public function create()
        {
            $sql 	= "INSERT INTO mlm_stokis_deposit(
                            id_stokis,
                            nominal,
                            status,
                            id_admin,
                            keterangan,
                            created_at
                        ) 
                        values (
                            '".$this->get_id_stokis()."', 
                            '".$this->get_nominal()."', 
                            '".$this->get_status()."', 
                            '".$this->get_id_admin()."', 
                            '".$this->get_keterangan()."',  
                            '".$this->get_created_at()."'
                        )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_stokis_deposit set 
                        status = '".$this->get_nominal()."',
                        id_admin = '".$this->get_id_admin()."', 
                        updated_at = '".$this->get_updated_at()."'
                        where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
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
                        status_bayar = '".$this->get_status_bayar()."', 
                        tgl_bayar = '".$this->get_tgl_bayar()."'
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

        public function pending_order($id){
            $sql  = "SELECT * FROM mlm_stokis_deposit 
                        WHERE id = '$id'
                        AND status_bayar = '0'
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