<?php     
    require_once '../model/classMember.php';
    $obj = new classMember();
    $member = $cm->detail($session_member_id);    
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->

<!-- Sidebar main menu ends -->
<style type="text/css">
    .bonus-list {
        width: 100%;
    }

    .bonus-item {
        width: 100%;
    }

    .btn-load {
        padding: 20px;
    }
</style>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center pt-1 ps-0">
                <h5><?= $title ?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
        <div class="row bg-theme">
            <div class="col">
                <div class="main-container container pt-2 pb-2">
                    <div class="row form-search-custom form-theme">
                        <div class="col align-self-center">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-primary" disabled><i class="fa fa-search"></i></button>
                                </div>
                                <input type="text" name="keterangan" id="keterangan" class="form-control rounded-5" placeholder="Cari keterangan bonus">
                            </div>
                        </div>
                        <div class="col-auto align-self-center px-0">
                            <button type="button" id="btnBatal" class="btn btn-transparent" onclick="showModalFilter()"><i class="fas fa-sliders"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </header>
    <!-- main page content -->
    <div class="main-container container pb-4 pt-4">
        <div class="card rounded-0 shadow-none text-dark" id="containerCanvas">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto align-self-center">
                        <img src="../logo.png" alt="" width="70">
                    </div>
                    <div class="col ps-0 align-self-center">
                        <p class="mb-0 size-18 fw-bold"><?=$s->setting('site_pt')?></p>
                        <p class="mb-0 size-13">Alamat : <?=$s->setting('site_pt_address')?></p>
                        <p class="mb-0 size-13">No Telp. <?=$s->setting('site_phone')?></p>
                    </div>
                </div>
                <hr>
                <div class="row size-13 fw-bold">
                    <div class="col-6 align-self-center">
                        <table class="">
                            <tr>
                                <td>ID Member</td>
                                <td>:</td>
                                <td><?=$member->id_member?></td>
                            </tr>
                            <tr>
                                <td>Nama Member</td>
                                <td>:</td>
                                <td><?=$member->nama_member?></td>
                            </tr>
                            <tr>
                                <td>Paket Member</td>
                                <td>:</td>
                                <td><?=$member->nama_plan?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6 align-self-center">
                        <table class="">
                            <tr>
                                <td>Tanggal Join</td>
                                <td>:</td>
                                <td><?=tgl_indo($member->created_at)?></td>
                            </tr>
                            <tr>
                                <td>Sponsor</td>
                                <td>:</td>
                                <td><?=$member->id_sponsor?></td>
                            </tr>
                            <tr>
                                <td>Upline</td>
                                <td>:</td>
                                <td><?=$member->id_upline?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="bonus-list">
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="d-grid mb-4">
                <button class="btn btn-lg btn-default btn-block rounded-pill" onclick="downloadCanvas('containerCanvas')">Download</button>
            </div>
        </div>
        <div class="modal modal-bottom fade" id="modalFilter" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h4 class="modal-title size-18" id="myModalLabel">Filter Bonus</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-control-label" for="tahun">Tahun</label>
                            <select class="form-control rounded-0" id="tahun" name="tahun">
                                <option value="">-- Semua Tahun --</option>
                                <?php
                                for ($tahun = date('Y'); $tahun >= 2020; $tahun--) {
                                ?>
                                    <option value="<?= $tahun ?>"><?= $tahun ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-control-label" for="bulan">Bulan</label>
                            <select class="form-control rounded-0" id="bulan" name="bulan">
                                <option value="">-- Semua Bulan --</option>
                                <?php
                                $arr_bulan = [
                                    '1' => 'Januari',
                                    '2' => 'Februari',
                                    '3' => 'Maret',
                                    '4' => 'April',
                                    '5' => 'Mei',
                                    '6' => 'Juni',
                                    '7' => 'Juli',
                                    '8' => 'Agustus',
                                    '9' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember'
                                ];
                                
                                foreach($arr_bulan as $angka_bulan => $nama_bulan) {
                                ?>
                                    <option value="<?= $angka_bulan ?>"><?= $nama_bulan ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-block btn-outline-default rounded-5 px-5 py-2" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-block btn-default rounded-5 px-5 py-2" onclick="bonus()">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/html2canvas.min.js"></script>
<script>
    function showModalFilter() {
        $('#modalFilter').modal('show');
    }

    var tahun = null;
    var bulan = null;
    var debounceTimer;
    $(document).ready(function() {
        get_slip_bonus();
        var bonusSwiper = new Swiper(".bonus-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });
    });

    function downloadCanvas(id){
        html2canvas(document.getElementById(id)).then(function(canvas) {
            var link = document.createElement('a');
            var title = 'slip-bonus';
            if(bulan != null){
                title += `-${bulan}`;
            }
            if(tahun != null){
                title += `-${tahun}`;
            }
            link.download = `${title}.jpg`;
            link.href = canvas.toDataURL("image/jpeg").replace(/^data:image\/[^;]/, 'data:application/octet-stream');
            link.click();
        });
    }

    function bonus() {
        tahun = $('#tahun').val();
        bulan = $('#bulan').val();
        get_slip_bonus();
    }

    function get_slip_bonus(e) {
        $.ajax({
            type: 'POST',
            url: 'controller/bonus/get_slip_bonus_netborn.php',
            data: {
                tahun: tahun,
                bulan: bulan
            },
            beforeSend: function() {
                loader_open();
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('.bonus-list').html(obj.html);
                    $('#modalFilter').modal('hide');
                } else {
                    Swal.fire({
                        text: obj.message,
                        customClass: {
                            confirmButton: 'btn-default rounded-pill px-5'
                        }
                    });
                }
            },
            complete: function() {
                loader_close();
            }
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>