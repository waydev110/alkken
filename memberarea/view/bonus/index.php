<?php
require_once '../model/classMember.php';
$cm = new classMember();
$member = $cm->detail($session_member_id);
$qualified_balik_modal = $cm->cek_sponsori_netreborn($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->

<!-- Sidebar main menu ends -->
<!-- All bonus page styles moved to assets/css/custom-memberarea.css -->
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme shadow-sm" style="z-index: 1001; width: 100%;">
        <div class="container-fluid py-2 px-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <?php include 'view/layout/back.php'; ?>
                    <h5 class="mb-0 ms-2 fw-semibold text-white" style="letter-spacing:0.5px;"> <?= $title ?> </h5>
                </div>
                <button type="button" id="btnBatal" class="btn btn-light btn-sm rounded-circle shadow-sm ms-2" onclick="showModalFilter()" title="Filter">
                    <i class="fas fa-sliders"></i>
                </button>
            </div>
            <div class="mt-3">
                <div class="input-group input-group-sm shadow-sm bg-white rounded-pill px-2 py-1" style="max-width: 480px; margin: 0 auto;">
                    <span class="input-group-text bg-white border-0 pe-1"><i class="fa fa-search text-muted"></i></span>
                    <input type="text" name="keterangan" id="keterangan" class="form-control border-0 bg-white rounded-pill ps-1" placeholder="Cari keterangan bonus" style="box-shadow:none;">
                </div>
            </div>
        </div>
    </header>
    <!-- main page content -->
    <div class="main-container container pb-4 pt-4">
        <div class="row">
            <div class="col-12">
                <div class="swiper-container bonus-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn btn-outline-primary btn-sm rounded-pill swiper-slide tag active me-2 mb-2" type="button" data-option-value="*" onclick="get_bonus(0, '', this)">
                            Semua Bonus
                        </button>
                        <?php
                        // Define bonus types with their conditions
                        $bonus_types = [
                            [
                                'key' => 'bonus_founder',
                                'qualified' => $member->founder == '1',
                                'label' => $lang['bonus_founder']
                            ],
                            [
                                'key' => 'bonus_sponsor',
                                'qualified' => true,
                                'label' => $lang['bonus_sponsor']
                            ],
                            [
                                'key' => 'bonus_cashback',
                                'qualified' => false,
                                'label' => $lang['bonus_cashback']
                            ],
                            [
                                'key' => 'bonus_pasangan',
                                'qualified' => true, // Hidden
                                'label' => $lang['bonus_pasangan'] ?? 'Bonus Pasangan'
                            ],
                            [
                                'key' => 'bonus_generasi_ro_aktif',
                                'qualified' => false,
                                'label' => $lang['bonus_generasi_ro_aktif']
                            ],
                            [
                                'key' => 'bonus_titik_ro_aktif',
                                'qualified' => false,
                                'label' => $lang['bonus_titik_ro_aktif']
                            ],
                            [
                                'key' => 'bonus_royalti_omset',
                                'qualified' => false, // Hidden
                                'label' => $lang['bonus_royalti_omset'] ?? 'Bonus Royalti Omset'
                            ],
                            [
                                'key' => 'bonus_generasi',
                                'qualified' => true,
                                'label' => $lang['bonus_generasi']
                            ],
                            [
                                'key' => 'bonus_titik',
                                'qualified' => true,
                                'label' => $lang['bonus_titik']
                            ],
                            [
                                'key' => 'bonus_reward',
                                'qualified' => true,
                                'label' => $lang['bonus_reward']
                            ],
                            [
                                'key' => 'bonus_reward_paket',
                                'qualified' => false, // Hidden
                                'label' => $lang['bonus_reward_paket'] ?? 'Bonus Reward Paket'
                            ],
                            [
                                'key' => 'bonus_balik_modal',
                                // 'qualified' => $qualified_balik_modal,
                                'qualified' => false,
                                'label' => $lang['bonus_balik_modal']
                            ]
                        ];

                        // Loop through bonus types and display qualified ones
                        foreach ($bonus_types as $bonus) {
                            if ($bonus['qualified']) {
                        ?>
                                <button class="btn btn-outline-primary btn-sm rounded-pill swiper-slide tag me-2 mb-2" type="button" data-filter=".<?= $bonus['key'] ?>" onclick="get_bonus(0, '<?= $bonus['key'] ?>', this)">
                                    <?= $bonus['label'] ?>
                                </button>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="bonus-list"></div>
                <div class="load-list d-none mt-3">
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-outline-secondary rounded-pill px-4" id="btnMore" onclick="get_bonus(0)">Load More</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-bottom fade" id="modalFilter" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 bg-light">
                        <h5 class="modal-title fw-semibold" id="myModalLabel">Filter Bonus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="status_transfer">Status Transfer</label>
                            <select class="form-select rounded-pill" id="status_transfer" name="status_transfer">
                                <option value="">-- Semua Status --</option>
                                <option value="0">Pending</option>
                                <option value="1">Ditransfer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="start_date">Tanggal</label>
                            <div class="input-group input-group-sm">
                                <input type="date" class="form-control rounded-pill" id="start_date" name="start_date">
                                <span class="input-group-text bg-white border-0">s/d</span>
                                <input type="date" class="form-control rounded-pill" id="end_date" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="bonus()">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<script>
    function showModalFilter() {
        $('#modalFilter').modal('show');
    }

    var type = '';
    var status_transfer = null;
    var start_date = null;
    var end_date = null;
    var debounceTimer;
    $(document).ready(function() {
        get_bonus(0, '', null);
        var bonusSwiper = new Swiper(".bonus-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });

        $('#keterangan').on('keydown', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                status_transfer = null;
                start_date = null;
                end_date = null;
                get_bonus(0, '', null);
            }, 500);
        });
    });

    function bonus() {
        status_transfer = $('#status_transfer').val();
        start_date = $('#start_date').val();
        end_date = $('#end_date').val();
        type = $('.btn-category.active').attr('data-filter');
        get_bonus(0, type, null);
    }

    function get_bonus(start = 0, type = '', e) {
        if (e != null) {
            $('.swiper-slide').removeClass('active');
            $(e).addClass('active');
        }
        type = type.replace(/\./g, '');
        var keterangan = $('#keterangan').val();
        $.ajax({
            type: 'POST',
            url: 'controller/bonus/get_bonus.php',
            data: {
                start: start,
                type: type,
                keterangan: keterangan,
                status_transfer: status_transfer,
                start_date: start_date,
                end_date: end_date
            },
            beforeSend: function() {
                loader_open();
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    if (start == 0) {
                        $('.bonus-list').html(obj.html);
                    } else {
                        $('.bonus-list').append(obj.html);
                    }
                    if (obj.count > 0) {
                        $('.load-list').show();
                        $('#btnMore').attr('onclick', `get_bonus('${obj.start}', '${obj.type}')`);
                    } else {
                        $('.load-list').hide();
                    }
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