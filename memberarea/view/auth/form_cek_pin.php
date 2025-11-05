<div class="main-container container pt-4" style="display:none" id="blockNextForm">
    <div class="row">
        <div class="col-12 mb-3">
            <h5 class="text-center mb-2">Verifikasi</h5>
            <p class="text-center mb-2">Masukan PIN anda.</p>
        </div>
    </div>
    <form action="controller/auth/cek_pin.php" id="formCekPIN" method="post">
        <!-- <div class="d-flex mb-4">
            <input type="number" class="form-control text-center mx-2 py-3 input_pin" name="old_pin1" required="required"
                maxlength="1">
            <input type="number" class="form-control text-center mx-2 py-3 input_pin" name="old_pin2" required="required"
                maxlength="1">
            <input type="number" class="form-control text-center mx-2 py-3 input_pin" name="old_pin3" required="required"
                maxlength="1">
            <input type="number" class="form-control text-center mx-2 py-3 input_pin" name="old_pin4" required="required"
                maxlength="1">
        </div> -->
        <div class="col-6 mb-3 offset-3">
            <input type="text" class="form-control text-center py-3" name="cek_pin" required="required">
        </div>
        <div class="col-6 d-grid offset-3">
            <button class="btn btn-default btn-lg btn-block rounded-pill" id="btnSubmitPIN">Submit</button>
        </div>
    </form>
    <!-- <div class="row">
        <div class="col-12 mb-3 text-center">
            <a href="#" class="size-13" id="btnChangeFormPIN">Tidak bisa input pin?</a>
        </div>
    </div> -->
</div>