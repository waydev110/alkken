<style>
    .btn-nmall.btn-default {
        border-color:transparent;
        background: #d9dfd5;
        background-color: #d9dfd5;
    }
    .main-header .navbar-custom-menu a.btn-nmall, .main-header .navbar-right a.btn-nmall {
        border-color:transparent;
        background: #d9dfd5;
    }
</style>
<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>

<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <li class="hidden-xs"><a href="?go=stokis_deposit_create">Deposit Order</a></li>
        <li class="hidden-xs"><a href="?go=stok_produk">Stok Produk</a></li>
        <li class="hidden-xs"><a href="?go=jual_pin">Penjualan</a></li>
        <li class="hidden-xs"><a href="?go=stokis_transfer_create">Transfer Stok</a></li>
        <li class="hidden-xs"><a href="?go=member_order">Pesanan</a></li>

        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span><?=$_SESSION['session_nama_stokis'];?></span>
                <img src="../assets/dist/img/stokis.png" class="user-image" alt="User Image">
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="../assets/dist/img/stokis.png" class="img-circle" alt="User Image">
                    <p>
                        <?=$_SESSION['session_nama_stokis'];?>
                        <small><?=date('Y-m-d H:i:s',time());?></small>
                    </p>
                </li>

                <li class="user-footer">
                    <div class="pull-left">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="view/logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>