<?php
require_once 'classConnection.php';
class classSetting{
    
	public function setting($part){
		$sql = "SELECT value FROM mlm_admin_configs WHERE part = '$part' LIMIT 1";
		$c = new classConnection();
		$query = $c->_query($sql);
		if($query->num_rows > 0){
            $result = $query->fetch_object();
            return $result->value;
        } else {
            return '';
        }
	}
}

?>