<?php
require_once 'classConnection.php';

class classLoginMember{

	public function CekLogin($usr, $pwd){

		$sql = "SELECT nama_samaran, pass_member, status_member from mlm_member where (user_member = '$usr' or id_member = '$usr') and pass_member = '".base64_encode($pwd)."'";
// 		echo $sql;
		$c = new classConnection();
		$query = $c->_query($sql);
		$row = $query->num_rows;
		return $row;
	}

	public function CekAkun($id_member, $session_group_akun){

		$sql = "SELECT id_member, pass_member from mlm_member 
                WHERE id_member = '$id_member' 
                AND group_akun = '$session_group_akun' 
                AND group_akun IS NOT NULL AND group_akun <> ''";
		// echo $sql;
        $c = new classConnection();
		$query = $c->_query_fetch($sql);
        return $query;
	}
		
	public function LoginSubmit($usr, $pwd){
		$login = false;
		$sql = "SELECT * FROM mlm_member a 
        		WHERE (a.id_member = '$usr' or a.user_member = '$usr') 
        		AND a.pass_member = '".base64_encode($pwd)."'";
		$c = new classConnection();
		$query = $c->_query($sql);
        $num_rows = $query->num_rows;
		if($num_rows > 0){
            $hasil_login = $query->fetch_object();
			if($hasil_login->status_member == '1'){
                session_start();
                $_SESSION['session_member_id']  			= $hasil_login->id;
                $_SESSION['session_id_member']  			= $hasil_login->id_member;
                $_SESSION['session_user_member']  			= $hasil_login->user_member;
                $_SESSION['session_nama_samaran']  			= $hasil_login->nama_samaran;
                $_SESSION['session_nama_member']  			= $hasil_login->nama_member;
                $_SESSION['session_tgl_lahir_member']  		= $hasil_login->tgl_lahir_member;
                $_SESSION['profile_updated']   	   			= $hasil_login->profile_updated;
                $_SESSION['session_group_akun']        	   	= $hasil_login->group_akun;
                $_SESSION['session_last_login']				= date('Y-m-d H:i:s',time());
                $_SESSION['_group_akun']        	   	    = $this->daftar_akun($hasil_login->group_akun);
                $login = 'true';
            } else {
                $login = 'blokir';
            }
		}else{
			$login = false;
		}
		return $login;		
	}
	
	
    public function daftar_akun($group_akun){
        $sql  = "SELECT id, id_member, nama_samaran from mlm_member where group_akun = '$group_akun'  AND group_akun IS NOT NULL AND group_akun <> '' AND status_member = '1' AND deleted_at IS NULL";
      //   echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        $arr_akun = array();
        while ($row = $query->fetch_array()) {
            $arr_akun[] = $row;
        }
        return $arr_akun;
    }
}

?>