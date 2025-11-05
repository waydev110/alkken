
    <!-- Footer -->
    <footer class="footer hidden-lg hidden-md">
        <div class="container">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item">
                    <a class="nav-link <?=$_GET['go'] == 'penukaran' ? 'active':''?>" href="<?=site_url('penukaran')?>">
                        <span>
                            <i class="fa-solid fa-grid-2"></i>
                            <span class="nav-text">Produk</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$_GET['go'] == 'keranjang_penukaran' ? 'active':''?>" href="<?=site_url('keranjang_penukaran')?>">
                        <?php
                        if(isset($total_cart->total_qty) > 0){
                        ?> 
                        
                        <span class="fa-stack has-badge" id="cart_icon" data-count="<?=$total_cart->total_qty?>">
                            <i class="fa-regular fa-cart-shopping"></i>
                            <span class="nav-text">Keranjang</span>
                        </span>
                        <?php
                        }else{
                        ?>
                        <span>
                            <i class="fa-regular fa-cart-shopping"></i>
                            <span class="nav-text">Keranjang</span>
                        </span>
                        <?php
                        }
                        ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$_GET['go'] == 'riwayat-penukaran' ? 'active':''?>" href="<?=site_url('riwayat-penukaran')?>">
                        <span>
                            <i class="fas fa-receipt"></i>
                            <span class="nav-text">Riwayat</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </footer>
    <!-- Footer ends-->
    