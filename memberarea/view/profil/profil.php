<?php 
    require_once '../model/classMember.php';
    require_once '../model/classProdukJenis.php';

    $c = new classMember();
    $cpj = new classProdukJenis();

    $member = $c->detail($session_member_id);
    $multiplication = $cpj->multiplication($member->id_produk_jenis);
?>
<?php include 'view/layout/header.php'; ?>
    <!-- loader section -->
    <?php include 'view/layout/loader.php'; ?>
    <!-- loader section ends -->


    <!-- Sidebar main menu -->
    <?php include 'view/layout/sidebar.php'; ?>

    <!-- Sidebar main menu ends -->

    <!-- Begin page -->
    <main class="h-100 has-header">
        <!-- Header -->
        <header class="header position-fixed bg-theme">
            <div class="row">
                <?php include 'view/layout/back.php'; ?>
                <div class="col align-self-center text-left pt-1 ps-0">
                    <h5><?=$title?></h5>
                </div>
            </div>
        </header>      
        <!-- Header ends -->

        <!-- main page content -->
        <div class="main-container container pt-4 pb-4">
            
            <!-- user information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <div class="rounded-2">
                                <img src="../images/plan/<?=$member->icon_plan?>" alt="" width="60">
                            </div>
                        </div>
                        <div class="col px-0 align-self-center">
                            <h3 class="mb-0 text-color-theme size-18"><?=$member->nama_member?></h3>
                            <p class="mb-0 text-color-theme"><?=$member->id_member?></p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted">Tanggal Bergabung</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme"><?=tgl_indo($member->created_at)?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted">Paket Join</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme"><?=$member->nama_plan?> <?=$member->short_name?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted">Nama Samaran</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme"><?=$member->nama_samaran?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted">No. Handphone</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme"><?=$member->hp_member?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted"><?=$lang['sponsor']?></p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme"><?=$member->sponsor == 'master' ? 'Master' : $member->nama_sponsor .' ('.$member->id_sponsor.')'?></p>
                        </div>
                    </div>
                    <?php
                    if($_binary == true){
                        ?>
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted">Upline</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme"><?=$member->upline == 'master' ? 'Master' : $member->nama_upline .' ('.$member->id_upline.')'?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted">Max Pasangan</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme"><?=currency($member->max_pasangan*$multiplication)?>/hari</p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Data Diri</h6>
                </div>
                <div class="col-auto align-self-center text-end">
                    <a href="?go=change_tgl_lahir" class="text-normal d-block size-12"><i class="fa-solid fa-edit"></i> Edit</a>
                </div>
            </div>
            <div class="card shadow-sm pt-2 mb-4">
                <div class="card-body">
                    <!-- <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">NIK</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme"><?=$member->no_ktp_member?></p>
                       </div>
                    </div> -->
                    <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">Nama Lengkap</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme"><?=$member->nama_member?></p>
                       </div>
                    </div>
                    <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">Tempat, Tanggal Lahir</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme"><?=$member->tempat_lahir_member?>, <?=tgl_indo($member->tgl_lahir_member)?></p>
                       </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Data Rekening</h6>
                </div>
                <!-- <div class="col-auto align-self-center text-end">
                    <a href="?go=ubah_rekening" class="text-normal d-block size-12"><i class="fa-solid fa-edit"></i> Edit</a>
                </div> -->
            </div>
            <div class="card shadow-sm pt-2 mb-4">
                <div class="card-body">
                    <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">BANK</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme"><?=$member->nama_bank?></p>
                       </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="text-muted">No Rekening</p>
                        </div>
                        <div class="col-12">
                            <p class="text-color-theme"><?=$member->no_rekening?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">Cabang/Unit</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme"><?=$member->cabang_rekening?></p>
                       </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Alamat</h6>
                </div>
                <div class="col-auto align-self-center text-end">
                    <a href="?go=ubah_alamat" class="text-normal d-block size-12"><i class="fa-solid fa-edit"></i> Edit</a>
                </div>
            </div>
            <div class="card shadow-sm pt-2 mb-4">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="text-muted">Provinsi</p>
                        </div>
                        <div class="col-12">
                            <p class="text-color-theme"><?=$member->nama_provinsi?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">Kab/Kota</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme"><?=$member->nama_kota?></p>
                       </div>
                    </div>
                    <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">Kecamatan</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme"><?=$member->nama_kecamatan?></p>
                       </div>
                    </div>
                    <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">Kelurahan</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme"><?=$member->nama_kelurahan?></p>
                       </div>
                    </div>
                    <div class="row mb-3">
                       <div class="col-12">
                           <p class="text-muted">Alamat</p>
                       </div>
                       <div class="col-12">
                           <p class="text-color-theme mb-0"><?=$member->alamat_member?></p>
                       </div>
                    </div>
                </div>
            </div>
            <!-- list pages -->
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Keamanan</h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="card shadow-sm mb-4">
                        <ul class="list-group list-group-flush bg-none">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto"><a href="?go=change_username" class="text-normal d-block"><i class="fa-solid fa-clipboard-user"></i> Update Username</a></div>
                                    <div class="col text-end"><span class="small text-color-theme pull-right"><?=$member->user_member?></span></div>
                                </div>
                            </li>
                            <?php 
                                if($member->profile_updated == '0'){ 
                            ?>
                            <li class="list-group-item">
                                <a href="?go=change_profil" class="text-normal d-block"><i class="fa-solid fa-user-edit"></i> Update Profil</a>
                            </li>
                            <?php 
                                } 
                            ?>
                            <li class="list-group-item">
                                <a href="?go=change_password" class="text-normal d-block"><i class="fa-solid fa-lock-alt"></i> Update Password</a>
                            </li>
                            <li class="list-group-item">
                                <a href="?go=change_pin" class="text-normal d-block"><i class="fa-solid fa-key"></i> Update PIN</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Tentang</h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="card shadow-sm mb-4">
                        <ul class="list-group list-group-flush bg-none">
                            <li class="list-group-item">
                                <a href="#" class="text-normal d-block"><i class="fas fa-list-alt"></i> Syarat Ketentuan</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-normal d-block"><i class="fas fa-shield-check"></i> Kebijakan Privasi</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-normal d-block"><i class="fas fa-question-circle"></i> Pusat Bantuan</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col d-grid mb-4">
                    <a href="logout.php" class="btn btn-default btn-sm shadow-sm py-3 rounded-pill">LOGOUT</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- main page content ends -->
    </main>
    <!-- Page ends-->
    <?php include 'view/layout/nav-bottom.php'; ?>
    <?php include 'view/layout/assets_js.php'; ?>
    <?php include 'view/layout/footer.php'; ?>