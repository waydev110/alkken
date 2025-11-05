<?php
require_once 'classConnection.php';

class classRewardPromo{

	public function index(){
		$sql = "SELECT * from mlm_reward_promo 
                WHERE status = '1' and deleted_at IS NULL 
                ORDER BY id ASC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
	}
}

?>