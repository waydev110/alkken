<ul class="sidebar-menu">
    <li class="">
        <a href="index.php"><i class="fad fa-home"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="header">Transaksi</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-cart-shopping-fast"></i> <span>Transaksi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=jual_pin"><i class="fa fa-circle-o"></i> Penjualan</a></li>
            <li class=""><a href="?go=jual_pin_list"><i class="fa fa-circle-o"></i> Riwayat</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fad fa-cart-shopping-fast"></i> <span>Transfer Stok</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php
    if($_SESSION['session_paket_stokis'] < 3){
        ?>
            <li class=""><a href="?go=stokis_transfer_create"><i class="fa fa-circle-o"></i> Transfer</a></li>
            <li class=""><a href="?go=stokis_transfer"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <?php
    }
    ?>
            <li class=""><a href="?go=stokis_terima"><i class="fa fa-circle-o"></i> Riwayat Terima</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fad fa-receipt"></i> <span>Pesanan <?=$lang['member']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=member_order"><i class="fa fa-circle-o"></i> Daftar Pesanan</a></li>
        </ul>
    </li>
    <!-- <li class="header">Fee Stokis</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-money-bill"></i> <span>Fee Penjualan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stokis_cashback"><i class="fa fa-circle-o"></i> Fee Penjualan</a></li>
            <li class=""><a href="?go=stokis_cashback_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li> -->
    <?php
    if($_SESSION['session_paket_stokis'] >= 1){
    ?>
    <li class="header">Inventori</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-cart-flatbed-boxes"></i> <span>Deposit Order</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stokis_deposit_create"><i class="fa fa-circle-o"></i> Deposit Order</a></li>
            <li class=""><a href="?go=stokis_deposit"><i class="fa fa-circle-o"></i> Riwayat Deposit Order</a></li>
        </ul>
    </li>
    <?php
    }
    ?>
    <!-- <li class="treeview">
        <a href="#"><i class="fad fa-cart-flatbed-boxes"></i> <span>Stokis Order</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stokis_order_list"><i class="fa fa-circle-o"></i> Stokis Order</a></li>
            <li class=""><a href="?go=stokis_order_riwayat"><i class="fa fa-circle-o"></i> Riwayat Stokis Order</a></li>
        </ul>
    </li> -->
    <li class="treeview">
        <a href="#"><i class="fad fa-boxes"></i> <span>Stok Produk</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stok_produk"><i class="fa fa-circle-o"></i> Daftar Stok Produk</a></li>
            <li class=""><a href="?go=mutasi_stok_produk"><i class="fa fa-circle-o"></i> Mutasi Stok Produk</a></li>
        </ul>
    </li>
    <li class="header">Pengaturan</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-shop"></i> <span> Manage Stokis</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=profil"><i class="fa fa-circle-o"></i> Profil</a></li>
            <li class=""><a href="?go=rekening"><i class="fa fa-circle-o"></i> Daftar Rekening</a></li>
        </ul>
    </li>
    <li class="header"></li>
</ul>