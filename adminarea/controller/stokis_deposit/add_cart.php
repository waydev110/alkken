<?php
    session_start();
    $id_admin = $_SESSION['id_login'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisDepositCartByAdmin.php';

    $obj = new classStokisDepositCartByAdmin();

    if(!isset($_POST['id_produk'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_produk = addslashes(strip_tags($_POST['id_produk']));
    $id_stokis = addslashes(strip_tags($_POST['id_stokis']));
    $qty = number($_POST['qty']);
    $created_at = date('Y-m-d H:i:s');

    $total_keranjang = $obj->cek_keranjang($id_stokis, $id_produk);
    if($total_keranjang == 0){
        $created_at = date('Y-m-d H:i:s');
        $obj->set_id_admin($id_admin);
        $obj->set_id_stokis($id_stokis);
        $obj->set_id_produk($id_produk);
        $obj->set_qty($qty);
        $obj->set_status(0);
        $obj->set_created_at($created_at);
    
        $create = $obj->create();
        if(!$create){
            echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal menambahkan ke keranjang.']);
            return false;
        }
    
    } else {
        $updated_at = date('Y-m-d H:i:s');
        $obj->set_id_stokis($id_stokis);
        $obj->set_id_produk($id_produk);
        $obj->set_qty($qty);
        $obj->set_updated_at($updated_at);
        $update = $obj->update();
        if(!$update){
            echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal mengupdate keranjang.']);
            return false;
        }
    }
    
    $get_cart = $obj->get_cart($id_stokis, $id_admin);
    $html = '';
    $subtotal = 0;
    while($row = $get_cart->fetch_object()){
        $jumlah = $row->harga*$row->qty;
        $subtotal = $subtotal + $jumlah;
        $html .= '
                <div class="col-xs-12" data-item="'.$row->id.'">
                    <div class="product-order">
                        <div class="product-order-detail">
                            <img src="../images/produk/'.$row->gambar.'" alt="" width="50px">
                            <div>
                            
                                <h5 class="title my-0">'.$row->nama_produk.'</h5>
                                <h3 class="price-order">'.rp($row->harga).' x '.currency($row->qty).'</h3>
                            </div>
                        </div>
                        <span class="text-bold">'.rp($jumlah).'</span>
                    </div>
                </div>
            </div>';
    }
    echo json_encode(['status' => true, 'html' => $html, 'subtotal' => rp($subtotal), 'total' => rp($subtotal)]);
    return true;