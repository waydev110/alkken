<?php
require_once '../model/classMember.php';
$cm = new classMember();
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
        <div class="row">
            <div class="col">
                <div class="swiper-container bonus-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*" style="width:auto" onclick="get_bonus(0, '', this)">
                            Semua Bonus
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".bonus_sponsor_netborn" style="width:auto" onclick="get_bonus(0, 'bonus_sponsor_netborn', this)">
                            <?= $lang['bonus_sponsor_netborn'] ?>
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".bonus_pasangan_netborn" style="width:auto" onclick="get_bonus(0, 'bonus_pasangan_netborn', this)">
                            <?= $lang['bonus_pasangan_netborn'] ?>
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".bonus_pasangan_level_netborn" style="width:auto" onclick="get_bonus(0, 'bonus_pasangan_level_netborn', this)">
                            <?= $lang['bonus_pasangan_level_netborn'] ?>
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".bonus_generasi_netborn"
                            style="width:auto" onclick="get_bonus(0, 'bonus_generasi_netborn', this)">
                            <?= $lang['bonus_generasi_netborn'] ?>
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".bonus_titik_netborn"
                            style="width:auto" onclick="get_bonus(0, 'bonus_titik_netborn', this)">
                            <?= $lang['bonus_titik_netborn'] ?>
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".bonus_reward_netborn"
                            style="width:auto" onclick="get_bonus(0, 'bonus_reward_netborn', this)">
                            <?= $lang['bonus_reward_netborn'] ?>
                        </button>
                    </div>
                </div>
                <div class="bonus-list">
                </div>
                <div class="load-list" display="none">
                    <div class="col-12 btn-load">
                        <div class="row">
                            <button class="btn btn-default rounded-pill" id="btnMore" onclick="get_bonus(0)">Load More
                        </div>
                    </div>
                </div>
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
                            <label class="form-control-label" for="status_transfer">Status Transfer</label>
                            <select class="form-control rounded-0" id="status_transfer" name="status_transfer">
                                <option value="">-- Semua Status --</option>
                                <option value="0">Pending</option>
                                <option value="1">Ditransfer</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-control-label" for="start_date">Tanggal</label>
                            <div class="input-group">
                                <input type="date" class="form-control rounded-0" id="start_date" name="start_date">
                                <span class="input-group-addon">s/d</span>
                                <input type="date" class="form-control rounded-0" id="end_date" name="end_date">
                            </div>
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