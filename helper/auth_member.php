<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['session_member_id']) || $_SESSION['session_member_id'] == ""){
        header("location:login.php");
    }
    if(isset($_SESSION['session_member_id'])){
        $session_member_id = $_SESSION['session_member_id'];
        $session_id_member = $_SESSION['session_id_member'];
        $session_user_member = $_SESSION['session_user_member'];
        $session_nama_member = $_SESSION['session_nama_member'];
        $session_nama_samaran = $_SESSION['session_nama_samaran'];
        $profile_updated = $_SESSION['profile_updated'];
        $session_group_akun = $_SESSION['session_group_akun'];
        $_group_akun = $_SESSION['_group_akun'];
    }
    