<?php 
    require_once '../model/classMember.php';
    require_once '../model/classProdukJenis.php';

    $c = new classMember();
    $cpj = new classProdukJenis();

    $member = $c->detail($session_member_id);
    $multiplication = $cpj->multiplication($member->id_produk_jenis);
?>
<?php include 'view/layout/header.php'; ?>
<style>
    :root {
        --gold: #D4AF37;
        --dark: #1a1a1a;
        --light-bg: #f8f9fa;
    }
    
    .profile-header {
        background: linear-gradient(135deg, var(--dark) 0%, #2d2d2d 100%);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.15);
        animation: slideDown 0.5s ease;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        border: 3px solid var(--gold);
        border-radius: 15px;
        padding: 8px;
        background: white;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        transition: transform 0.3s ease;
    }
    
    .profile-avatar:hover {
        transform: scale(1.05) rotate(2deg);
    }
    
    .section-title {
        color: var(--gold);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 15px;
        position: relative;
        padding-left: 15px;
        animation: fadeIn 0.6s ease;
    }
    
    .section-title:before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 20px;
        background: linear-gradient(180deg, var(--gold) 0%, #f4d03f 100%);
        border-radius: 2px;
    }
    
    .modern-card {
        background: white;
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease;
    }
    
    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.2);
    }
    
    .info-row {
        padding: 15px 20px;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s ease;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-row:hover {
        background: linear-gradient(90deg, transparent 0%, rgba(212, 175, 55, 0.05) 100%);
    }
    
    .info-label {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .info-value {
        color: var(--dark);
        font-weight: 600;
        font-size: 0.95rem;
        margin: 0;
    }
    
    .edit-btn {
        color: var(--gold);
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .edit-btn:hover {
        color: #f4d03f;
        transform: translateX(3px);
    }
    
    .security-item {
        padding: 18px 20px;
        border: none;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        background: white;
    }
    
    .security-item:hover {
        background: linear-gradient(90deg, rgba(212, 175, 55, 0.05) 0%, transparent 100%);
        transform: translateX(5px);
    }
    
    .security-item a {
        color: var(--dark);
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .security-item i {
        color: var(--gold);
        font-size: 1.2rem;
        width: 25px;
    }
    
    .logout-btn {
        background: linear-gradient(135deg, var(--dark) 0%, #2d2d2d 100%);
        color: var(--gold);
        border: 2px solid var(--gold);
        font-weight: 700;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
    }
    
    .logout-btn:hover {
        background: var(--gold);
        color: var(--dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
    }
    
    .badge-gold {
        background: linear-gradient(135deg, var(--gold) 0%, #f4d03f 100%);
        color: var(--dark);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @media (max-width: 576px) {
        .profile-header {
            padding: 20px 15px;
        }
        
        .profile-avatar {
            width: 60px;
            height: 60px;
        }
        
        .section-title {
            font-size: 1rem;
        }
        
        .info-row {
            padding: 12px 15px;
        }
        
        .modern-card {
            margin-bottom: 15px;
        }
    }
</style>

    <!-- loader section -->
    <?php include 'view/layout/loader.php'; ?>
    <!-- loader section ends -->

    <!-- Sidebar main menu -->
    <?php include 'view/layout/sidebar.php'; ?>

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
            
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="../images/plan/<?=$member->icon_plan?>" alt="" class="profile-avatar">
                    </div>
                    <div class="col px-3">
                        <h5 class="mb-0 text-white fw-bold"><?=$member->nama_member?></h5>
                        <p class="mb-2 text-white-50 small"><?=$member->id_member?></p>
                        <span class="badge-gold mt-2"><?=$member->nama_plan?> <?=$member->short_name?></span>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <h6 class="section-title">Informasi Akun</h6>
            <div class="modern-card">
                <div class="info-row">
                    <div class="row">
                        <div class="col-7 col-sm-8">
                            <p class="info-label">Tanggal Bergabung</p>
                            <p class="info-value"><?=tgl_indo($member->created_at)?></p>
                        </div>
                        <div class="col-5 col-sm-4 text-end align-self-center">
                            <i class="fa-solid fa-calendar-check" style="color: var(--gold); font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="info-row">
                    <p class="info-label">Nama Samaran</p>
                    <p class="info-value"><?=$member->nama_samaran?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">No. Handphone</p>
                    <p class="info-value"><?=$member->hp_member?></p>
                </div>
                <div class="info-row">
                    <p class="info-label"><?=$lang['sponsor']?></p>
                    <p class="info-value"><?=$member->sponsor == 'master' ? 'Master' : $member->nama_sponsor .' ('.$member->id_sponsor.')'?></p>
                </div>
                <?php if($_binary == true){ ?>
                <div class="info-row">
                    <p class="info-label">Upline</p>
                    <p class="info-value"><?=$member->upline == 'master' ? 'Master' : $member->nama_upline .' ('.$member->id_upline.')'?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">Max Pasangan</p>
                    <p class="info-value"><?=currency($member->max_pasangan*$multiplication)?>/hari</p>
                </div>
                <?php } ?>
            </div>

            <!-- Personal Data -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="section-title mb-0">Data Diri</h6>
                <a href="?go=change_tgl_lahir" class="edit-btn">
                    <i class="fa-solid fa-edit"></i> Edit
                </a>
            </div>
            <div class="modern-card">
                <div class="info-row">
                    <p class="info-label">Nama Lengkap</p>
                    <p class="info-value"><?=$member->nama_member?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">Tempat, Tanggal Lahir</p>
                    <p class="info-value"><?=$member->tempat_lahir_member?>, <?=tgl_indo($member->tgl_lahir_member)?></p>
                </div>
            </div>

            <!-- Bank Account -->
            <h6 class="section-title">Data Rekening</h6>
            <div class="modern-card">
                <div class="info-row">
                    <p class="info-label">BANK</p>
                    <p class="info-value"><?=$member->nama_bank?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">No Rekening</p>
                    <p class="info-value"><?=$member->no_rekening?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">Cabang/Unit</p>
                    <p class="info-value"><?=$member->cabang_rekening?></p>
                </div>
            </div>

            <!-- Address -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="section-title mb-0">Alamat</h6>
                <a href="?go=ubah_alamat" class="edit-btn">
                    <i class="fa-solid fa-edit"></i> Edit
                </a>
            </div>
            <div class="modern-card">
                <div class="info-row">
                    <p class="info-label">Provinsi</p>
                    <p class="info-value"><?=$member->nama_provinsi?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">Kab/Kota</p>
                    <p class="info-value"><?=$member->nama_kota?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">Kecamatan</p>
                    <p class="info-value"><?=$member->nama_kecamatan?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">Kelurahan</p>
                    <p class="info-value"><?=$member->nama_kelurahan?></p>
                </div>
                <div class="info-row">
                    <p class="info-label">Alamat Lengkap</p>
                    <p class="info-value"><?=$member->alamat_member?></p>
                </div>
            </div>

            <!-- Security -->
            <h6 class="section-title">Keamanan</h6>
            <div class="modern-card">
                <ul class="list-group list-group-flush">
                    <li class="security-item">
                        <div class="row align-items-center">
                            <div class="col">
                                <a href="?go=change_username">
                                    <i class="fa-solid fa-clipboard-user"></i>
                                    <span>Update Username</span>
                                </a>
                            </div>
                            <div class="col-auto">
                                <small class="text-muted"><?=$member->user_member?></small>
                            </div>
                        </div>
                    </li>
                    <?php if($member->profile_updated == '0'){ ?>
                    <li class="security-item">
                        <a href="?go=change_profil">
                            <i class="fa-solid fa-user-edit"></i>
                            <span>Update Profil</span>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="security-item">
                        <a href="?go=change_password">
                            <i class="fa-solid fa-lock-alt"></i>
                            <span>Update Password</span>
                        </a>
                    </li>
                    <li class="security-item">
                        <a href="?go=change_pin">
                            <i class="fa-solid fa-key"></i>
                            <span>Update PIN</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- About -->
            <h6 class="section-title">Tentang</h6>
            <div class="modern-card">
                <ul class="list-group list-group-flush">
                    <li class="security-item">
                        <a href="#">
                            <i class="fas fa-list-alt"></i>
                            <span>Syarat Ketentuan</span>
                        </a>
                    </li>
                    <li class="security-item">
                        <a href="#">
                            <i class="fas fa-shield-check"></i>
                            <span>Kebijakan Privasi</span>
                        </a>
                    </li>
                    <li class="security-item">
                        <a href="#">
                            <i class="fas fa-question-circle"></i>
                            <span>Pusat Bantuan</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Logout Button -->
            <div class="row mt-4">
                <div class="col d-grid mb-4">
                    <a href="logout.php" class="btn logout-btn btn-lg py-3 rounded-pill">
                        <i class="fas fa-sign-out-alt me-2"></i> LOGOUT
                    </a>
                </div>
            </div>
        </div>
        <!-- main page content ends -->
    </main>
    <!-- Page ends-->
    <?php include 'view/layout/nav-bottom.php'; ?>
    <?php include 'view/layout/assets_js.php'; ?>
    <?php include 'view/layout/footer.php'; ?>