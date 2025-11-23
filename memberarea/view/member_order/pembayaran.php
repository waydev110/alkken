<?php 
    
    require_once '../model/classMemberOrder.php';
    require_once '../model/classStokisMember.php';
    require_once '../model/classRekening.php';
    $obj = new classMemberOrder();
    $csm = new classStokisMember();
    $cr = new classRekening();

    if(isset($_GET["id_order"])){
        $id_order = base64_decode($_GET["id_order"]);
        $order = $obj->pending($id_order, $session_member_id);
        if(!$order){
            echo 'Halaman tidak ditemukan.';
            return false;
        }
    } else {
        echo 'Halaman tidak valid.';
        return false;
    }
    $rekening_stokis = $cr->index();
    $data_stokis = $csm->show($order->id_stokis);
?>

<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/custom-memberarea.css">
<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center text-left">
                <h5><?=$title?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->
    <div class="main-container container pt-4 pb-4 mb-2" id="blockFirstForm">
        <div class="card custom-order-card mb-4">
            <div class="card-body">
                <h6>Total Pembayaran:</h6>
                <h3 class="text-danger my-2"><?=rp($order->nominal)?></h3>
                <div class="alert alert-warning" role="alert">
                    <p class="size-12">Bayar sesuai jumlah diatas (termasuk kode unik).</p>
                </div>
                <p class="text-muted size-11">Gunakan ATM/iBanking/setor tunai untuk transfer ke Rekening berikut ini.</p>
                <?php
                if($rekening_stokis->num_rows > 0){
                ?>
                <form action="controller/member_order/upload_bukti_bayar.php" encyptype="multipart/form-data" id="formKonfirmasi" method="post">
                    <input type="hidden" id="id_order" name="id_order" value="<?=base64_encode($id_order)?>">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="pt-2 bg-white">
                                <div id="detail"><?php 
                                        while ($row = $rekening_stokis->fetch_object()) {
                                    ?>
                                    <div class="row mb-4">
                                        <div class="col align-self-center">
                                            <div class="row">
                                                <div class="col-auto align-self-center">
                                                        <h6><?=$row->nama_bank?></h6>
                                                </div>
                                                <div class="col align-self-center text-end">
                                                <button class="btn btn-sm px-0 size-9 btn-custom-primary" onclick="copyToClipboard('#no_rekening<?=$row->id?>')"><i class="fa fa-copy"></i> Salin</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto align-self-center">
                                                    <p class="size-14">Nomor Rekening</p>
                                                </div>
                                                <div class="col align-self-center text-end">
                                                    <p class="size-14" id="no_rekening<?=$row->id?>"><?=$row->no_rekening?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto align-self-center ">
                                                    <p class="size-14">Cabang</p>
                                                </div>
                                                <div class="col align-self-center text-end">
                                                <p class="size-14"><?=$row->cabang_rekening?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto align-self-center ">
                                                    <p class="size-14">Nama Rekening</p>
                                                </div>
                                                <div class="col align-self-center text-end">
                                                <p class="size-14"><?=$row->atas_nama_rekening?></p>
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
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <h6 class="mb-2">Upload Bukti Pembayaran:</h6>
                            <input type="file" id="bukti_bayar" name="bukti_bayar" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button"
                                class="btn btn-custom-primary btn-block btn-lg rounded-pill px-5 order-xs-first mb-3"
                                id="btnKonfirmasi">KONFIRMASI</button>
                            <a href="?go=riwayat_order" class="btn btn-outline-default btn-block btn-lg rounded-pill px-4 mb-2" id="btnKembali">KEMBALI</a>
                        </div>
                    </div>
                </form>
                <?php 
                } else {
                ?>
                <div class="alert alert-warning" role="alert">
                    <p class="size-12">Stokis Belum memiliki Rekening. Silahkan chat via Whatsapp .</p>
                </div>
                <div class="row">
                    <div class="col-12 align-self-center text-end mt-0 d-xs-grid">
                        <a href="?go=riwayat_order" class="btn btn-outline-default btn-lg rounded-pill px-4 mb-2" id="btnKembali">KEMBALI</a>
                        <a href="https://wa.me/<?=$data_stokis->no_handphone?>" type="button"
                            class="btn btn-custom-primary btn-block btn-lg rounded-pill px-5 order-xs-first mb-3" target="_blank">CHAT VIA WA</a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>

<script src="assets/vendor/autoNumeric/autoNumeric.js"></script>

<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formKonfirmasi = $('#formKonfirmasi');
        var btnTransfer = $('#btnTransfer');
        var btnKonfirmasi = $('#btnKonfirmasi');
        var btnKembali = $('#btnKembali');
        var detail = $('#detail');

        $('.autonumeric').autoNumeric('init', {
            "aSep": ".",
            "aDec": ",",
            "mDec": "0",
        });

        btnKonfirmasi.on("click", function (e) {
            blockFirstForm.hide();
            blockNextForm.show();
        });

        formCekPIN.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    if (result == true) {
                        formKonfirmasi.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan PIN sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-3">Silahkan coba beberapa saat lagi.</p>'
                            );

                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-3">PIN yang anda masukan salah.</p>'
                                );

                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        formKonfirmasi.on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function () {
                    loader_open();
                },
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'riwayat_order';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'riwayat_order';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
        });
    });
</script>
<?php include 'view/layout/footer.php'; ?>