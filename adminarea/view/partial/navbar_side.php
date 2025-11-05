<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="">
        <a href="index.php"><i class="fad fa-home"></i> <span>Dashboard</span>
        </a>
    </li>
    <?php 
    if($_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
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
    <li class="header">Manage Produk</li>
    <li>
        <a href="?go=produk"><i class="fad fa-box-full"></i> <span>Manage Produk</span></a>
    </li>
    <li>
        <a href="?go=produk_reseller"><i class="fad fa-box-full"></i> <span>Manage Produk Reseller</span></a>
    </li>
    <li class="header">Manage <?=$lang['member']?></li>
    <li class="treeview">
        <a href="#"><i class="fad fa-users"></i> <span>Manage <?=$lang['member']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=member_list"><i class="fa fa-circle-o"></i> Daftar <?=$lang['member']?></a></li>
            <li class=""><a href="?go=member_download"><i class="fa fa-circle-o"></i> Download <?= $lang['member'] ?></a></li>
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
    <li class=""><a href="?go=member_order"><i class="fa fa-circle-o"></i>Member Order</a></li>
    <li class="header">Manage Kode Aktivasi</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-code"></i> <span>Kode Aktivasi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=kodeaktivasi_list"><i class="fa fa-circle-o"></i> Daftar <?=$lang['kode_aktivasi']?></a></li>
            <li class=""><a href="?go=aktivasi_list"><i class="fa fa-circle-o"></i> Riwayat Aktivasi</a></li>
            <li class=""><a href="?go=kodeaktivasi_create"><i class="fa fa-circle-o"></i> Create <?=$lang['kode_aktivasi']?></a></li>
        </ul>
    </li>
    <li class="header">Manage Statistik</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-bar-chart"></i> <span>Statistik</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="?go=omset_bulanan"><i class="fad fa-bar-chart"></i> Omset Bulanan</a></li>
            <li><a href="?go=statistik_harian"><i class="fad fa-bar-chart"></i> Statistik Harian</a></li>
        </ul>
    </li>
    <?php 
    }?>  
    <?php 
    if($_SESSION['level_login'] == '3' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <li class="header">Manage Bonus RO Aktif</li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus RO Aktif</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_ro_aktif_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_ro_aktif_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_ro_aktif_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Net Reborn</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_netborn_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_netborn_limit"><i class="fa fa-circle-o"></i> Saldo Bonus Kurang</a></li>
            <li class=""><a href="?go=bonus_netborn_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_netborn_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
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
            <li class=""><a href="?go=bonus_sponsor_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
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
            <li class=""><a href="?go=bonus_pasangan_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <?php } ?>
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
            <li class=""><a href="?go=bonus_cashback_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <li class="treeview">
    <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_unilevel']?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class=""><a href="?go=bonus_unilevel_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
        <li class=""><a href="?go=bonus_unilevel_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
        <li class=""><a href="?go=bonus_unilevel_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        <li class=""><a href="?go=bonus_unilevel_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
    </ul>
    </li>
    <li class="header">Manage Bonus Net Reborn</li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_sponsor_netborn']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_sponsor_netborn_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_sponsor_netborn_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_sponsor_netborn_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_sponsor_netborn_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_pasangan_netborn']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_pasangan_netborn_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_netborn_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_netborn_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_pasangan_netborn_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i><span>Bonus Pasangan Level</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_pasangan_level_netborn_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_level_netborn_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_pasangan_level_netborn_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_pasangan_level_netborn_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <li class="treeview">
    <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_generasi_netborn']?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class=""><a href="?go=bonus_generasi_netborn_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
        <li class=""><a href="?go=bonus_generasi_netborn_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
        <li class=""><a href="?go=bonus_generasi_netborn_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        <li class=""><a href="?go=bonus_generasi_netborn_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
    </ul>
    </li>
    <li class="treeview">
    <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_titik_netborn']?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class=""><a href="?go=bonus_titik_netborn_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
        <li class=""><a href="?go=bonus_titik_netborn_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
        <li class=""><a href="?go=bonus_titik_netborn_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        <li class=""><a href="?go=bonus_titik_netborn_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
    </ul>
    <li class="treeview">
    <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_balik_modal']?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class=""><a href="?go=bonus_balik_modal_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
        <li class=""><a href="?go=bonus_balik_modal_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
        <li class=""><a href="?go=bonus_balik_modal_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        <li class=""><a href="?go=bonus_balik_modal_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
    </ul>
    </li>
    <li class="header">Manage Bonus RO Aktif</li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_sponsor_ro_aktif']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_sponsor_ro_aktif_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_sponsor_ro_aktif_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_sponsor_ro_aktif_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_sponsor_ro_aktif_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_cashback_ro_aktif']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_cashback_ro_aktif_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_cashback_ro_aktif_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_cashback_ro_aktif_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_cashback_ro_aktif_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <li class="treeview">
    <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_generasi_ro_aktif']?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class=""><a href="?go=bonus_generasi_ro_aktif_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
        <li class=""><a href="?go=bonus_generasi_ro_aktif_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
        <li class=""><a href="?go=bonus_generasi_ro_aktif_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        <li class=""><a href="?go=bonus_generasi_ro_aktif_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
    </ul>
    </li>
    <li class="treeview">
    <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_titik_ro_aktif']?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class=""><a href="?go=bonus_titik_ro_aktif_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
        <li class=""><a href="?go=bonus_titik_ro_aktif_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
        <li class=""><a href="?go=bonus_titik_ro_aktif_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
        <li class=""><a href="?go=bonus_titik_ro_aktif_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
    </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span><?=$lang['bonus_royalti_omset']?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_royalti_omset_list"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_royalti_omset_transfer"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_royalti_omset_laporan"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_royalti_omset_reject_list"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <li class="header">Manage Reward</li>
    <?php
    require_once '../model/classMenu.php';
    $cmenu = new classMenu();
    $_menu_plan_reward = $cmenu->plan_reward();
    while ($row = $_menu_plan_reward->fetch_object()) {
    ?>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Reward <?=$row->nama_reward?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_reward_list&plan_reward=<?=$row->id?>"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_reward_transfer&plan_reward=<?=$row->id?>"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_reward_laporan&plan_reward=<?=$row->id?>"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_reward_reject_list&plan_reward=<?=$row->id?>"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <?php
    }
    ?>
    <li class="header">Manage Reward Pribadi</li>
    <?php
    require_once '../model/classMenu.php';
    $cmenu = new classMenu();
    $_menu_plan_reward_pribadi = $cmenu->plan_reward_pribadi();
    while ($row = $_menu_plan_reward_pribadi->fetch_object()) {
    ?>
    <li class="treeview">
        <a href="#"><i class="fas fa-money-bill"></i> <span>Bonus Reward <?=$row->nama_reward_sponsor?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=bonus_reward_pribadi_list&plan_reward=<?=$row->id?>"><i class="fa fa-circle-o"></i> Daftar Bonus</a></li>
            <li class=""><a href="?go=bonus_reward_pribadi_transfer&plan_reward=<?=$row->id?>"><i class="fa fa-circle-o"></i> Transfer Bonus</a></li>
            <li class=""><a href="?go=bonus_reward_pribadi_laporan&plan_reward=<?=$row->id?>"><i class="fa fa-circle-o"></i> Riwayat Transfer</a></li>
            <li class=""><a href="?go=bonus_reward_pribadi_reject_list&plan_reward=<?=$row->id?>"><i class="fa fa-circle-o"></i> Hidden Bonus</a></li>
        </ul>
    </li>
    <?php
    }
    ?>
    <li class="header">NetSpin</li>
    <li>
        <a href="?go=netspin_setting"><i class="fas fa-money-bill"></i> <span>NetSpin Setting</span></a>
    </li>
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
    </li>
    <li class="header">Manage Autosave</li>
    <li class="treeview">
        <a href="#"><i class="fad fa-store"></i> <span>Klaim Autosave</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=klaim_autosave">Daftar Klaim Produk</a></li>
            <li class=""><a href="?go=riwayat_saldo_autosave">Saldo Autosave</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fad fa-wallet"></i> <span>Saldo Autosave</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=member_autosave">Member Autosave</a></li>
            <li class=""><a href="?go=topup_saldo">Topup Saldo</a></li>
            <li class=""><a href="?go=topup_saldo_laporan">Riwayat Topup Saldo</a></li>
        </ul>
    </li>
    <?php 
    }?>  
    <?php 
    if($_SESSION['level_login'] == '5' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    
    <li class="header">Manage Setting</li>
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
    <li class="treeview">
        <a href="#"><i class="fad fa-box-full"></i> <span>Menu Setting</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="?go=menu_member"><i class="fa fa-circle-o"></i> Menu Member</a></li>
        </ul>
    </li>
    <?php 
    }
    ?>
    <li class="header" style="height:250px"></li>
</ul>