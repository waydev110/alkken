<?php

$html = '';
$subtotal = 0;
$diskon = 0;
$fee_stokis = 0;
while ($row = $get_cart->fetch_object()) {
    $jumlah = $row->harga * $row->qty;
    $subtotal = $subtotal + $jumlah;
    $diskon = $csp->fee_stokis($id_paket_stokis,$jumlah);
    $fee_stokis = $fee_stokis + $diskon;
    $html .= '
                <div class="col-xs-12" data-item="' . $row->id . '">
                    <div class="product-order">
                        <div class="product-order-detail">
                            <img src="../images/produk/' . $row->gambar . '" alt="" width="50px">
                            <div>
                                <h3 class="price-order fw-bold">' . $row->name . '</h3>
                                <h5 class="title my-0">' . $row->nama_produk .' '.$row->qty_produk.' '.$row->satuan. '</h5>
                                <h3 class="price-order">' . rp($row->harga) . ' x ' . currency($row->qty) . '</h3>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-bold my-0">' . rp($jumlah) . '</p>';
                if ($fee_stokis > 0) {
                    $html .= '<p class="price-order my-0">Diskon : ' . rp($fee_stokis) . '</p>';
                }
                $html .= '</div>
                    </div>
                </div>
            </div>';
}