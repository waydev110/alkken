<?php
require_once 'classConnection.php';

class classLogin{

	public function CekLogin($usr, $pwd){

		$sql = "SELECT user_admin, pass_admin, status_admin from mlm_admin 
                WHERE user_admin = '$usr' and pass_admin = '".base64_encode($pwd)."'";
		$c = new classConnection();
		$c->openConnection();
		$query = $c->koneksi->query($sql);
		$row = $query->num_rows;

		return $row;

	}
		
	public function LoginSubmit($usr, $pwd){
		$login = false;

		$sql = "SELECT id, nama_admin, user_admin, pass_admin, level_admin from mlm_admin where user_admin = '$usr' and pass_admin = '".base64_encode($pwd)."'";
		$c = new classConnection();
		$hasil_login = $c->_query_fetch($sql);

		if($hasil_login){
			session_start();
			$_SESSION['id_login']  = $hasil_login->id;
			$_SESSION['user_login']= $hasil_login->user_admin;
			$_SESSION['pass_login']= $hasil_login->pass_admin;
			$_SESSION['level_login']= $hasil_login->level_admin;
			$_SESSION['nama_login']= $hasil_login->nama_admin;
			$_SESSION['last_login']= date('Y-m-d H:i:s',time());
			$login = true;
		}else{
			$login = false;
		}

		return $login;		

	}
}

?>