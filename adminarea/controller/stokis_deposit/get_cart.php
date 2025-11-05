<?php
    session_start();
    $id_admin = $_SESSION['id_login'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisDepositCartByAdmin.php';

    $obj = new classStokisDepositCartByAdmin();

    if(!isset($_POST['id_stokis'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_stokis = addslashes(strip_tags($_POST['id_stokis']));
    
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