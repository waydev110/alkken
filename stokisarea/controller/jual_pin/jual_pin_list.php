<?php 
    session_start();
    $id_stokis = $_SESSION['session_stokis_id'];
    $request = $_REQUEST;
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisJualPin.php';
    $obj = new classStokisJualPin();
    $data = $obj->datatable($request, $id_stokis);
    echo json_encode($data);
    return true;
?>