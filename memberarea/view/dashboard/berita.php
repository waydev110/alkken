<?php
        if($berita->num_rows > 0){
        ?>
<div class="row">
    <div class="col py-2">
        <h5 class="title text-primary">Berita Terbaru</h5>
    </div>
    <div class="col-auto align-self-center">
        <a class="btn btn-sm btn-outline-default rounded-2" href="?go=berita" class="">Lainnya</a>
    </div>
</div>
<div class="row">
    <div class="swiper-container news-swiper">
        <div class="swiper-wrapper">
            <?php
            while ($row = $berita->fetch_object()){
        ?>
            <div class="swiper-slide">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 shadow-sm rounded-10 coverimg">
                                    <img src="../images/berita/<?=$row->gambar?>" alt="<?=$row->gambar?>">
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <a href="?go=berita_detail&title=<?=$row->slug?>" class="text-color-theme mb-1 lh-sm"><?=capital_word($row->judul)?></a>
                                <p class="size-12 text-muted"><?=tgl_indo($row->created_at)?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
        }
    ?>