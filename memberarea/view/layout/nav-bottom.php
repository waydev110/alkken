<!-- Footer -->
<style>
.footer {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 1000;
}
.footer .nav {
    align-items: center;
    max-width: 100%!important;
    margin: 0 auto;
}

.footer .nav-pills {
    margin: 0;
}

.footer .nav-link {
    color: #b8b8b8;
    transition: all 0.3s ease;
    padding: 8px 5px;
    position: relative;
}

.footer .nav-link:hover,
.footer .nav-link.active {
    color: #d4af37;
    transform: translateY(-3px);
}

.footer .nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, #d4af37, transparent);
    transition: width 0.3s ease;
}

.footer .nav-link:hover::after {
    width: 80%;
}

.footer .nav-icon {
    font-size: 22px;
    display: block;
    margin-bottom: 4px;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

.footer .nav-text {
    font-size: 11px;
    font-weight: 500;
    display: block;
    letter-spacing: 0.3px;
}

.footer .centerbutton .nav-link {
    position: relative;
    top: -25px;
}

.footer .centerbutton .bg-theme {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
    position: relative;
    transition: all 0.3s ease;
    border: 3px solid #1a1a1a;
}

.footer .centerbutton .bg-theme i {
    color:#1a1a1a;
}

.footer .centerbutton .nav-link:hover .bg-theme {
    /* transform: scale(1.1) rotate(90deg); */
    box-shadow: 0 10px 30px rgba(212, 175, 55, 0.6);
}

.footer .centerbutton .nav-icon {
    width: 32px;
    height: 32px;
    filter: brightness(0) invert(1);
}

.footer .centerbutton .close {
    display: none;
    font-size: 28px;
    color: #1a1a1a;
    font-weight: bold;
}

@media (max-width: 576px) {
    .footer .nav-icon {
        font-size: 20px;
    }
    
    .footer .nav-text {
        font-size: 10px;
    }
}
.footer .nav .nav-item .nav-link
 {
    text-align: center;
    background: transparent;
    align-self: center;
    -webkit-align-self: center;
    -moz-align-self: center;
    height: 100%;
    line-height: 44px;
    color: #eecd70;
    padding: calc(var(--mlm-padding) - 5px) calc(var(--mlm-padding) - 10px);
}
.footer .nav .nav-item.centerbutton .nav-link > span {
    height: 90px;
    padding-top: 15px;
}
ol, ul {
    padding-left: 0;
}
</style>

<footer class="footer">
    <div class="container">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <span>
                        <i class="nav-icon fa-light fa-house"></i>
                        <span class="nav-text">Home</span>
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=site_url('cart')?>">
                    <span>
                        <i class="nav-icon fa-light fa-cart-shopping"></i>
                        <span class="nav-text">Keranjang</span>
                    </span>
                </a>
            </li>
            <li class="nav-item centerbutton">
                <?php
                if($_binary == true){
                    $link = site_url('genealogy_v1');
                } else {
                    $link = site_url('member_create');
                }
                ?>
                <a class="nav-link" href="<?=$link?>">
                    <span class="bg-theme">
                        <i class="nav-icon fa-light fa-network-wired"></i>
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=$show_modul?site_url('bonus'):site_url('riwayat_wallet_cash')?>">
                    <span>
                        <i class="nav-icon fa-light fa-analytics"></i>
                        <span class="nav-text">Bonus</span>
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=site_url('profil')?>">
                    <span>
                        <i class="nav-icon fa-light fa-user-circle"></i>
                        <span class="nav-text">Profil</span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</footer>
<!-- Footer ends-->