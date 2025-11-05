<?php
    require_once 'classConnection.php';
    class classStokisTransfer{
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
    

        public function datatable($id_stokis, $request){
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
                            d.*, 
                            s.id_stokis,
                            s.nama_stokis,
                            s.no_handphone,
                            d.nominal,
                            d.status
                        FROM mlm_stokis_transfer d
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
                $subdata[] = currency($row->nominal);
                $subdata[] = $status;
                // $subdata[] = $row->status == 0 ? '<a href="?go=stokis_transfer_invoice&id_transfer='.$row->id.'" id="btnInvoice" class="btn btn-success btn-xs" target="_blank">Invoice</a>' : $row->updated_at;
                $subdata[] = '<a href="?go=stokis_transfer_invoice&id_transfer='.$row->id.'" id="btnInvoice" class="btn btn-success btn-xs" target="_blank">Invoice</a>';
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

        public function datatable_terima($id_stokis, $request){
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
                            d.*, 
                            s.id_stokis,
                            s.nama_stokis,
                            s.no_handphone,
                            d.nominal,
                            d.status
                        FROM mlm_stokis_transfer d
                        LEFT JOIN mlm_stokis_member s ON d.id_stokis_tujuan = s.id
                        WHERE d.deleted_at IS NULL
                        AND d.id_stokis_tujuan = '$id_stokis'";

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
                $subdata[] = currency($row->nominal);
                $subdata[] = $status;
                $subdata[] = '<a href="?go=stokis_terima_invoice&id_transfer='.$row->id.'" id="btnInvoice" class="btn btn-success btn-xs" target="_blank">Invoice</a>';
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
            $sql 	= "INSERT INTO mlm_stokis_transfer(
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
        public function update_status($id, $id_stokis){
            $sql  = "UPDATE mlm_stokis_transfer SET
                        status = '".$this->get_status()."', 
                        updated_at = '".$this->get_updated_at()."' 
                        WHERE id = '$id' 
                        AND id_stokis = '$id_stokis' 
                        AND status = '0'";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function index($id_stokis){
            $sql  = "SELECT * 
                        FROM mlm_stokis_transfer 
                        WHERE deleted_at IS NULL 
                        AND id_stokis = '$id_stokis'
                        ORDER BY id DESC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id, $id_stokis){
            $sql  = "SELECT * FROM mlm_stokis_transfer 
                        WHERE id = '$id'
                        AND id_stokis = '$id_stokis'
                        ";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function show_terima($id, $id_stokis){
            $sql  = "SELECT * FROM mlm_stokis_transfer 
                        WHERE id = '$id'
                        AND id_stokis_tujuan = '$id_stokis'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }
    }
?>