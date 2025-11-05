<?php
require_once '../helper/all_member.php';

$token = create_token();

require_once '../model/classMember.php';
$cm = new classMember();
$member = $cm->detail($session_member_id);

require_once '../model/classKodeAktivasi.php';
$cka = new classKodeAktivasi();
$total_kode_aktivasi = $cka->total_kode_aktivasi($session_member_id, 0);
// $kode_aktivasi = $cka->index_group($session_member_id, '0');
?>

<?php include 'view/layout/header.php'; ?>
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
            <div class="col align-self-center ps-0 text-left pt-1">
                <h5><?= $title ?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4 mb-2" id="blockFirstForm">
        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-body" id="cart_container">
                        <form action="controller/transfer_pin/transfer.php" id="formTransferPIN" method="post">
                            <div class="col mb-2">
                                <h6>Kirim Cepat</h6>
                            </div>
                            <input type="hidden" name="id">
                            <div class="input-group">
                                <input type="hidden" name="go" value="member_order">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-primary" disabled><i class="fa fa-search"></i></button>
                                </div>
                                <input type="text" id="nextForm" class="form-control rounded-5" placeholder="Cari ID Member / User Member">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="blockFirstForm2" style="display:none">
        <div class="row">
            <div class="col">
                <div class="card rounded-0 mb-4">
                    <div class="card-body" id="cart_container">
                        <form action="controller/transfer_pin/transfer.php" id="formTransferPIN" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="id">
                            <div class="row">
                                <div class="col align-self-center">
                                    <div class="input-group form-search-custom">
                                        <input type="hidden" name="go" value="member_order">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-outline-primary" disabled><i class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="id_member" id="member" class="form-control rounded-5" placeholder="Cari ID Member / User Member">
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <button  type="button" id="btnBatal" class="btn btn-transparent">BATAL</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
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
    $(document).ready(function() {
        var nextForm = $('#nextForm');
        var btnBatal = $('#btnBatal');
        var blockFirstForm = $('#blockFirstForm');
        var blockFirstForm2 = $('#blockFirstForm2');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formTransferPIN = $('#formTransferPIN');
        var daftarPIN = $('#daftarPIN');
        var itemPaket = $('#itemPaket');
        var idMember = $('#id_member');
        var btnTransfer = $('#btnTransfer');
        var btnKonfirmasi = $('#btnKonfirmasi');
        var btnKembali = $('#btnKembali');
        var tujuan_transfer = $('#tujuan_transfer');
        var detail = $('#detail');

        $('.autonumeric').autoNumeric('init', {
            "aSep": ".",
            "aDec": ",",
            "mDec": "0",
        });

        idMember.on('change keyup', function() {
            var id_member = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/member/get_nama_member.php',
                data: {
                    id_member: id_member
                },
                beforeSend: function() {},
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $('input[name=id]').val(obj.id);
                        $('input[name=id_member]').val(obj.id_member);
                        $('input[name=nama_member]').val(obj.nama_member);
                        daftarPIN.show();
                        getKodeAktivasi();
                    } else {
                        $('input[name=nama_member]').val(obj.message);
                        daftarPIN.hide();
                    }
                },
                complete: function() {}
            });
        });

        function getKodeAktivasi() {
            $.ajax({
                type: 'POST',
                url: 'controller/transfer_pin/get_pin.php',
                beforeSend: function() {},
                success: function(result) {
                    const obj = JSON.parse(result);
                    console.log(obj.status);
                    if (obj.status == true) {
                        itemPaket.show();
                        $('#kodeList').html(obj.html);
                    } else {
                        $('#kodeList').find('data-item').remove();
                        itemPaket.hide();
                    }
                },
                complete: function() {}
            });
        }

        nextForm.on("focus", function(e) {
            blockFirstForm.hide();
            blockFirstForm2.show();
        });

        btnBatal.on("click", function(e) {
            blockFirstForm2.hide();
            blockFirstForm.show();
        });

        btnTransfer.on("click", function(e) {
            var id = $('input[name=id]').val();
            if (id != "") {
                var e = $(this);
                var dataString = $('#formTransferPIN').serialize();
                $.ajax({
                    type: 'POST',
                    url: 'controller/transfer_pin/cek_transfer.php',
                    data: dataString,
                    beforeSend: function() {
                        btn_proses_start(e);
                    },
                    success: function(result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            detail.html(obj.html);
                            var id_member = $('#id_member').val();
                            var nama_member = $('#nama_member').val();
                            tujuan_transfer.html(`<p class="size-11">${id_member}</p><p class="size-18">${nama_member}</p>`);
                            blockFirstForm.hide();
                            blockFirstForm2.show();
                        } else {
                            Swal.fire({
                                text: `${obj.message}`,
                                customClass: {
                                    confirmButton: 'btn-default rounded-pill px-5'
                                }
                            });
                        }
                    },
                    complete: function() {
                        btn_proses_end(e);
                    }
                });
            } else {
                Swal.fire({
                    text: 'Tujuan transfer belum di pilih. Silahkan masukan ID <?= $lang['member'] ?>.',
                    customClass: {
                        confirmButton: 'btn-default rounded-pill px-5'
                    }
                });
            }
        });

        btnKonfirmasi.on("click", function(e) {
            blockFirstForm2.hide();
            blockNextForm.show();
            $('input[name=old_pin1]').focus();
        });

        btnKembali.on("click", function(e) {
            blockFirstForm2.hide();
            blockFirstForm.show();
        });

        formCekPIN.on("submit", function(e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function(result) {
                    if (result == true) {
                        formTransferPIN.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan <?= $lang['kode_aktivasi'] ?> sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-3">Silahkan coba beberapa saat lagi.</p>'
                            );

                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-3"><?= $lang['kode_aktivasi'] ?> yang anda masukan salah.</p>'
                                );

                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        formTransferPIN.on("submit", function(e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function() {
                    loader_open();
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'riwayat_transfer_pin';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'transfer_pin';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
            e.preventDefault();
        });
    });

    function tambah(id) {
        var qty = parseInt($('#qty' + id).val());
        if (qty >= 0) {
            qty = qty + 1;
            $('#qty' + id).val(qty);
        }
    }

    function kurang(id) {
        var qty = parseInt($('#qty' + id).val());
        if (qty > 0) {
            qty = qty - 1;
            $('#qty' + id).val(qty);
        }
    }
</script>
<?php include 'view/layout/footer.php'; ?>