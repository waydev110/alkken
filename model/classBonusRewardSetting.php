<?php
    require_once 'classConnection.php';
    class classBonusRewardSetting{
        private $id;
        private $gambar;
        private $id_plan;
        private $poin;
        private $nominal;
        private $reward;        
        private $created_at;
        private $updated_at;
        private $deleted_at;


        #---------------------------------------------------------------------------------#
        public function get_id(){
            return $this->id;
        }

        public function set_id($id){
            $this->id = $id;
        }
        
        public function get_gambar(){
    		return $this->gambar;
    	}

    	public function set_gambar($gambar){
    		$this->gambar = $gambar;
    	}  
        
        public function get_poin(){
    		return $this->poin;
    	}
    	public function set_poin($poin){
    		$this->poin = $poin;
    	}
        
        public function get_id_plan(){
    		return $this->id_plan;
    	}
    	public function set_id_plan($id_plan){
    		$this->id_plan = $id_plan;
    	}
        
        public function get_nominal(){
    		return $this->nominal;
    	}
    	public function set_nominal($nominal){
    		$this->nominal = $nominal;
    	}
        
        public function get_reward(){
            return $this->reward;
        }

        public function set_reward($reward){
            $this->reward = $reward;
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
    
        #---------------------------------------------------------------------------------#

        public function create()
        {
            $sql 	= "INSERT INTO mlm_bonus_reward_setting(
                gambar, 
                reward, 
                id_plan, 
                poin, 
                nominal, 
                created_at) 
            values (
                '".$this->get_gambar()."',
                '".$this->get_reward()."',
                '".$this->get_id_plan()."', 
                '".$this->get_poin()."', 
                '".$this->get_nominal()."', 
                '".$this->get_created_at()."'
                )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_bonus_reward_setting set 
            gambar = '".$this->get_gambar()."', 
            reward = '".$this->get_reward()."', 
            id_plan = '".$this->get_id_plan()."', 
            poin = '".$this->get_poin()."', 
            nominal = '".$this->get_nominal()."', 
            updated_at = '".$this->get_updated_at()."'
            where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
        public function index($id_plan=''){
            $sql  = "SELECT r.*, pl.nama_plan, pl.nama_reward
                        FROM mlm_bonus_reward_setting r
                        LEFT JOIN mlm_plan pl ON r.id_plan = pl.id 
                        WHERE r.deleted_at IS NULL 
                        AND CASE WHEN LENGTH('$id_plan') > 0 THEN r.id_plan = '$id_plan' ELSE 1 END
                        ORDER BY r.poin ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_bonus_reward_setting WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }
    }
?>