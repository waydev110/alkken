<?php
if($slide->num_rows > 0){
?>
<div class="swiper-container sliderswiper custom-order-card">
    <div class="swiper-wrapper">
        <?php
        while ($row = $slide->fetch_object()){
        ?>
        <div class="swiper-slide">
            <div class="row h-100">
                <div class="col-12 align-self-center text-center">
                    <a href="<?=site_url($row->url)?>"><img src="../images/slide_show/<?=$row->gambar?>" alt="<?=$row->gambar?>"
                        class="mw-100 mx-auto rounded-15">
                    </a>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
<?php
}
?>