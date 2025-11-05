<?php
    require_once '../model/classPengumuman.php';
    $cpn = new classPengumuman();
    $pengumuman = $cpn->show('Login Member');
    
?>

<div class="modal fade" id="modalAlert" tabindex="-1" aria-labelledby="modalAlertLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <?php
            if($pengumuman){
            ?>
            <div class="modal-header">
                <h4 class="modal-title size-18" id="modalAlertLabel"><?=$pengumuman->judul?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3></h3>
                <img src="../images/pengumuman/<?=$pengumuman->gambar?>" alt="Image" width="100%">
                <div id="deskripsi">
                    <?=$pengumuman->isi?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>