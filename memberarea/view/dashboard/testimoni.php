<?php
        if($testimoni->num_rows > 0){
        ?>
<div class="row mt-3">
    <div class="col py-2">
        <h5 class="title text-primary">Testimoni</h5>
    </div>
    <div class="col-auto align-self-center">
        <a class="btn btn-sm btn-outline-default rounded-2" href="?go=testimoni" class="">Lainnya</a>
    </div>
</div>
<div class="row">
    <div class="swiper-container testi-swiper">
        <div class="swiper-wrapper">
            <?php
            while ($row = $testimoni->fetch_object()){
        ?>
            <div class="swiper-slide">
                <div class="card shadow-sm mb-2" style="height:148px">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                                <p class="text-color-theme fw-bold size-12 mb-0">
                                    <?=$row->nama_samaran?>
                                </p>
                                <p class="text-color-theme paket-name fw-bold size-12">Member <?=$row->nama_plan ?></p>
                            </div>
                            <div class="col align-self-center text-end">
                                <p class="text-dark size-11 mb-0"><?= tgl_indo_jam($row->created_at) ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col align-self-center">
                                <p class="text-muted size-12">
                                    <?= substr($row->testimoni, 0, 150) ?><span class="text-readmore" id="text<?= $row->id ?>" style="display:none"><?= substr($row->testimoni, 150) ?></span>
                                    <?= substr($row->testimoni, 150) <> '' ? '<a href="javascript:void(0);" class="text-bold comment-link" onclick="showComment(this, ' . "'text" . $row->id . "'" . ')">Baca Selengkapnya</a>' : '' ?>
                                </p>
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