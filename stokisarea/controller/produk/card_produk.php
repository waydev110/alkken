<?php

$html = '';
    while ($row = $get_produk->fetch_object()) {
        $html .= '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
    <div class="card-product">
        <div class="card-image">
            <img width="100%" class="img-fluid" src="../images/produk/' . $row->gambar . '" alt="">
        </div>
        <div class="product-description text-center">
            <div class="text-center">
                <p class="tag tag-primary">'.$row->name.'</p>
            </div>
            <h5 class="title">' . $row->nama_produk.' '.$row->qty.' '.$row->satuan. '</h5>
            <h3 class="price">' . rp($row->harga) . '</h3>
            <div class="pcard-description">
                <p><i class="fa-solid fa-box-open-full"></i> ' . currency($row->nilai_produk) . '</p>
                <p><i class="fa-solid fa-people-arrows"></i> ' . currency($row->poin_pasangan) . '</p>
                <p><i class="fa-solid fa-award"></i> ' . currency($row->poin_reward) . '</p>';
            if(isset($row->jumlah_stock)){
                $html .='<p><i class="fa-solid fa-boxes-stacked"></i> ' . currency($row->jumlah_stock) . '</p>';
            }
        $html .='
            </div>
        </div>
        <div class="form-group">
            <div class="d-grid">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-primary" onclick="minus(' . "'" . $row->id . "'" . ')"><i class="fa fa-minus"></i></button>
                    </span>
                    <input type="text" class="form-control input-sm text-center" id="qty' . $row->id . '" name="qty' . $row->id . '" value="1">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-primary" onclick="plus(' . "'" . $row->id . "'" . ')"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary btn-sm shadow-sm btn-block"
            onclick="addToCart(' . "'" . $row->id . "'" . ')">Tambahkan</button>
    </div>
    </div>';
    }