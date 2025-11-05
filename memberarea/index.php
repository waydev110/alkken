<?php 
    session_start();
    if(!isset($_SESSION['session_member_id']) || $_SESSION['session_member_id'] == ""){
        header("location:login.php");
    }
        
    $session_member_id = $_SESSION['session_member_id'];
    $session_id_member = $_SESSION['session_id_member'];
    $session_user_member = $_SESSION['session_user_member'];
    $session_nama_member = $_SESSION['session_nama_member'];
    $session_nama_samaran = $_SESSION['session_nama_samaran'];
    $session_tgl_lahir_member = $_SESSION['session_tgl_lahir_member'];
    $profile_updated = $_SESSION['profile_updated'];
    $session_group_akun = $_SESSION['session_group_akun'];
    $_group_akun = $_SESSION['_group_akun'];
    date_default_timezone_set("Asia/Jakarta");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once '../helper/all.php';
    require_once '../model/classSetting.php';
    require_once '../model/classMember.php';

    $s = new classSetting();
    $cm = new classMember();

    $sitename = $s->setting('sitename');
    $site_pt = $s->setting('site_pt');
    $theme = $s->setting('theme_memberarea');
    $binary = $s->setting('binary');
    
    $member = $cm->detail($session_member_id);
    $_member_plan = $member->id_plan;
    include 'routes.php';
?>