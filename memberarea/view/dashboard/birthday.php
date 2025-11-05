<?php
if($session_tgl_lahir_member <> '' OR $session_tgl_lahir_member <> NULL){
    $tgl_hari_ini = date("m-d");
    $tgl_lahir_member = date("m-d", strtotime($session_tgl_lahir_member));
    ?>
    <?php
    if($tgl_lahir_member == $tgl_hari_ini){
    ?>

    <div class="modal fade" id="modalBirthday" tabindex="-1" aria-labelledby="modalBirthdayLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="mb-0"><strong><?=$site_pt?></strong>, mengucapkan ulang tahun kepada:</p>
                    <p class="mb-0">Nama : <?=$session_nama_member?></p>
                    <p class="mb-0">ID : <?=$session_id_member?></p>
                    <p class="mb-0">Tgl Lahir : <?=date('d/m/Y', strtotime($session_tgl_lahir_member))?></p>
                    <p class="mb-0">Semoga panjang umur, sehat selalu berkah selamanya.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default rounded-pill" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
}
?>