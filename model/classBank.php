<?php
    require_once 'classConnection.php';
    class classBank{
        private $id;
        private $logo;
        private $nama_bank;
        private $kode_bank;
        private $created_at;
        private $updated_at;
        private $deleted_at;

        public function get_id(){
            return $this->id;
        }
    
        public function set_id($id){
            $this->id = $id;
        }
        
        public function get_logo(){
            return $this->logo;
        }
    
        public function set_logo($logo){
            $this->logo = $logo;
        }
        
        public function get_nama_bank(){
            return $this->nama_bank;
        }
    
        public function set_nama_bank($nama_bank){
            $this->nama_bank = $nama_bank;
        }
        
        public function get_kode_bank(){
            return $this->kode_bank;
        }
    
        public function set_kode_bank($kode_bank){
            $this->kode_bank = $kode_bank;
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

        public function datatable($request){
            $sort_column =array(
                'id',
                'logo',
                'nama_bank',
                'kode_bank',
                'id',
                );
    
            $data_search =array(
                    'kode_bank',
                    'nama_bank'
                );
    
                $sql  = "SELECT * FROM mlm_bank WHERE 1";
    
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
            $no = $request['start'];
            while($row = $query->fetch_object()){
                if ($row->deleted_at == NULL){
                    $aksi = '<button class="btn btn-danger btn-xs" onclick="hapus('."'".base64_encode($row->id)."'".')"> Sembunyikan</button>';
                } else {
                    $aksi = '<button class="btn btn-primary btn-xs" onclick="restore('."'".base64_encode($row->id)."'".')"> Tampilkan</button>';
                }
                $no++;
                $subdata=array();
                $subdata[] = $no;
                $subdata[] = '<img src="../images/bank/'.$row->logo.'" height="30">';
                $subdata[] = $row->nama_bank;
                $subdata[] = $row->kode_bank;
                $subdata[] = '<a href="index.php?go=bank_edit&id='.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> '.$aksi;
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
            $sql 	= "INSERT INTO mlm_bank(
                            logo,
                            nama_bank,
                            kode_bank,
                            created_at
                        ) 
                        values (
                            '".$this->get_logo()."', 
                            '".$this->get_nama_bank()."', 
                            '".$this->get_kode_bank()."', 
                            '".$this->get_created_at()."'
                            )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_bank set 
                        logo = '".$this->get_logo()."', 
                        nama_bank = '".$this->get_nama_bank()."', 
                        kode_bank = '".$this->get_kode_bank()."', 
                        updated_at = '".$this->get_updated_at()."'
                    where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function delete($id){
            $sql  = "UPDATE mlm_bank set 
                        deleted_at = '".$this->get_deleted_at()."'
                    where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function restore($id){
            $sql  = "UPDATE mlm_bank set 
                        deleted_at = NULL
                    where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT * FROM mlm_bank 
                        WHERE deleted_at IS NULL 
                        ORDER BY nama_bank ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_bank WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function semua_bank(){
            $sql  = "SELECT * FROM mlm_bank WHERE nama_bank != '' AND deleted_at IS NULL ORDER BY nama_bank ASC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            if($query){
                return $query;
            }
            return false;
        }
        public function show_nama_bank($id){
            $sql  = "SELECT nama_bank FROM mlm_bank WHERE id = '$id' AND deleted_at IS NULL LIMIT 1";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            if($query){
                return $query->nama_bank;
            }
            return '';
        }

    }
?>