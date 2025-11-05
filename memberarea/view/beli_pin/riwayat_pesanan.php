<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->

<!-- Sidebar main menu ends -->
<style type="text/css">
    .order-list {
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
                                <input type="text" name="keyword" id="keyword" class="form-control rounded-5" placeholder="Cari pesanan...">
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
                <div class="order-list">
                </div>
                <div class="load-list" display="none">
                    <div class="col-12 btn-load">
                        <div class="row">
                            <button class="btn btn-default rounded-pill" id="btnMore" onclick="get_order(0)">Load More
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-bottom fade" id="modalFilter" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h4 class="modal-title size-18" id="myModalLabel">Filter Pesanan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
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
<script>
    function showModalFilter() {
        $('#modalFilter').modal('show');
    }

    var type = '';
    var id_stokis = null;
    var start_date = null;
    var end_date = null;
    var debounceTimer;
    $(document).ready(function() {
        get_order(0, null);

        $('#keyword').on('keydown', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                id_stokis = null;
                start_date = null;
                end_date = null;
                get_order(0, null);
            }, 500);
        });
    });

    function show(el, e) {
        $(el).show();
        $(e).hide();
    }

    function bonus() {
        id_stokis = $('#id_stokis').val();
        start_date = $('#start_date').val();
        end_date = $('#end_date').val();
        get_order(0, null);
    }

    function get_order(start = 0, e) {
        if (e != null) {
            $('.swiper-slide').removeClass('active');
            $(e).addClass('active');
        }
        var keyword = $('#keyword').val();
        $.ajax({
            type: 'POST',
            url: 'controller/beli_pin/riwayat_pesanan.php',
            data: {
                start: start,
                keyword: keyword,
                id_stokis: id_stokis,
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
                        $('.order-list').html(obj.html);
                    } else {
                        $('.order-list').append(obj.html);
                    }
                    if (obj.count > 0) {
                        $('.load-list').show();
                        $('#btnMore').attr('onclick', `get_order('${obj.start}')`);
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