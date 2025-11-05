<?php   
require_once '../../../helper/all_member.php'; 
require_once '../../../model/classMember.php';
require_once '../../../model/classMemberOrder.php';

$cm = new classMember();
$obj = new classMemberOrder();

$id_member = $session_member_id;
$id_order = base64_decode($_POST['id_order']);

$order = $obj->pending($id_order, $id_member);
if(!$order){
    echo json_encode(['status' => false, 'message' => 'Pesanan tidak ditemukan.']);
    return false;
}

if ($_FILES['bukti_bayar']['size'] <> 0){
    $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
    $nama_file = $_FILES['bukti_bayar']['name'];
    $x = explode('.', $nama_file);
    $ekstensi = strtolower(end($x));
    $ukuran	= $_FILES['bukti_bayar']['size'];
    $file_tmp = $_FILES['bukti_bayar']['tmp_name'];
    $new_filename = $id_order.'.'.$ekstensi;
    $path = "../../../images/bukti_bayar/".$new_filename;

    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
        if($ukuran < 1044070){			
            move_uploaded_file($file_tmp, $path);
            $bukti_bayar = $new_filename;
        }else{
            echo json_encode(['status' => false, 'message' => 'Upload bukti pembayaran gagal.']);
            return false;
        }
    }else{
        echo json_encode(['status' => false, 'message' => 'Upload bukti pembayaran gagal. Ekstensi file yang diperbolehkan .png, jpg, .jpeg.']);
        return false;
    }
}

$updated_at = date('Y-m-d H:i:s');

$obj->set_id_member($id_member);
$obj->set_id($id_order);
$obj->set_bukti_bayar($bukti_bayar);
$obj->set_status(0);
$update = $obj->update_bukti_bayar();
if(!$update){
    echo json_encode(['status' => false, 'message' => 'Konfirmasi Pembayaran gagal.']);
    return false;
}

$message = '<p class="text-center text-muted mb-2 size-18">Konfirmasi Pembayaran Berhasil</p>
<p class="text-center text-muted mb-2 size-12">Anda dapat mengecek status pesanan anda di halaman Riwayat Pesanan.</p>
';
echo json_encode(['status' => true, 'message' => $message]);
return true;

?>