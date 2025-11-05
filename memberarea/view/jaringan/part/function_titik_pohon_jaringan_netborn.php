<?php

require_once '../model/classMember.php';
require_once '../model/classPlan.php';
require_once '../model/classProdukJenis.php';
require_once '../model/classBonusRewardPaket.php';

function titik($id, $upline, $action, $next = '0', $_binary = true)
{

    $cpl = new classPlan();
    $cpj = new classProdukJenis();
    $cm = new classMember();
    $info_ro = $cm->info_ro($id, 14);
    if($info_ro->total > 0){
        $jumlah_ro = '<span class="size-10 text-dark fw-bold">Jumlah RO Aktif : '.$info_ro->total.'</span>';
        $tgl_ro = '<span class="size-10 text-dark fw-bold">'.tgl_indo($info_ro->created_at).'</span>';
    } else {
        $jumlah_ro = '<span class="size-10 text-gray fw-bold">Belum RO Aktif</span>';
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
            // $link = '<span class="p-1 text-danger"><i class="fa fa-times-circle fa-6x"></i></span>';
            $link = '<a href="#" class="btn text-white p-0"><img src="../images/plan/lock.png" alt="" width="100%"></a>';
            $bgcolor = 'lock';
        } else {
            // $link = '<a href="?go=member_create&upline='.base64_encode($upline).'" class="p-1 text-success"><i class="fa fa-plus-circle fa-6x"></i></a>';
            $link = '<a href="?go=member_create&upline=' . base64_encode($upline) . '&posisi=' . $action . '" class="btn text-white p-0"><img src="../images/plan/join.png" alt="" width="100%"></a>';
            $bgcolor = 'join';
        }


        global $upline;
        $upline[$next][1] = null;
        $upline[$next][2] = null;

        global $action;
        $action[$next][1] = false;
        $action[$next][2] = false;
?>
        <div class="card-member member-blank bg-transparent">
            <?= $link ?>
        </div>
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
        // $action[$next][2] = 'kanan';
        $nama_samaran = $member->nama_samaran == '' ? 'Undefined' : strtoupper($member->nama_samaran);
        $user_member = $member->user_member == '' ? 'Undefined' : strtoupper($member->user_member);
        $total_pasangan_rekap = 0;
        $total_flash_in = 0;
        $reposisi = '';
        if ($member->reposisi == 0) {
            $reposisi = '<span class="size-12 bg-white rounded-pill px-4">A</span>';
        } else {
            $reposisi = '<span class="size-12 bg-warning rounded-pill px-4">R</span>';
        }
        // $sponsori = $cm->sponsori($member->id);
        // if($sponsori >= 1){
        //     $reposisi = '<span class="size-11 bg-success rounded-pill text-white">Sudah Sponsori</span>';
        //     $action[$next][2] = $member->kaki_kiri == '' ? false:'kanan';
        // } else {
        //     $reposisi = '<span class="size-11 bg-danger rounded-pill text-white">Belum Sponsori</span>';
        //     $action[$next][2] = false;
        // }
    ?>

        <div class="card-member bgcolor-<?= $member->bg_color ?>">
            <a href="?go=genealogy_netborn&id_member=<?= $member->id_member ?>"><img src="../images/plan/<?= $member->icon_plan ?>" alt="" width="100%"></a>
            <div class="card-member-body">
                <div class="member-profile">
                    <?php
                    // echo $reposisi
                    $root_level = $cm->detail($_SESSION['session_member_id']);
                    ?>
                    
                    <p class="plan-member fw-bold mt-2 mb-2">Level <?= $member->level-$root_level->level ?></p>
                    <p class="plan-member fw-bold mt-2 mb-2"><?= $member->nama_plan ?> <?= $member->short_name ?></p>
                    <h3><?= $member->id_member ?></h3>
                    <h3><?= $member->user_member ?></h3>
                    <!-- <h3 class="fw-bold"><?= $nama_samaran ?></h3> -->
                    <h5 data-toggle="tooltip" data-placement="top" title="Tanggal Gabung"><?= date('d/m/Y', strtotime($member->created_at)) ?></h5>
                </div>
                <div class="member-info">
                    <span><?= currency($member->jumlah_kiri) ?></span>
                    <span data-toggle="tooltip" data-placement="top" title="Jumlah Member"><i class="fas fa-users-class"></i></span>
                    <span><?= currency($member->jumlah_kanan) ?></span>
                </div>
                <?php if ($_binary == true) {
                    $poin_pasangan = $cm->total_poin_pasangan($id,15);
                ?>
                
                <div class="member-info">
                    <span><?= currency($poin_pasangan->jumlah_kiri) ?></span>
                    <span data-toggle="tooltip" data-placement="top" title="Total Poin Pasangan NetReborn"><i class="fas fa-a"></i></span>
                    <span><?= currency($poin_pasangan->jumlah_kanan) ?></span>
                </div>
                <?php

                    $poin_pasangan = $cm->jumlah_poin_pasangan($id, 15);
                ?>
                <div class="member-info">
                    <span><?= currency($poin_pasangan->potensi_kiri) ?></span>
                    <span data-toggle="tooltip" data-placement="top" title="Poin Pasangan NetReborn"><i class="fas fa-people-arrows"></i></span>
                    <span><?= currency($poin_pasangan->potensi_kanan) ?></span>
                </div>
                <?php
                }
                ?>
                <?php if ($_binary == true) {
                    $poin_reward = $cm->jumlah_poin_reward($id, 15);
                ?>
                    <div class="member-info">
                        <span><?= $poin_reward->reward_kiri ?></span>
                        <span data-toggle="tooltip" data-placement="top" title="Poin Reward NetReborn"><i class="fas fa-award"></i></span>
                        <span><?= $poin_reward->reward_kanan ?></span>
                    </div>
                <?php
                }
                ?>
                <div class="member-profile px-1">
                    <br>
                    <?=$jumlah_ro?><br>
                    <?=$tgl_ro?><br>
                    <a href="<?= site_url('posting_ro') ?>&id_member=<?= base64_encode($member->id) ?>" class="btn btn-sm btn-dark size-12 rounded-pill mt-2">Posting RO</a>
                </div>
                <div class="member-profile">
                    <h3 class="member-rank"></h3>
                </div>
            </div>
        </div>
<?php
    }
}
?>