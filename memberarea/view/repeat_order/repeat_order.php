<?php 
    require_once '../model/classProduk.php';

    $cp = new classProduk();
    $products = $cp->index(1);

?>
        <div class="row">
            <?php
            if($products->num_rows > 0){
            ?>
            <div class="col-12">
                <h4>Produk</h4>
                <div class="owl-carousel owl-theme show-nav-title mt-2 mb-2">
                    <?php
                while($product = $products->fetch_object()){
                    ?>
                    <div class="bg-white rounded-10 p-2">
                        <a href="?go=produk_detail&produk=<?=$product->slug?>" class="image">
                            <img width="100%" class="img-fluid" src="../images/produk/<?=$product->gambar?>"
                                alt="image">
                        </a>
                        <div class="product-description mb-2">
                            <a href="?go=produk_detail&produk=<?=$product->slug?>"
                                class="title"><?=$product->nama_produk?></a>
                            <div class="product-body">
                                <div class="row">
                                    <div class="col-auto pe-2">
                                        <div class="avatar avatar-20 shadow rounded-circle bg-theme text-white size-10">
                                            <i class="fa-solid fa-cart-shopping-fast"></i>
                                        </div>
                                    </div>
                                    <div class="col align-self-center ps-0">
                                        <h3 class="text-theme price size-18 fw-bolder pt-1">
                                            <?=currency($product->harga)?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-default btn-sm shadow-sm"
                                onclick="addToCart('<?=$product->id?>')">Tambahkan ke
                                Keranjang</button>

                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>