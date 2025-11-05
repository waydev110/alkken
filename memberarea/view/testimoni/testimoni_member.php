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
    <header class="header position-fixed bg-theme" id="blockHeader">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?= $title ?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <div class="row">
            <div class="testimoni-list">
            </div>
            <div class="load-list" display="none">
                <div class="col-12">
                    <div class="row px-3">
                        <button class="btn btn-default rounded-pill" id="btnMore" onclick="get_testimoni(0)">Load More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main page content ends -->
<?php include 'view/auth/form_cek_pin.php'; ?>
</main><!-- Footer -->
<footer class="footer" id="blockFooter">
    <div class="container">
        <div class="row pt-3 px-3 pb-3">
            <form action="controller/testimoni/create_testimoni.php" method="post" id="frmTestimoni">
                <div class="col-12">
                    <div class="form-group mb-1 pb-0">
                        <textarea class="form-control" id="testimoni" name="testimoni" placeholder="Add a testimoni..." rows="3"></textarea>
                    </div>
                </div>
                <div class="col-12 text-end">
                    <button type="reset" class="btn btn-light rounded-pill">Reset</button>
                    <button type="button" class="btn btn-default rounded-pill" id="btnSubmitTestimoni">Submit</button>
                </div>
            </form>
        </div>
    </div>
</footer>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        get_testimoni(0, null);
        var blockHeader = $('#blockHeader');
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var frmTestimoni = $('#frmTestimoni');
        var formCekPIN = $('#formCekPIN');
        var blockFooter = $('#blockFooter');
        var btnSubmitTestimoni = $('#btnSubmitTestimoni');

        btnSubmitTestimoni.on("click", function(e) {
            if (frmTestimoni.valid()) {
                blockFirstForm.hide();
                blockFooter.hide();
                blockNextForm.show();
            }
            e.preventDefault();
        });

        frmTestimoni.validate({
            rules: {
                testimoni: {
                    required: true,
                    minlength: 50
                }
            },
            messages: {
                testimoni: {
                    required: "Testimoni tidak boleh kosong.",
                    minlength: "Testimoni minimal 50 karakter."
                }
            }
        });

        formCekPIN.on("submit", function(e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function(result) {
                    if (result == true) {
                        frmTestimoni.submit();
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

        frmTestimoni.on("submit", function(e) {
            e.preventDefault();
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function() {
                    loader_open();
                },
                success: function(result) {
                    blockFirstForm.show();
                    blockNextForm.hide();
                    blockFooter.show();
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        document.location = "index.php?go=testimoni";
                    } else {
                        infoText(obj.message);
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
        });
    });

    function showComment(e, id) {
        $('#' + id).show();
        $(e).remove();
    }

    function get_testimoni(start = 0, e) {
        $.ajax({
            type: 'POST',
            url: 'controller/testimoni/get_testimoni.php',
            data: {
                start: start
            },
            beforeSend: function() {
                loader_open();
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    if (start == 0) {
                        $('.testimoni-list').html(obj.html);
                    } else {
                        $('.testimoni-list').append(obj.html);
                    }
                    if (obj.count > 0) {
                        $('.load-list').show();
                        $('#btnMore').attr('onclick', `get_testimoni('${obj.start}')`);
                    } else {
                        $('.load-list').hide();
                    }
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