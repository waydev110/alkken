<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classBonus.php';
    $obj = new classBonus();
    $data = $obj->riwayat_investasi($session_member_id);
    $jangka_waktu = $obj->jangka_waktu_bonus_investasi();
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .data-list {
        width: 100%;
    }

    .data-item {
        width: 100%;
    }

    th,
    td {
        font-size: 11px;
    }
</style>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col">
                <?php
            if($data->num_rows > 0) {
            ?>
                <div class="data-list">
                    <?php
                while($row = $data->fetch_object()){
                    $tanggal = $row->created_at;
                    $member = $cm->detail($row->id_member);
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom data-item">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p class="pt-3 mb-1 text-default size-11">
                                        <?=tgl_indo_hari($tanggal)?>
                                    </p>
                                    <p class="text-muted size-11 mb-0">Nominal Penyertaan Modal</p>
                                    <span class="text-default fw-bold mb-1 size-18"><?=rps($row->harga)?></span>
                                </div>
                                <div class="col-auto align-self-center text-end mt-3">
                                    <button class="btn btn-sm btn-danger text-light rounded-pill"><i
                                            class="fa fa-download"></i> Tarik Dana</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-grid mt-2 text-end">
                                    <button type="button"
                                        class="btn btn-sm btn-light rounded-pill py-1 px-2 text-lowercase btn-detail"
                                        data-bs-toggle="collapse" href="#detail<?=$row->id?>" role="button"
                                        aria-expanded="false" aria-controls="collapseExample"><span class="size-12"><i
                                                class="fa-solid fa-chevron-down"></i></span></button>
                                </div>
                            </div>
                        </div>

                        <div class="collapse block-detail mt-0" id="detail<?=$row->id?>">
                            <?php
                            $tanggal = date("Y-m-d", strtotime($row->created_at));
                            for($i=1; $i<=$jangka_waktu; $i++){
                                if($i == 2){
                                    $tanggal = date("Y-m-d", strtotime("+2 month", strtotime($tanggal)));
                                } else if ($i > 2) {
                                    $tanggal = date("Y-m-d", strtotime("+1 month",  strtotime($tanggal)));
                                }
                                $cek_bagi_hasil = $obj->cek_bagi_hasil($session_member_id, $row->id, date('Y-m', strtotime($tanggal)));
                                if($cek_bagi_hasil){
                                    $aksi = status_klaim(1);
                                } else {
                                    if(strtotime($tanggal) <= strtotime(date('Y-m-d'))){
                                        $aksi = '<button class="btn btn-sm btn-success rounded-pill fw-bold text-light btn-klaim" data-id="'.$row->id.'" data-tanggal="'.$tanggal.'" data-bonuske="'.$i.'">Klaim Bagi Hasil</button>';
                                    } else {
                                        $aksi = status_klaim(0);
                                    }
                                }
                            ?>
                            <div class="card mb-0 rounded-0 border-0 border-bottom bonus-item">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col align-self-center">
                                            <div class="row">
                                                <div class="col align-self-center">
                                                    <p class="mb-0 text-muted size-11"><?=tgl_indo_hari($tanggal)?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto align-self-right">
                                                    <p class="text-default fw-bold mb-1 size-18"><?=rps($row->bonus_cashback)?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto align-self-center text-end col-status">
                                            <?=$aksi?>
                                        </div>
                                    </div>
                                </div>
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
                <?php
            } else {
            ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center ps-0">
                                <p class="mb-0"><span class="text-muted size-12">Tidak ada data.</span></p>

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
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script>
    var status_klaim = `<?=status_klaim(1)?>`;
    $(function(){
        $('.btn-klaim').on('click', function(){
            var e = $(this);
            var id = e.data('id');
            var tanggal = e.data('tanggal');
            var bonus_ke = e.data('bonuske');
            $.ajax({
                type: 'post',
                url: 'controller/bonus/klaim_bagi_hasil.php',
                data: {id:id, tanggal:tanggal, bonus_ke:bonus_ke},
                beforeSend: function () {
                    loader_open();
                },
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        e.closest('div.col-status').html(status_klaim);
                    } else {
                        alert('Klaim bonus gagal.');
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
        });

    });
</script>
<script src="assets/js/jquery.isotope.min.js"></script>
<?php include 'view/layout/footer.php'; ?>