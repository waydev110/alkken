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

<?php include 'view/layout/sidebar.php'; ?>

<main class="h-100 has-header genealogy-container">
    <header class="header position-fixed genealogy-header">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?= $title ?></h5>
                <div class="subtitle">Jaringan Binary</div>
            </div>
            <div class="col-auto align-self-center">
                <button type="button" class="btn btn-sm btn-search" id="btnSearch">
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