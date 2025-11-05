<?php
    require_once '../model/classBonus.php';

    $cbns = new classBonus();
    $total_bonus = $cbns->total_bonus($session_member_id);
?>
<div class="row">
    <div class="col-12">
        <div class="certificate-container" id="certifikatCanvas">
            <img src="certificate.jpg" alt="sertifikat"
                class="mw-100 mx-auto mb-5 rounded-10 shadow-sm">
                <div class="title-name"><h1><?=$session_nama_member?><br><?=$session_id_member?></h1></div>
            <div class="title-nominal"><h2><?=rp($total_bonus)?></h2></div>
        </div>
    </div>
    
    <div class="col-12">
        <div class="d-grid mb-4">
            <button class="btn btn-lg btn-default btn-block rounded-pill" onclick="downloadSertifikat('certifikatCanvas')">Download Sertifikat</button>
        </div>
    </div>
</div>
<script src="assets/js/html2canvas.min.js"></script>
<script>
    function downloadSertifikat(id){
        html2canvas(document.getElementById(id)).then(function(canvas) {
            var link = document.createElement('a');
            link.download = 'Certificate-<?=$session_id_member?>.jpg';
            link.href = canvas.toDataURL("image/jpeg").replace(/^data:image\/[^;]/, 'data:application/octet-stream');
            link.click();
        });
    }
</script>