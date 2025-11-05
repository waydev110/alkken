<div class="mb-3 px-2 py-3 rounded-10 bg-white">
    <div class="row px-2">
        <div class="col align-self-center text-left">            
            <p class="size-12 mb-0">Hi, <?=greetings(date('H'))?></p>
            <h5><?=strtoupper($session_nama_samaran)?></h5>
            <p class="size-12"><?=$session_id_member?></p>
            <!-- <h5 class="size-14 d-flex align-items-center"><span class="pt-1">Paket Join <?=strtoupper($member->nama_plan)?></span></h5>
            <p class="size-11">Bergabung sejak tanggal <?=tgl_indo($member->created_at)?></p> -->
        </div>
        <div class="col-auto align-self-center text-end">
            <p class="size-12 fw-semibold mb-0">Paket Join <br><?=strtoupper($member->nama_plan)?></p>
            <h3 class="size-14 fw-bold"><?=$member->nama_paket?></h3>
            <p class="size-11"><?=tgl_indo($member->created_at)?></p>
        </div>
        <div class="col-auto ps-0 align-self-center">
            <a href="<?=site_url('detail_bisnis')?>" class="avatar avatar-60">
                <img src="../images/plan/<?=$member->icon_plan?>" alt="">
            </a>
        </div>
    </div>
</div>