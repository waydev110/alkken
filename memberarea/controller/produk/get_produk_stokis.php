<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classProduk.php';

    $obj = new classProduk();

    $keyword = '';
    if(isset($_POST['id_stokis'])){
        $id_stokis = $_POST['id_stokis'];
    }
    $keyword = '';
    if(isset($_POST['keyword'])){
        $keyword = $_POST['keyword'];
    }
    $get_produk = $obj->index_order($id_stokis, $keyword);
    $html = '';
    if($get_produk->num_rows > 0){
        while($product = $get_produk->fetch_object()){        
            $html .= '<div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bg-white rounded-10 mb-4 p-2">
                            <a href="#" class="image">
                                <img width="100%" class="img-fluid" src="../images/produk/'.$product->gambar.'"
                                    alt="image">
                            </a>
                            <div class="product-description mb-2">
                                <a href="#"
                                    class="title">'.$product->nama_produk.'</a>
                                <div class="product-body">
                                    <div class="row">
                                        <div class="col-auto pe-2">
                                            <div class="avatar avatar-20 shadow rounded-circle bg-theme text-white size-10">
                                                <i class="fa-solid fa-cart-shopping-fast"></i>
                                            </div>
                                        </div>
                                        <div class="col align-self-center ps-0">
                                            <h3 class="text-theme price size-18 fw-bolder pt-1">
                                                '.currency($product->harga).'</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn btn-default shadow-sm"
                                    onclick="addToCart('."'".$product->id."'".')">Tambahkan ke
                                    Keranjang</button>

                            </div>
                        </div>
                    </div>';
        }
    } else {
        $html = '<div class="card mx-2 mt-4 shadow-none rounded-0" style="padding-top:80px">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col">
                                <p class="text-muted text-center"><i class="fa-solid fa-box-open fa-8x"></i></p>                            
                                <p class="text-center fw-normal">Tidak ada produk.</p>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    echo json_encode(['status' => true, 'html' => $html]);
    return true;