<?php 
    require_once '../model/classSlideCertificate.php';
    $cp = new classSlideCertificate();
    $slides = $cp->index();
?>
<div class="row">
    <?php
    if($slides->num_rows > 0){
    ?>
    <div class="col-12">
        <h4>Penghargaan</h4>
        <div class="owl-carousel owl-theme show-nav-title mt-2 mb-0">
            <?php
        while($row = $slides->fetch_object()){
            ?>
            <div class="bg-white rounded-10 p-2">
                <img width="100%" class="img-fluid" src="../images/slide_certificate/<?=$row->gambar?>"
                    alt="image">
            </div>
            <?php
        }
        ?>
        </div>
    </div>
    <?php
    }
    ?>
</div>