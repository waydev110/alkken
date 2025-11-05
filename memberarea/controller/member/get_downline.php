<?php  
session_start();
require_once '../../../helper/all_member.php';
require_once '../../../model/classMember.php';

$cm = new classMember();
$sponsor = base64_decode(addslashes(strip_tags($_POST['sponsor'])));
$generasi = addslashes(strip_tags($_POST['generasi']));
$member = $cm->show($session_member_id);
$root_level = $member->level;
$downline = $cm->get_downline($sponsor);
if($downline->num_rows > 0){	
    $generasi++;
    $html = '<ul class="listree-submenu-items" style="display: block">';
    while($row = $downline->fetch_object()) {
        $level_downline = $row->level - $root_level;
        $sponsori = $cm->sponsori($row->id);
        $sponsori_reposisi = $cm->sponsori_reposisi($row->id);
        $member = $cm->detail($row->id);
        $info_ro = $cm->info_ro($row->id, 14);
        if($info_ro->total > 0){
            $jumlah_ro = '<span class="size-11 text-success fw-bold">Jumlah RO Aktif : '.$info_ro->total.'</span>';
            $tgl_ro = '<span class="size-11 text-success fw-bold">'.tgl_indo($info_ro->created_at).'</span>';
        } else {
            $jumlah_ro = '<span class="size-11 text-danger fw-bold">Belum RO Aktif</span>';
            $tgl_ro = '';
        }
    $html .='
    <li>
        <div class="listree-submenu-heading">
            <div class="card rounded-0 bg-white card-downline" onclick="getDownline('."'".base64_encode($row->id)."'".', '."'".$generasi."'".', this)">
                <div class="card-body pt-2 ps-2 pb-0">
                    <div class="row mb-2">
                        <div class="col-auto align-self-center text-start">
                            <p class="rounded-pill px-2 py-4 bg-theme text-white size-32">'.currency($generasi).'</p>
                        </div>
                        <div class="col align-self-center ps-0">
                            <p class="mb-0 size-12 fw-bold text-dark">'.$row->id_member.'</p>
                            <p class="mb-0 size-12 fw-semibold text-dark">'.strtoupper($row->nama_samaran).'</p>
                            <p class="mb-0 size-12 text-primary fw-bold">'.$member->nama_plan.' '.$member->short_name.'</p>
                            '.$jumlah_ro.'
                        </div>
                        <div class="col-auto align-self-center text-end">
                            <p class="mb-0 size-12 text-dark">'.tgl_indo($row->created_at).'</p>
                            <p class="mb-0 size-12 text-dark">Jumlah Sponsori:</p>
                            <p class="mb-0 fw-bold text-primary"><span class="size-11">B : ('.currency($sponsori).') </span> | <span class="size-11">R : ('.currency($sponsori_reposisi).')</span></p>
                            '.$tgl_ro.'
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>';
    }
    $html .='</ul>';
    echo $html;
}
?>