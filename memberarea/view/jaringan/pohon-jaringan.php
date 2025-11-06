<?php
$node = array();
$action = array();
$upline = array();
?>
<?php

require_once '../model/classMember.php';
require_once '../model/classPlan.php';
require_once '../model/classProdukJenis.php';
require_once '../model/classBonusRewardPaket.php';

function titik($id, $upline, $action, $next = '0', $_binary = true)
{
    $cpl = new classPlan();
    $cpj = new classProdukJenis();
    $cbrp = new classBonusRewardPaket();
    $cm = new classMember();
    $plan_pasangan = $cpl->plan_pasangan();
    $plan_reward = $cpl->plan_reward();
    $plan_reward_paket = $cpj->plan_reward();
    $info_ro = $cm->info_ro($id, 14);
    
    if ($info_ro->total > 0) {
        $jumlah_ro = '<span class="badge-info">RO Aktif: ' . $info_ro->total . '</span>';
        $tgl_ro = '<span class="badge-date">' . tgl_indo($info_ro->created_at) . '</span>';
    } else {
        $jumlah_ro = '<span class="badge-info inactive">Belum RO</span>';
        $tgl_ro = '';
    }
    
    if ($id == null) {
        $member = null;
    } else {
        $member = $cm->genealogy($id);
        if ($member) {
            $member = $cm->detail($member->id);
        } else {
            $member = null;
        }
    }

    if ($member == null) {
        global $node;
        $node[$next][1] = null;
        $node[$next][2] = null;

        if ($action == false) {
            $link = '<div class="empty-slot locked"><i class="fas fa-lock"></i><span>Terkunci</span></div>';
        } else {
            $link = '<a href="?go=member_create&upline=' . base64_encode($upline) . '&posisi=' . $action . '" class="empty-slot available"><i class="fas fa-plus-circle"></i><span>Daftar</span></a>';
        }

        global $upline;
        $upline[$next][1] = null;
        $upline[$next][2] = null;

        global $action;
        $action[$next][1] = false;
        $action[$next][2] = false;
?>
        <?= $link ?>
    <?php
    } else {
        global $node;
        $node[$next][1] = $member->kaki_kiri == '' ? null : $member->kaki_kiri;
        $node[$next][2] = $member->kaki_kanan == '' ? null : $member->kaki_kanan;

        global $upline;
        $upline[$next][1] = $member->id;
        $upline[$next][2] = $member->id;

        global $action;
        $action[$next][1] = 'kiri';
        $action[$next][2] = $member->kaki_kiri == '' ? false : 'kanan';
        
        $show_modul = $member->id_plan < 200;
    ?>
        <div class="member-card">
            <div class="card-header">
                <div class="member-avatar">
                    <img src="../images/plan/<?= $member->icon_plan ?>" alt="<?= $member->nama_plan ?>">
                </div>
                <div class="member-status">
                    <?php
                    $root_level = $cm->detail($_SESSION['session_member_id']);
                    ?>
                    <span class="level-badge">Level <?= $member->level - $root_level->level ?></span>
                    <span class="plan-badge"><?= $member->nama_plan ?> <?= $member->short_name ?></span>
                </div>
            </div>
            
            <div class="card-body">
                <h4 class="member-id"><?= $member->id_member ?></h4>
                <h5 class="member-name"><?= $member->user_member ?></h5>
                <p class="join-date"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($member->created_at)) ?></p>
                
                <div class="stats-container">
                    <div class="stat-item">
                        <span class="stat-value"><?= currency($member->jumlah_kiri) ?></span>
                        <span class="stat-label"><i class="fas fa-users"></i> Kiri</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="stat-value"><?= currency($member->jumlah_kanan) ?></span>
                        <span class="stat-label"><i class="fas fa-users"></i> Kanan</span>
                    </div>
                </div>

                <?php if ($_binary == true) {
                    while ($row = $plan_pasangan->fetch_object()) {
                        $poin_pasangan = $cm->total_poin_pasangan($id, $row->id);
                        $show_pasangan = $row->id >= 200 || $show_modul;
                        
                        if ($show_pasangan) {
                ?>
                    <div class="poin-row">
                        <span class="poin-left"><?= currency($poin_pasangan->jumlah_kiri) ?></span>
                        <span class="poin-label"><i class="fas fa-chart-line"></i><br><?= $row->show_name ? $row->show_name : 'Pasangan' ?></span>
                        <span class="poin-right"><?= currency($poin_pasangan->jumlah_kanan) ?></span>
                    </div>
                <?php
                        }
                    }
                } ?>

                <?php if ($_binary == true && $show_modul) {
                    while ($row = $plan_reward->fetch_object()) {
                        $kondisi = false;
                        if ($row->reward_wajib_ro == 1) {
                            $jumlah_poin_ro = $cm->jumlah_poin_ro($member->id, $row->id);
                            if ($jumlah_poin_ro > 0) {
                                $kondisi = true;
                            } else {
                                $kondisi = false;
                            }
                        } else {
                            $kondisi = true;
                        }
                        if ($kondisi == true) {
                            $poin_reward = $cm->jumlah_poin_reward($id, $row->id);
                ?>
                            <div class="poin-row">
                                <span class="poin-left"><?= $poin_reward->reward_kiri ?></span>
                                <span class="poin-label" data-toggle="tooltip" data-placement="top" title="Poin Reward <?= $row->nama_reward ?>"><i class="fas fa-<?= $row->icon_reward ?>"></i><br><?= $row->nama_reward ?></span>
                                <span class="poin-right"><?= $poin_reward->reward_kanan ?></span>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="poin-row" style="opacity: 0.5;">
                                <span class="poin-left">0</span>
                                <span class="poin-label" data-toggle="tooltip" data-placement="top" title="Poin Reward <?= $row->nama_reward ?> Terkunci"><i class="fas fa-lock"></i><br><?= $row->nama_reward ?></span>
                                <span class="poin-right">0</span>
                            </div>
                <?php
                        }
                    }
                }
                ?>
                <?php if ($_binary == true && $show_modul) {
                    while ($row = $plan_reward_paket->fetch_object()) {
                        $poin_reward = $cbrp->jumlah_poin_reward($id, $row->id);
                ?>
                        <div class="poin-row">
                            <span class="poin-left"><?= $poin_reward->reward_kiri ?></span>
                            <span class="poin-label" data-toggle="tooltip" data-placement="top" title="Poin Reward <?= $row->nama_reward ?>"><i class="fas fa-<?= $row->icon_reward ?>"></i><br><?= $row->nama_reward ?></span>
                            <span class="poin-right"><?= $poin_reward->reward_kanan ?></span>
                        </div>
                <?php
                    }
                }
                ?>
                <?php if ($show_modul) { ?>
                <div class="ro-info">
                    <?= $jumlah_ro ?>
                    <?= $tgl_ro ?>
                </div>
                <?php } ?>
                
                <div class="card-actions">
                    <a href="?go=genealogy_v1&id_member=<?= $member->id_member ?>" class="btn-action primary">
                        <i class="fas fa-sitemap"></i> Lihat Jaringan
                    </a>
                    <a href="<?= site_url('posting_ro') ?>&id_member=<?= base64_encode($member->id) ?>" class="btn-action secondary">
                        <i class="fas fa-plus-circle"></i> Posting RO
                    </a>
                </div>
            </div>
        </div>
<?php
    }
}

$upline_root = null;
$id_member = $session_member_id;
$cm = new classMember();
if (isset($_GET['id_member'])) {
    $id = $_GET['id_member'];
    $member = $cm->genealogy($id, $session_member_id);
    if (!empty($member)) {
        $id_member = $member->id;
        if ($member->id <> $session_member_id) {
            $upline_id = $member->upline;
            $upline_root = $cm->detail($upline_id)->id_member;
        }
        if (!$cm->cek_upline($id_member, $session_member_id)) {
            $id_member = $session_member_id;
        }
    }
}

$member = $cm->detail($id_member);
if($member && $id_member <> $session_member_id){
    $member_search = $_GET['id_member'];
} else {
    $member_search = '';
    $id_member = $session_member_id;
}
?>
<?php include 'view/layout/header.php'; ?>

<style>

    /* Search Container */
    .search-wrapper {
        max-width: 600px;
        margin: 80px auto 30px;
        padding: 0 20px;
    }
    
    .search-box {
        background: linear-gradient(145deg, #1a1a1a, #252525);
        border: 2px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 32px rgba(212, 175, 55, 0.1);
        transform: translateY(-10px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .search-box.active {
        transform: translateY(0);
        opacity: 1;
    }
    
    .search-form {
        display: flex;
        gap: 12px;
    }
    
    .search-input {
        flex: 1;
        background: var(--black);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 14px 20px;
        color: var(--white);
        font-size: 15px;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
    }
    
    .search-btn {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        color: var(--black);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
    }

    /* Network Tree */
    .tree-container {
        padding: 40px 20px;
        overflow-x: auto;
    }
    
    .tree {
        display: flex;
        justify-content: center;
        padding: 20px;
        list-style: none;
        position: relative;
    }
    
    .tree ul {
        padding-top: 40px;
        position: relative;
        display: flex;
        gap: 60px;
        justify-content: center;
        list-style: none;
    }
    
    .tree li {
        position: relative;
        padding: 20px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    /* Tree Connectors */
    .tree li::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid var(--gold);
        width: 0;
        height: 20px;
        margin-left: -1px;
    }
    
    .tree li::after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-top: 2px solid var(--gold);
        width: 95%;
        height: 20px;
        margin-left: -1px;
    }
    
    .tree li:first-child::after {
        left: 50%;
        border-left: 2px solid var(--gold);
        margin-left: -1px;
    }
    
    .tree li:last-child::after {
        border-right: 2px solid var(--gold);
        right: 50%;
        left: auto;
        margin-right: -1px;
        margin-left: 0;
    }
    
    .tree li:only-child::after {
        display: none;
    }
    
    .tree > li::before {
        display: none;
    }
    
    .tree ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid var(--gold);
        width: 0;
        height: 40px;
        margin-left: -1px;
    }

    /* Member Card */
    .member-card {
        width: 280px;
        background: linear-gradient(145deg, #1a1a1a, #252525);
        border: 2px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        position: relative;
    }
    
    .member-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
    }
    
    .member-card:hover {
        transform: translateY(-8px);
        border-color: var(--gold);
        box-shadow: 0 20px 60px rgba(212, 175, 55, 0.3);
    }
    
    .card-header {
        padding: 24px 20px 16px;
        text-align: center;
        background: linear-gradient(180deg, rgba(212, 175, 55, 0.1), transparent);
    }
    
    .member-avatar {
        width: 80px;
        height: 80px;
        margin: 0 auto 16px;
        border-radius: 50%;
        border: 3px solid var(--gold);
        padding: 4px;
        background: var(--black);
    }
    
    .member-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    
    .member-status {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .level-badge, .plan-badge {
        background: var(--black);
        border: 1px solid var(--gold);
        color: var(--gold);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .member-id {
        color: var(--gold);
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 6px;
        text-align: center;
    }
    
    .member-name {
        color: var(--white);
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 8px;
        text-align: center;
    }
    
    .join-date {
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        margin: 0 0 16px;
    }
    
    .stats-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--black);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
    }
    
    .stat-item {
        flex: 1;
        text-align: center;
    }
    
    .stat-value {
        display: block;
        color: var(--gold);
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    
    .stat-label {
        display: block;
        color: var(--gray);
        font-size: 11px;
        text-transform: uppercase;
    }
    
    .stat-divider {
        width: 1px;
        height: 40px;
        background: var(--border);
    }
    
    .poin-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        background: rgba(212, 175, 55, 0.05);
        border-radius: 8px;
        margin-bottom: 8px;
        font-size: 13px;
    }
    
    .poin-left, .poin-right {
        color: var(--gold);
        font-weight: 600;
        min-width: 50px;
        text-align: center;
    }
    
    .poin-label {
        color: var(--white);
        font-size: 12px;
        text-align: center;
    }
    
    .ro-info {
        text-align: center;
        padding: 12px;
        background: var(--black);
        border-radius: 8px;
        margin: 16px 0;
    }
    
    .badge-info {
        display: inline-block;
        background: var(--gold);
        color: var(--black);
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        margin: 4px;
    }
    
    .badge-info.inactive {
        background: var(--gray);
    }
    
    .badge-date {
        display: block;
        color: var(--gray);
        font-size: 11px;
        margin-top: 4px;
    }
    
    .card-actions {
        display: flex;
        gap: 8px;
        margin-top: 16px;
    }
    
    .btn-action {
        flex: 1;
        padding: 10px 16px;
        border-radius: 10px;
        text-align: center;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    
    .btn-action.primary {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--black);
    }
    
    .btn-action.secondary {
        background: var(--black);
        color: var(--gold);
        border: 1px solid var(--gold);
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    /* Empty Slots */
    .empty-slot {
        width: 240px;
        height: 200px;
        border: 2px dashed var(--border);
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .empty-slot i {
        font-size: 40px;
        color: var(--gray);
    }
    
    .empty-slot span {
        color: var(--gray);
        font-size: 14px;
        font-weight: 600;
    }
    
    .empty-slot.available {
        cursor: pointer;
    }
    
    .empty-slot.available:hover {
        border-color: var(--gold);
        background: rgba(212, 175, 55, 0.05);
    }
    
    .empty-slot.available:hover i,
    .empty-slot.available:hover span {
        color: var(--gold);
    }
    
    .empty-slot.locked {
        opacity: 0.4;
    }

    /* Upline Button */
    .upline-btn {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--black);
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .upline-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        color: var(--black);
        text-decoration: none;
    }

    /* Main Container */
    main {
        background: radial-gradient(ellipse at center, #1a1a1a 0%, #0a0a0a 100%);
    }

    @media (min-width: 1200px) {
        .container, .container-sm, .container-md, .container-lg, .container-xl {
            max-width: 100%;
        }
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .search-wrapper {
            margin: 70px auto 20px;
            padding: 0 15px;
        }
        
        .search-box {
            padding: 15px;
        }
        
        .search-form {
            flex-direction: column;
            gap: 10px;
        }
        
        .search-input {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
        }
        
        .search-btn {
            width: 100%;
            padding: 12px 20px;
            justify-content: center;
        }

        /* Tree adjustments for mobile */
        .tree-container {
            padding: 20px 10px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .tree {
            padding: 10px;
            min-width: max-content;
        }
        
        .tree ul {
            gap: 30px;
            padding-top: 30px;
        }
        
        .tree li {
            padding: 15px 0;
        }

        /* Member Card Mobile */
        .member-card {
            width: 200px;
        }
        
        .card-header {
            padding: 16px 12px 12px;
        }
        
        .member-avatar {
            width: 60px;
            height: 60px;
            margin-bottom: 12px;
        }
        
        .level-badge, .plan-badge {
            font-size: 10px;
            padding: 3px 10px;
        }
        
        .card-body {
            padding: 15px 12px;
        }
        
        .member-id {
            font-size: 15px;
        }
        
        .member-name {
            font-size: 14px;
        }
        
        .join-date {
            font-size: 11px;
            margin-bottom: 12px;
        }
        
        .stats-container {
            padding: 12px;
            margin-bottom: 12px;
        }
        
        .stat-value {
            font-size: 15px;
        }
        
        .stat-label {
            font-size: 10px;
        }
        
        .stat-divider {
            height: 30px;
        }
        
        .poin-row {
            padding: 8px 10px;
            font-size: 12px;
            margin-bottom: 6px;
        }
        
        .poin-left, .poin-right {
            min-width: 40px;
            font-size: 12px;
        }
        
        .poin-label {
            font-size: 11px;
        }
        
        .ro-info {
            padding: 10px;
            margin: 12px 0;
        }
        
        .badge-info {
            font-size: 10px;
            padding: 3px 10px;
        }
        
        .card-actions {
            flex-direction: column;
            gap: 6px;
            margin-top: 12px;
        }
        
        .btn-action {
            width: 100%;
            padding: 10px 12px;
            font-size: 11px;
        }
        
        .btn-action i {
            font-size: 12px;
        }

        /* Empty Slot Mobile */
        .empty-slot {
            width: 200px;
            height: 160px;
        }
        
        .empty-slot i {
            font-size: 32px;
        }
        
        .empty-slot span {
            font-size: 12px;
        }

        /* Upline Button Mobile */
        .upline-btn {
            padding: 10px 20px;
            font-size: 13px;
        }
        .tree ul::before {
            height: 32px;
        }
        .tree li::before {
            height: 15px;
        }
        .tree li::after {
            height: 15px;
            width: 100%;
        }
    }

    /* Extra Small Mobile */
    @media (max-width: 480px) {
        .member-card {
            width: 180px;
        }
        
        .member-avatar {
            width: 50px;
            height: 50px;
        }
        
        .empty-slot {
            width: 180px;
            height: 140px;
        }
        
        .tree ul {
            gap: 20px;
        }
        
        .card-actions {
            gap: 5px;
        }
        
        .btn-action {
            font-size: 10px;
            padding: 8px 10px;
            gap: 4px;
        }
    }
</style>

<?php include 'view/layout/sidebar.php'; ?>

<main class="h-100 has-header">
    <header class="header position-fixed" style="background: var(--dark); border-bottom: 1px solid var(--border);">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5 style="color: var(--gold);"><?= $title ?></h5>
                <div style="font-size:12px; color: var(--gray);">Jaringan Binary</div>
            </div>
            <div class="col-auto align-self-center">
                <button type="button" class="btn btn-sm" style="background: var(--gold); color: var(--black);" id="btnSearch">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="search-wrapper" id="searchWrapper" style="<?= $member_search == '' ? 'display: none;' : '' ?>">
        <div class="search-box active">
            <form class="search-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <input type="hidden" name="go" value="genealogy_v1">
                <input type="text" class="search-input" name="id_member" value="<?= $member_search ?>" placeholder="Masukkan ID Member...">
                <button class="search-btn" type="submit">
                    <i class="fa fa-search"></i>
                    <span>Cari</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-container container">
        <?php if ($upline_root !== null): ?>
        <div class="text-center mb-4">
            <a href="?go=genealogy_v1&id_member=<?= $upline_root ?>" class="upline-btn">
                <i class="fa fa-arrow-up"></i>
                <span>Lihat Upline</span>
            </a>
        </div>
        <?php endif; ?>

        <div class="tree-container">
            <ul class="tree">
                <li>
                    <?php titik($id_member, $upline_root, true, 1); ?>
                    <ul>
                        <li>
                            <?php titik($node[1][1], $upline[1][1], $action[1][1], 2); ?>
                            <ul>
                                <li><?php titik($node[2][1], $upline[2][1], $action[2][1], 3); ?></li>
                                <li><?php titik($node[2][2], $upline[2][2], $action[2][2], 3); ?></li>
                            </ul>
                        </li>
                        <li>
                            <?php titik($node[1][2], $upline[1][2], $action[1][2], 2); ?>
                            <ul>
                                <li><?php titik($node[2][1], $upline[2][1], $action[2][1], 3); ?></li>
                                <li><?php titik($node[2][2], $upline[2][2], $action[2][2], 3); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <?php include 'view/layout/nav-bottom.php'; ?>
</main>

<?php include 'view/layout/assets_js.php'; ?>
<script>
$(document).ready(function() {
    $('#btnSearch').click(function() {
        var $searchWrapper = $('#searchWrapper');
        var $searchBox = $('.search-box');
        
        if ($searchWrapper.is(':visible')) {
            $searchBox.removeClass('active');
            setTimeout(function() {
                $searchWrapper.hide();
            }, 400);
        } else {
            $searchWrapper.show();
            setTimeout(function() {
                $searchBox.addClass('active');
                $('.search-input').focus();
            }, 10);
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<?php include 'view/layout/footer.php'; ?>