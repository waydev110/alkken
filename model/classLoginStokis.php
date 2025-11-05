<?php
session_start();
require_once 'classConnection.php';

class classLoginStokis{
	public function LoginSubmit($username, $password){
		$login = false;
		$sql = "SELECT * FROM mlm_stokis_member where (username = '$username' or id_stokis = '$username') and password = '".base64_encode($password)."'";
		// echo $sql;
        $c 		= new classConnection();
        $hasil_login = $c->_query_fetch($sql);

		if($hasil_login){
			$_SESSION['session_stokis_id']  = $hasil_login->id;
			$_SESSION['session_id_stokis']= $hasil_login->id_stokis;
			$_SESSION['session_nama_stokis']= $hasil_login->nama_stokis;
			$_SESSION['session_paket_stokis']= $hasil_login->id_paket;
			$_SESSION['session_last_login_stokis']= date('Y-m-d H:i:s',time());
			$login = true;
		}else{
			$login = false;
		}
		return $login;	
	}
}

?>