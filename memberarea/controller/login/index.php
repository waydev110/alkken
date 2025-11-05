<?php
session_start();
if($_SESSION["captcha"] != $_POST["captcha"]){
    echo "Captcha yang anda masukan salah.";
}else{ 

    // require_once '../auth/recaptcha.php';
    require_once '../../../model/classLoginMember.php';
    require_once '../../../model/classSMS.php';

    $obj = new classLoginMember();
    $sms = new classSMS();

    $_username = addslashes(strip_tags($_POST['identity']));
    $_password = addslashes(strip_tags($_POST['password']));

    $cek = $obj->CekLogin($_username, $_password);

    if($cek > 0){
    	$login = $obj->LoginSubmit($_username, $_password);
    	if($login == 'true'){
            // $sms->smsLogin($_SESSION['session_member_id']);
    		echo true;
    	}else if($login == 'blokir'){
    		echo "Maaf. Akun anda diblokir.";
    	} else {
    		echo "Login gagal. Kombinasi username dan password salah.";
        }
    }else{
    	echo "Anda tidak mempunyai akses.";
    }
}