<?php
$node = array();
$action = array();
$upline = array();

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
        $jumlah_ro = '<span class="badge badge-info">RO Aktif: ' . $info_ro->total . '</span>';
        $tgl_ro = '<span class="badge badge-secondary">' . tgl_indo($info_ro->created_at) . '</span>';
    } else {
        $jumlah_ro = '<span class="badge badge-warning">Belum RO</span>';
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
            $link = '<div class="empty-slot locked">
                        <i class="fa fa-lock fa-2x text-muted"></i>
                        <p class="text-muted" style="margin: 8px 0 0 0; font-size: 12px;">Posisi Terkunci</p>
                      </div>';
        } else {
            $link = '<a href="?go=member_register&upline=' . base64_encode($upline) . '&posisi=' . $action . '" class="empty-slot available">
                        <i class="fa fa-plus-circle fa-3x text-success"></i>
                        <p style="margin: 8px 0 0 0; font-size: 12px; font-weight: bold; color: #00a65a;">Daftar Member Baru</p>
                        <small class="text-muted">Klik untuk mendaftar</small>
                     </a>';
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
        <div class="box member-card">
            <div class="box-header with-border" style="background: #3c8dbc; color: #fff; padding: 8px 10px;">
                <div>
                    <img src="../images/plan/<?= $member->icon_plan ?>" alt="<?= $member->nama_plan ?>" 
                         style="width: 60px">
                    <div style="flex: 1; min-width: 0;">
                        <small style="display: block; font-size: 10px; opacity: 0.9;">LEVEL <?= $member->level ?></small>
                        <small style="display: block; font-size: 11px; font-weight: bold;"><?= strtoupper($member->nama_plan) ?></small>
                    </div>
                </div>
            </div>
            
            <div class="box-body" style="padding: 10px;">
                <div style="text-align: center; margin-bottom: 8px;">
                    <strong style="color: #3c8dbc; font-size: 13px;"><?= $member->id_member ?></strong>
                    <p style="margin: 2px 0; font-size: 13px;"><?= $member->user_member ?></p>
                    <small class="text-muted">
                        <i class="fa fa-calendar"></i> <?= date('d/m/Y', strtotime($member->created_at)) ?>
                    </small>
                </div>
                
                <div class="member-stats">
                    <div class="stat-item">
                        <span class="value text-success"><?= currency($member->jumlah_kiri) ?></span>
                        <span class="label"><i class="fa fa-arrow-left"></i> KIRI</span>
                    </div>
                    <div style="width: 1px; background: #f4f4f4;"></div>
                    <div class="stat-item">
                        <span class="value text-primary"><?= currency($member->jumlah_kanan) ?></span>
                        <span class="label"><i class="fa fa-arrow-right"></i> KANAN</span>
                    </div>
                </div>

                <?php if ($_binary == true) {
                    while ($row = $plan_pasangan->fetch_object()) {
                        $poin_pasangan = $cm->total_poin_pasangan($id, $row->id);
                        $show_pasangan = $row->id >= 200 || $show_modul;

                        if ($show_pasangan) {
                ?>
                    <div class="poin-item">
                        <span class="text-success"><strong><?= currency($poin_pasangan->jumlah_kiri) ?></strong></span>
                        <span style="font-size: 10px;">
                            <i class="fa fa-chart-line"></i>
                            <?= $row->show_name ? $row->show_name : 'Pasangan' ?>
                        </span>
                        <span class="text-primary"><strong><?= currency($poin_pasangan->jumlah_kanan) ?></strong></span>
                    </div>
                <?php
                        }
                    }
                } ?>

                <?php if ($show_modul) { ?>
                <div style="text-align: center; padding-top: 8px; border-top: 1px solid #f4f4f4;">
                    <div style="margin-bottom: 3px;"><?= $jumlah_ro ?></div>
                    <?php if ($tgl_ro): ?>
                    <div><?= $tgl_ro ?></div>
                    <?php endif; ?>
                </div>
                <?php } ?>
                
                <div style="margin-top: 10px;">
                    <a href="?go=member_pohon_jaringan&id_member=<?= $member->id_member ?>" class="btn btn-primary btn-sm btn-block">
                        <i class="fa fa-sitemap"></i> Lihat Jaringan
                    </a>
                    <a href="?go=member_edit&id=<?= base64_encode($member->id) ?>" class="btn btn-default btn-sm btn-block" style="margin-top: 5px;">
                        <i class="fa fa-edit"></i> Edit Member
                    </a>
                    <button type="button" class="btn btn-warning btn-sm btn-block" style="margin-top: 5px;" onclick="openPostingRoModal(<?= $member->id ?>, '<?= $member->id_member ?>', '<?= $member->user_member ?>', <?= $member->sponsor ?>)">
                        <i class="fa fa-refresh"></i> Posting RO
                    </button>
                </div>
            </div>
        </div>
<?php
    }
}

// Get member ID to display
$id_member = null;
$upline_root = null;
$cm = new classMember();

if (isset($_GET['id_member'])) {
    $id = $_GET['id_member'];
    $member = $cm->genealogy($id);
    if (!empty($member)) {
        $id_member = $member->id;
        if ($member->upline) {
            $upline_id = $member->upline;
            $upline_root_data = $cm->detail($upline_id);
            if ($upline_root_data) {
                $upline_root = $upline_root_data->id_member;
            }
        }
    }
} else {
    // Default: show first active member
    $first_member = $cm->first_member();
    if ($first_member) {
        $id_member = $first_member->id;
    }
}

$member = null;
$member_search = '';
if ($id_member) {
    $member = $cm->detail($id_member);
    if ($member) {
        $member_search = $_GET['id_member'] ?? $member->id_member;
    }
}
?>

<style>
    .tree-container {
        overflow-x: auto;
        background: white;
        padding: 20px;
        min-height: 400px;
    }

    .tree,
    .tree ul {
        padding: 0;
        margin: 0;
        list-style: none;
        position: relative;
    }

    .tree ul {
        padding-top: 20px;
    }

    .tree li {
        display: table-cell;
        text-align: center;
        padding: 0 10px;
        vertical-align: top;
        position: relative;
    }

    .tree li::before,
    .tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px solid #ccc;
        width: 50%;
        height: 20px;
    }

    .tree li::after {
        right: auto;
        left: 50%;
        border-left: 2px solid #ccc;
    }

    .tree li:only-child::after,
    .tree li:only-child::before {
        display: none;
    }

    .tree li:only-child {
        padding-top: 0;
    }

    .tree li:first-child::before,
    .tree li:last-child::after {
        border: 0 none;
    }

    .tree li:last-child::before {
        border-right: 2px solid #ccc;
        border-radius: 0 5px 0 0;
    }

    .tree li:first-child::after {
        border-radius: 5px 0 0 0;
    }

    .tree ul ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid #ccc;
        width: 0;
        height: 20px;
    }

    .tree li>.box,
    .tree li>.empty-slot,
    .tree li>a.empty-slot {
        display: inline-block;
        margin-top: 20px;
        position: relative;
    }

    .member-card {
        min-width: 220px;
        max-width: 220px;
        border: 1px solid #d2d6de;
        border-radius: 3px;
        background: #fff;
    }

    .member-card .box-header {
        background: #3c8dbc;
        color: #fff;
        padding: 8px 10px;
        border-bottom: 0;
    }

    .member-card .box-body {
        padding: 10px;
    }

    .empty-slot {
        min-width: 220px;
        max-width: 220px;
        min-height: 120px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 3px;
        transition: all 0.3s;
        text-align: center;
        padding: 15px;
    }

    .empty-slot.locked {
        background: #f4f4f4;
        border: 2px dashed #d2d6de;
    }

    .empty-slot.available {
        background: #f0f9ff;
        border: 2px dashed #00a65a;
        cursor: pointer;
        text-decoration: none;
    }

    .empty-slot.available:hover {
        background: #e8f8f5;
        border-color: #008d4c;
    }

    .member-stats {
        display: flex;
        justify-content: space-around;
        padding: 8px 0;
        border-top: 1px solid #f4f4f4;
        border-bottom: 1px solid #f4f4f4;
        margin: 8px 0;
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-item .value {
        font-size: 14px;
        font-weight: bold;
        display: block;
    }

    .stat-item .label {
        font-size: 11px;
        color: #999;
        display: block;
    }

    .poin-item {
        background: #f9f9f9;
        padding: 5px 8px;
        margin-bottom: 5px;
        font-size: 11px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .box {
        margin-bottom: 0!important;
    }
</style>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-sitemap"></i> Pohon Jaringan Binary</h3>
        <div class="box-tools pull-right">
            <a href="?go=member_list" class="btn btn-sm btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="box-body">
        
        <!-- Search Form -->
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" class="mb-2">
            <input type="hidden" name="go" value="member_pohon_jaringan">
            <div class="row">
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="id_member" value="<?= $member_search ?>" placeholder="Masukkan ID Member untuk melihat jaringannya..." required>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                        </span>
                    </div>
                </div>
                <?php if ($upline_root !== null): ?>
                <div class="col-sm-4">
                    <a href="?go=member_pohon_jaringan&id_member=<?= $upline_root ?>" class="btn btn-info btn-block">
                        <i class="fa fa-arrow-up"></i> Lihat Upline
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </form>

        <?php if ($member): ?>
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i>
            <strong>Menampilkan jaringan:</strong> <?= $member->id_member ?> - <?= $member->user_member ?>
        </div>
        <?php endif; ?>

        <!-- Tree Container -->
        <div class="tree-container">
            <?php if ($member): ?>
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
            <?php else: ?>
            <div class="alert alert-warning text-center">
                <h4><i class="fa fa-warning"></i> Member Tidak Ditemukan</h4>
                <p>Silakan masukkan ID Member yang valid untuk melihat jaringannya.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Posting RO -->
<div class="modal fade" id="modalPostingRo" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-refresh"></i> Posting RO (Repeat Order)
                </h4>
            </div>
            <form id="formPostingRo" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="member_id" id="posting_member_id">
                    <input type="hidden" name="sponsor_id" id="posting_sponsor_id">
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        <strong>Member:</strong> <span id="posting_member_info"></span>
                    </div>

                    <div class="form-group">
                        <label>Pemilik PIN RO <span class="text-danger">*</span></label>
                        <select class="form-control" name="pin_owner" id="pin_owner" required>
                            <option value="">-- Pilih Pemilik PIN --</option>
                            <option value="member">PIN Milik Member Sendiri</option>
                            <option value="sponsor">PIN Milik Sponsor</option>
                        </select>
                        <small class="text-muted">Pilih siapa yang memiliki PIN RO untuk aktivasi ini</small>
                    </div>

                    <div class="form-group">
                        <label>PIN RO <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_kodeaktivasi" id="id_kodeaktivasi" required disabled>
                            <option value="">Pilih pemilik PIN terlebih dahulu</option>
                        </select>
                        <small class="text-muted">PIN RO yang tersedia akan ditampilkan setelah memilih pemilik</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning" id="btnSubmitPostingRo">
                        <i class="fa fa-check"></i> Posting RO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentMemberId = null;
let currentSponsorId = null;

function openPostingRoModal(memberId, idMember, userName, sponsorId) {
    currentMemberId = memberId;
    currentSponsorId = sponsorId;
    
    $('#posting_member_id').val(memberId);
    $('#posting_sponsor_id').val(sponsorId);
    $('#posting_member_info').text(idMember + ' - ' + userName);
    
    // Reset form
    $('#pin_owner').val('');
    $('#id_kodeaktivasi').html('<option value="">Pilih pemilik PIN terlebih dahulu</option>').prop('disabled', true);
    
    $('#modalPostingRo').modal('show');
}

// Load PIN RO based on owner
$('#pin_owner').change(function() {
    var owner = $(this).val();
    var ownerId = owner === 'member' ? currentMemberId : currentSponsorId;
    
    $('#id_kodeaktivasi').html('<option value="">-- Loading... --</option>').prop('disabled', true);
    
    if(owner) {
        $.ajax({
            url: 'controller/posting/get_pin_ro.php',
            method: 'POST',
            data: {
                member_id: ownerId,
                pin_type: 'ro'
            },
            success: function(response) {
                $('#id_kodeaktivasi').html(response).prop('disabled', false);
            },
            error: function() {
                $('#id_kodeaktivasi').html('<option value="">Error loading PIN</option>').prop('disabled', true);
            }
        });
    }
});

// Submit Posting RO
$('#formPostingRo').submit(function(e) {
    e.preventDefault();
    
    var $btn = $('#btnSubmitPostingRo');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Proses...');
    
    $.ajax({
        url: 'controller/posting/posting_ro.php',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if(response.status) {
                alert('Success: ' + response.message);
                $('#modalPostingRo').modal('hide');
                location.reload(); // Reload untuk update RO info
            } else {
                alert('Error: ' + response.message);
                $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Posting RO');
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            alert('Terjadi kesalahan sistem. Silakan coba lagi.');
            $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Posting RO');
        }
    });
});
</script>
