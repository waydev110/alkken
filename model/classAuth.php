<?php
require_once 'classConnection.php';

class classAuth{

    private $table = 'mlm_member';

	public function cek_username($id, $username){

		$sql = "SELECT COUNT(*) AS total from mlm_member where user_member = '$username' AND id <> '$id'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        if($query->total == 0) {
            return true;
        }
        return false;
	}

	public function cek_user_member($nama_samaran){

		$sql = "SELECT COUNT(*) AS total from mlm_member where LOWER(nama_samaran) = '$nama_samaran'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        if($query->total == 0) {
            return true;
        }
        return false;
	}

	public function update_username($id, $username){

		$sql = "UPDATE mlm_member SET user_member = '".$username."' WHERE id = '$id'";
        // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        if($query) {
            return true;
        }
        return false;
	}

	public function cek_password($id, $password){

		$sql = "SELECT id from mlm_member where id = '$id' and pass_member = '".base64_encode($password)."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        if($query->num_rows > 0) {
            return true;
        }
        return false;
	}

	public function update_password($id, $password){

		$sql = "UPDATE mlm_member SET pass_member = '".base64_encode($password)."' WHERE id = '$id'";
        // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        if($query) {
            return true;
        }
        return false;
	}

	public function cek_pin($id, $pin){

		$sql = "SELECT id from mlm_member where id = '$id' and pin_member = '".base64_encode($pin)."'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        if($query->num_rows > 0) {
            return true;
        }
        return false;
	}

	public function update_pin($id, $pin){

		$sql = "UPDATE mlm_member SET pin_member = '".base64_encode($pin)."' WHERE id = '$id'";
        // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        if($query) {
            return true;
        }
        return false;
	}
}

?>