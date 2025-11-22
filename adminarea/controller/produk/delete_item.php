<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classProduk.php';
    require_once '../../../model/classStokisProduk.php';

    $obj = new classProduk();
    $csp = new classStokisProduk();
    
    $id = addslashes(strip_tags($_POST['id']));

    $delete = $obj->delete($id);
    
    if($delete){
        $obj->deleteProdukPlan($id);
        echo json_encode(['status' => true, 'message' => 'Produk berhasil dihapus.']);
        return true;
    }else{
        echo json_encode(['status' => true, 'message' => 'Produk gagal dihapus.']);
        return true;
    }