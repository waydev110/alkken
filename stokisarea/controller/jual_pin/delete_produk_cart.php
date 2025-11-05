<?php
    session_start();
    $id_stokis = $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classStokisJualPinCart.php';
    require_once '../../../model/classPlan.php';

    $cm = new classMember();
    $obj = new classStokisJualPinCart();
    $cpl = new classPlan();

    if(!isset($_POST['id_member'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_member = $cm->show_id(addslashes(strip_tags($_POST['id_member'])));
    if(!$id_member){
        echo json_encode(['status' => false, 'message' => 'Member tidak ditemukan.']);
        return false;
    }
    $id_produk = addslashes(strip_tags($_POST['id_produk']));
    $delete = $obj->delete_produk_cart($id_member, $id_stokis, $id_produk);
    if(!$delete){
        echo json_encode(['status' => false, 'message' => 'Tidak dapat membatalkan produk.']);
        return false;
    }
    $id_plan = 0;
    if(isset($_POST['id_plan']) && $_POST['id_plan'] > 0){
        $id_plan = $_POST['id_plan'];
    }
    $plan = $cpl->show($id_plan);

    if($plan){    
        $jenis_plan = $plan->jenis_plan;    
        $get_cart = $obj->get_cart($id_member, $id_stokis, $id_plan);
        $html = '';
        $diskon = 0;
        $subtotal = 0;
        $total_nilai_produk = 0;
        while($row = $get_cart->fetch_object()){
            $jumlah = $row->harga*$row->qty;
            $subtotal = $subtotal + $jumlah;
            $produk_diskon = $obj->produk_diskon($row->id_produk, $row->qty);
            if($produk_diskon){
                if($produk_diskon->diskon == 'nominal'){
                    $diskon += $produk_diskon->nominal * $row->qty;
                } else {
                    $diskon += $row->harga*($produk_diskon->persetase/100) * $row->qty;
                }
            }
            $total_nilai_produk += $row->nilai_produk*$row->qty;
            $html .= '
                    <div class="col-xs-12" data-item="'.$row->id.'">
                        <div class="product-order">
                            <div class="product-order-detail">
                                <img src="../images/produk/'.$row->gambar.'" alt="" width="50px">
                                <div>
                                    <h5 class="title my-0">'.$row->nama_produk.'</h5>
                                    <h3 class="price-order">'.rp($row->harga).' x '.currency($row->qty).'</h3>
                                    <h5 class="price-order">Nilai Produk : '.decimal($row->nilai_produk).' x '.number($row->qty).' = '.decimal($row->nilai_produk*$row->qty).'</h5>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-bold">'.rp($jumlah).'</p>
                                <button type="button" class="btn btn-xs" onclick="cancel('."'".$row->id_produk."'".')">Batalkan</button>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        $total = $subtotal-$diskon;
    }
    echo json_encode(['status' => true, 'html' => $html, 'subtotal' => rp($subtotal), 'diskon' => currency($diskon), 'total_nilai_produk' => decimal($total_nilai_produk), 'total' => rp($total)]);
    return true;