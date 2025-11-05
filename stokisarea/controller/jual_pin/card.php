<?php
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
                                <h3 class="price-order fw-bold">' . $row->name . '</h3>
                                <h5 class="title my-0">'.$row->nama_produk.'</h5>
                                <h3 class="price-order"><span><i class="fa-solid fa-box-open-full"></i> ' . currency($row->nilai_produk*$row->qty) . '</span> : '.rp($row->harga).' x '.currency($row->qty).'</h3>
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