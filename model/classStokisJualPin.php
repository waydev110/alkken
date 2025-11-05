<?php
    require_once 'classConnection.php';

    class classStokisJualPin{
        private $id;
        private $id_member;
        private $id_plan;
        private $harga;
        private $qty;
        private $nominal;
        private $status;
        private $id_stokis;
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

        public function get_harga(){
            return $this->harga;
        }
    
        public function set_harga($harga){
            $this->harga = $harga;
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
        
        public function get_status(){
            return $this->status;
        }
    
        public function set_status($status){
            $this->status = $status;
        }
        
        public function get_id_stokis(){
            return $this->id_stokis;
        }
    
        public function set_id_stokis($id_stokis){
            $this->id_stokis = $id_stokis;
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
    

        public function datatable($request, $id_stokis){
            $sort_column =array(
                'd.id',
                'd.created_at',
                's.nama_samaran',
                'pl.nama_plan',
                'd.harga',
                'd.qty',
                'd.nominal',
                'd.id'
                );

            $data_search =array(
                's.id_member',
                's.nama_samaran'
                );

                $sql  = "SELECT 
                            d.id,
                            d.created_at,
                            s.id_member,
                            s.nama_samaran,
                            d.harga,
                            d.qty,
                            d.nominal,
                            d.status,
                            pl.nama_plan
                        FROM mlm_stokis_jual_pin d
                        LEFT JOIN mlm_plan pl ON d.id_plan = pl.id
                        LEFT JOIN mlm_member s ON d.id_member = s.id
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
            $no = $request['start'];
            while($row = $query->fetch_object()){
                $no++;
                switch ($row->status) {
                    case '0':
                        $status = '<span class="label label-default rounded-pill">Pending</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-success" onclick="approve('."'".$row->id."'".')"><i class="fa fa-check"></i> Setujui</button>
                        <button type="button" class="btn btn-xs btn-danger" onclick="reject('."'".$row->id."'".')"><i class="fa fa-times"></i> Tolak</button>';
                        break;
                    case '1':
                        $status = '<span class="label label-success rounded-pill">Selesai</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    case '2':
                        $status = '<span class="label label-danger rounded-pill">Ditolak</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="delete('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    case '3':
                        $status = '<span class="label label-default rounded-pill">Dibatalkan</span>';
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-receipt"></i> Lihat Detail</button>';
                        break;
                    
                    default:
                        $aksi = '<button type="button" class="btn btn-xs btn-default" onclick="invoice('."'".$row->id."'".')"><i class="fa fa-print"></i> Lihat Detail</button>';
                        break;
                }
                $subdata=array();
                $subdata[] = $row->id;
                $subdata[] = $row->created_at;
                $subdata[] = $row->id_member;
                $subdata[] = $row->nama_samaran;
                $subdata[] = $row->nama_plan;
                $subdata[] = currency($row->harga);
                $subdata[] = currency($row->qty);
                $subdata[] = currency($row->nominal);
                $subdata[] = '<button type="button" class="btn btn-xs btn-default" onclick="detail_produk('."'".$row->id."'".')">Detail Produk</button>';
                // $subdata[] = '<button type="button" class="btn btn-xs btn-default" onclick="detail_pin('."'".$row->id."'".')">Detail PIN</button>';
                // $subdata[] = $status;
                // $subdata[] = $row->updated_at;
                // $subdata[] = $aksi;
                $data[]    = $subdata;
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
            $sql 	= "INSERT INTO mlm_stokis_jual_pin(
                            id_member,
                            id_plan,
                            harga,
                            qty,
                            nominal,
                            status,
                            id_stokis,
                            keterangan,
                            created_at,
                            updated_at
                        ) 
                        values (
                            '".$this->get_id_member()."', 
                            '".$this->get_id_plan()."', 
                            '".$this->get_harga()."', 
                            '".$this->get_qty()."', 
                            '".$this->get_nominal()."', 
                            '".$this->get_status()."', 
                            '".$this->get_id_stokis()."', 
                            '".$this->get_keterangan()."',  
                            '".$this->get_created_at()."',  
                            '".$this->get_updated_at()."'
                        )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_stokis_jual_pin set 
                        status = '".$this->get_nominal()."',
                        id_stokis = '".$this->get_id_stokis()."', 
                        updated_at = '".$this->get_updated_at()."'
                        where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function update_status($id){
            $sql  = "UPDATE mlm_stokis_jual_pin SET
                        id_stokis = '".$this->get_id_stokis()."', 
                        status = '".$this->get_status()."', 
                        updated_at = '".$this->get_updated_at()."' 
                        WHERE id = '$id'";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT * FROM mlm_stokis_jual_pin WHERE deleted_at IS NULL ORDER BY id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT 
                        jp.created_at,
                        sm.id_stokis,
                        sm.nama_stokis,
                        m.id_member,
                        m.nama_member,
                        m.nama_samaran
                        FROM mlm_stokis_jual_pin jp
                        LEFT JOIN mlm_stokis_member sm ON jp.id_stokis = sm.id
                        LEFT JOIN mlm_member m ON jp.id_member = m.id
                        WHERE jp.id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function pending($id){
            $sql  = "SELECT * FROM mlm_stokis_jual_pin 
                        WHERE id = '$id'
                        AND status = '0'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function delete($id){
            $sql  = "DELETE FROM mlm_stokis_jual_pin WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function riwayat_pesanan($id_member, $start = 0, $keyword = '', $id_stokis = '', $start_date = '', $end_date = ''){
           
            $data_search =array(
                'sm.id_stokis',
                'sm.nama_stokis',
                'p.nama_produk',
                'j.name'
                );

            $sql  = "SELECT 
                        jp.id,
                        jp.created_at,
                        jp.id_stokis as stokis_id,
                        sm.id_stokis,
                        sm.nama_stokis,
                        sp.nama_paket
                        FROM mlm_stokis_jual_pin jp
                        JOIN mlm_stokis_member sm ON jp.id_stokis = sm.id
                        JOIN mlm_stokis_paket sp ON sm.id_paket = sp.id
                        JOIN mlm_stokis_jual_pin_detail dt ON dt.id_jual_pin = jp.id
                        JOIN mlm_produk p ON dt.id_produk = p.id 
                        JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                        WHERE jp.id_member = '$id_member'
                        AND ('$id_stokis' = '' OR jp.id_stokis = '$id_stokis')
                        AND ('$start_date' = '' OR LEFT(jp.created_at, 10) >= '$start_date')
                        AND ('$end_date' = '' OR LEFT(jp.created_at, 10) <= '$end_date')
                        AND jp.deleted_at IS NULL ";                        
            if(!empty($keyword)){
                $array_search = array();
                foreach ($data_search as $key => $value) {
                    $array_search[] ="$value LIKE '%".$keyword."%'";
                }
                $sql_search = implode(' OR ', $array_search);
                $sql.=" AND (".$sql_search.")";
            }

            $sql  .= "  
                        GROUP BY jp.id, jp.created_at, jp.id_stokis
                        ORDER BY jp.created_at DESC
                        LIMIT $start, 10";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_member_detail($id_member, $id_order){
            $sql  = "SELECT * FROM mlm_stokis_jual_pin_detail WHERE deleted_at IS NULL ORDER BY id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show_id($id){
            $sql  = "SELECT j.*, s.id_stokis, s.nama_stokis, m.id_member, m.nama_member 
                        FROM mlm_stokis_jual_pin j 
                        LEFT JOIN mlm_stokis_member s ON j.id_stokis = s.id
                        LEFT JOIN mlm_member m ON j.id_member = m.id
                        WHERE j.id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }
    }
?>