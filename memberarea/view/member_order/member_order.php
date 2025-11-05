<?php 
    require_once '../model/classStokisMember.php';
    $csm = new classStokisMember();
    $stokis = $csm->index();
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->

<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <?php include 'view/layout/cart.php'; ?>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col">                
                <div class="card mb-4 rounded-10 border-0 border-bottom">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 align-self-center">
                                <div class="form-group mb-2">
                                    <label for="" class="form-control-label size-14 mb-2">Pilih Kota</label>
                                    <select class="form-control" id="id_kota" name="id_kota" onchange="get_stokis()">
                                        <option value="">-- Semua Kota --</option>
                                        <?php 
                                        while ($row   = $kota->fetch_object()) {
                                            echo "<option value='".$row->id."'>".$row->nama_kota."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 align-self-center">
                                <div class="form-group mb-2">
                                    <label for="" class="form-control-label size-14 mb-2">Pilih Stokis</label>
                                    <select class="form-control" id="id_stokis" name="id_stokis" onchange="get_produk()">
                                        <option value="">-- Semua Stokis --</option>
                                        <?php 
                                        while ($row   = $stokis->fetch_object()) {
                                            echo "<option value='".$row->id."'>".$row->nama_stokis."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 align-self-center">
                                <label for="" class="form-control-label size-14 mb-2">Cari Produk</label>
                                <input type="text" id="keyword" name="keyword" value="" class="form-control" placeholder="Ketikan Nama Produk" onchange="get_produk()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="list-produk">
        </div>
    </div>
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<script>
    $(document).ready(function () {

        var $grid = $('.bonus-list').isotope({
            // options...
            itemSelector: '.bonus-item',
            layoutMode: 'vertical',
        });

        // filter items on button click
        $('.filter-button-group').on('click', '.btn-category', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
            $('.btn-category').removeClass('active');
            $(this).addClass('active');
        });
    });

    function get_stokis() {
        var id_kota = $('#id_kota').val();
        $.ajax({
            url: 'controller/stokis_member/get_stokis.php',
            type: 'post',
            data: {id_kota:id_kota},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#id_stokis').html(obj.html);
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function get_produk() {
        var id_stokis = $('#id_stokis').val();
        var keyword = $('#keyword').val();
        $.ajax({
            url: 'controller/produk/get_produk_stokis.php',
            type: 'post',
            data: {id_stokis:id_stokis, keyword:keyword},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#list-produk').html(obj.html);
                } else {
                    alert(obj.message);
                }
            }
        });
    }
    
    function addToCart(id_produk) {
        var id_stokis = $("#id_stokis").val();
        var qty = $("#qty").val();
        $.ajax({
            url: "controller/member_order/add_to_cart.php",
            data: {
                id_stokis: id_stokis,
                id_produk: id_produk,
                qty: qty
            },
            type: "POST",
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('.count-indicator').text(obj.count);
                }
            },
            complete: function () {
                loader_close();
            }
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>