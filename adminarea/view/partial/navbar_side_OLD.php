<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="">
        <a href="index.php"><i class="fad fa-home"></i> <span>Dashboard</span>
        </a>
    </li>
    <?php
    if($_SESSION['level_login'] == '6'){
    ?>
    <li class="treeview">
        <a href="#"><i class="fad fa-users"></i> <span>Manage <?=$lang['member']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=member_list"><i class="fa fa-circle-o"></i> Daftar <?=$lang['member']?></a></li>
            <li class=""><a href="?go=member_elemen"><i class="fa fa-circle-o"></i> Elemen <?=$lang['member']?></a></li>
        </ul>
    </li>
    <li class="header">Manage Stokis</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-store"></i> <span>Manage <?=$lang['stokis']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stokis_member"><i class="fa fa-circle-o"></i> Daftar <?=$lang['stokis']?></a></li>
        </ul>
    </li>
    <?php if($_binary == true) { ?>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus <?=$lang['pasangan']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_pasangan_rekap_list"><i class="fa fa-circle-o"></i> Daftar Rekap Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
        </ul>
    </li>
    <?php } ?>
    <?php 
    }
    ?>
    <?php
    if($_SESSION['level_login'] == '5' || $_SESSION['level_login'] == '4' || $_SESSION['level_login'] == '3' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <?php
    if($_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <li class="treeview">
        <a href="#"><i class="fad fa-mug-hot"></i> <span>Manage Website</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=slide_website"><i class="fa fa-circle-o"></i> Slide Halaman Depan</a></li>
            <li class=""><a href="?go=profile"><i class="fa fa-circle-o"></i> Profile Perusahaan</a></li>
            <li class=""><a href="?go=legalitas"><i class="fa fa-circle-o"></i> Legalitas</a></li>
            <li class=""><a href="?go=visimisi"><i class="fa fa-circle-o"></i> Visi dan Misi</a></li>
            <li class=""><a href="?go=managemen"><i class="fa fa-circle-o"></i> Managemen</a></li>
            <li class=""><a href="?go=system"><i class="fa fa-circle-o"></i> Marketing Plan</a></li>
            <li class=""><a href="?go=kode_etik"><i class="fa fa-circle-o"></i> Kode Etik</a></li>
            <li class=""><a href="?go=kontak_kami"><i class="fa fa-circle-o"></i> Kontak Kami</a></li>
            
            
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fad fa-mug-hot"></i> <span>Manage Konten</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=slide"><i class="fa fa-circle-o"></i> Manage Slide</a></li>
            <li class=""><a href="?go=slide_certificate"><i class="fa fa-circle-o"></i> Manage Slide Certificate</a></li>
            <li class=""><a href="?go=berita_list"><i class="fa fa-circle-o"></i> Manage Berita</a></li>
            <li class=""><a href="?go=pengumuman_list"><i class="fa fa-circle-o"></i> Manage Pengumuman</a></li>
            <li class=""><a href="?go=testimoni"><i class="fa fa-circle-o"></i> Manage Testimoni</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fad fa-box-full"></i> <span>Manage Rekening</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bank"><i class="fa fa-circle-o"></i> Daftar Bank</a></li>
            <li class=""><a href="?go=rekening"><i class="fa fa-circle-o"></i> Rekening Perusahaan</a></li>
        </ul>
    </li>
    <?php }
    ?>
    <?php
    if($_SESSION['level_login'] == '4' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <li class="treeview">
        <a href="#"><i class="fad fa-users"></i> <span>Manage <?=$lang['member']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=member_list"><i class="fa fa-circle-o"></i> Daftar <?=$lang['member']?></a></li>
            <li class=""><a href="?go=member_elemen"><i class="fa fa-circle-o"></i> Elemen <?=$lang['member']?></a></li>
            <!-- <li class=""><a href="?go=member_ro"><i class="fa fa-circle-o"></i> Daftar <?=$lang['member']?> RO</a></li> -->
        </ul>
    </li>
    <li class="header">Manage Stokis</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-store"></i> <span>Manage <?=$lang['stokis']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stokis_member"><i class="fa fa-circle-o"></i> Daftar <?=$lang['stokis']?></a></li>
            <li class=""><a href="?go=stokis_paket"><i class="fa fa-circle-o"></i> Daftar Paket <?=$lang['stokis']?></a></li>
        </ul>
    </li>
    <?php 
    }
    ?>
    <?php
    if($_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <li class="treeview">
        <a href="#"><i class="fad fa-cart-flatbed-boxes"></i> <span>Deposit <?=$lang['stokis']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stokis_deposit"><i class="fa fa-circle-o"></i> Daftar Deposit</a></li>
            <li class=""><a href="?go=stokis_deposit_riwayat"><i class="fa fa-circle-o"></i> Riwayat Deposit</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fad fa-cart-flatbed-boxes"></i> <span>Order <?=$lang['stokis']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stokis_order_list"><i class="fa fa-circle-o"></i> Konfirmasi Pembayaran</a></li>
            <li class=""><a href="?go=stokis_order_pending"><i class="fa fa-circle-o"></i> Menunggu Proses Stokis</a></li>
            <li class=""><a href="?go=stokis_order_kirim"><i class="fa fa-circle-o"></i> Kirim Produk ke Stokis</a></li>
            <li class=""><a href="?go=stokis_order_riwayat"><i class="fa fa-circle-o"></i> Riwayat</a></li>
        </ul>
    </li>
    <!-- <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Fee Stokis</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=stokis_cashback_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=stokis_cashback_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=stokis_cashback_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li> -->
    <!-- <li class="header">Manage Penarikan</li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Penarikan Saldo Wallet</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=transfer_penarikan"><i class="fa fa-circle-o"></i> Daftar Penarikan</a></li>
            <li class=""><a href="?go=riwayat_transfer"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=riwayat_reject"><i class="fa fa-circle-o"></i> Riwayat Ditolak</a></li>
        </ul>
    </li> -->
    <!-- <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Penarikan Poin ke Market</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=transfer_penarikan_market"><i class="fa fa-circle-o"></i> Daftar Penarikan</a></li>
            <li class=""><a href="?go=riwayat_transfer_market"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=riwayat_reject_market"><i class="fa fa-circle-o"></i> Riwayat Ditolak</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Penarikan Poin ke Coin</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=transfer_penarikan_coin"><i class="fa fa-circle-o"></i> Daftar Penarikan</a></li>
            <li class=""><a href="?go=riwayat_transfer_coin"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=riwayat_reject_coin"><i class="fa fa-circle-o"></i> Riwayat Ditolak</a></li>
        </ul>
    </li> -->
    <?php 
    }?>
    <?php
    if($_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <li class="header">Manage Kode Aktivasi</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-code"></i> <span>Kode Aktivasi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=kodeaktivasi_list"><i class="fa fa-circle-o"></i> Daftar <?=$lang['kode_aktivasi']?></a></li>
            <li class=""><a href="?go=kodeaktivasi_create"><i class="fa fa-circle-o"></i> Create <?=$lang['kode_aktivasi']?></a></li>
        </ul>
    </li>
    <?php 
    }?>
    <?php 
    if($_SESSION['level_login'] == '3' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <!-- <li class="header">Bonus Web Lama</li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Semua Bonus Lama</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_lama_rekap"><i class="fa fa-circle-o"></i> Rekap Bonus</a></li>
            <li class=""><a href="?go=bonus_lama"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_lama_transfer"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li> -->
    <li class="header">Manage Bonus</li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Harian</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <!-- <li class="header">Manage Laporan</li>
    <li class="treeview">
        <li class=""><a href="?go=laporan_rekap_bonus"><i class="fa fa-circle-o"></i> Laporan Rekap Bonus</a></li>
    </li> -->
    <li class="header">Manage Bonus</li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus <?=$lang['sponsor']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_sponsor_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_sponsor_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_sponsor_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus <?=$lang['sponsor']?> Monoleg</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_sponsor_monoleg_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_sponsor_monoleg_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_sponsor_monoleg_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <?php if($_binary == true) { ?>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus <?=$lang['pasangan']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <!-- <li class=""><a href="?go=bonus_pasangan_rekap_list"><i class="fa fa-circle-o"></i> Daftar Rekap Bonus</a></li> -->
            <li class=""><a href="?go=bonus_pasangan_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Matching</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_pasangan_level_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_level_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_level_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <?php } ?>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Generasi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_generasi_ro_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_generasi_ro_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_generasi_ro_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Cashback</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_cashback_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_cashback_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_cashback_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Reward</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_reward"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_reward_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_reward_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Royalti Platinum Plus</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_royalti_omset_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_royalti_omset_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_royalti_omset_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Founder</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_founder_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_founder_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_founder_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        </ul>
    </li>
    <!-- <li class="treeview">
        <a href="#"><i class="fad fa-store"></i> <span>Klaim Autosave</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=klaim_autosave">Daftar Klaim Produk</a></li>
            <li class=""><a href="?go=riwayat_saldo_autosave">Saldo Autosave</a></li>
        </ul>
    </li> -->
    <?php 
    }?>
    <?php 
    if($_SESSION['level_login'] == '5' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <!-- <li class="header">Undian</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-box-full"></i> <span>Data Kupon</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=kupon_bulanan"><i class="fa fa-circle-o"></i> Kupon Undian Bulanan</a></li>
            <li class=""><a href="?go=kupon_tiga_bulanan"><i class="fa fa-circle-o"></i> Kupon Undian 3Bulanan</a></li>
            <li class=""><a href="?go=kupon_tahunan"><i class="fa fa-circle-o"></i> Kupon Undian Tahunan</a></li>
        </ul>
    </li>
    <li class="header">Undian</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-box-full"></i> <span>Undian Bulanan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=pemenang_undian&id=1"><i class="fa fa-circle-o"></i> Daftar Pemenang</a></li>
            <li class=""><a href="?go=pemenang_proses&id=1"><i class="fa fa-circle-o"></i> Proses Pemenang</a></li>
            <li class=""><a href="?go=pemenang_laporan&id=1"><i class="fa fa-circle-o"></i> Laporan Proses Pemenang</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fad fa-box-full"></i> <span>Undian 3Bulanan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=pemenang_undian&id=2"><i class="fa fa-circle-o"></i> Daftar Pemenang</a></li>
            <li class=""><a href="?go=pemenang_proses&id=2"><i class="fa fa-circle-o"></i> Proses Pemenang</a></li>
            <li class=""><a href="?go=pemenang_laporan&id=2"><i class="fa fa-circle-o"></i> Laporan Proses Pemenang</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fad fa-box-full"></i> <span>Undian Tahunan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=pemenang_undian&id=3"><i class="fa fa-circle-o"></i> Daftar Pemenang</a></li>
            <li class=""><a href="?go=pemenang_proses&id=3"><i class="fa fa-circle-o"></i> Proses Pemenang</a></li>
            <li class=""><a href="?go=pemenang_laporan&id=3"><i class="fa fa-circle-o"></i> Laporan Proses Pemenang</a></li>
        </ul>
    </li> -->
    
    <li class="header">Manage Setting</li>
    <li>
        <a href="?go=produk"><i class="fad fa-box-full"></i> <span>Setting Produk</span>
        </a>
    </li>
    
    
    <li class="treeview">
        <a href="#"><i class="fad fa-box-full"></i> <span>Data Setting</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bank"><i class="fa fa-circle-o"></i> Daftar Bank</a></li>
            <li class=""><a href="?go=rekening"><i class="fa fa-circle-o"></i> Rekening Perusahaan</a></li>
            <li class=""><a href="?go=user"><i class="fa fa-circle-o"></i> User Admin</a></li>
        </ul>
    </li>
    <?php 
    }
    ?>
    <?php 
    }
    ?>
    <li class="header" style="height:250px"></li>
</ul>