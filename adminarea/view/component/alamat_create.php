<?php
require_once("../model/classProvinsi.php");
$cpv = new classProvinsi();
$provinsi = $cpv->index();
?>
<div class="form-group">
    <label for="id_provinsi" class="col-sm-3 control-label">Provinsi</label>
    <div class="col-sm-9">
        <select class="form-control select2" id="id_provinsi" name="id_provinsi">
            <option value="">Pilih Provinsi</option>
            <?php while ($row = $provinsi->fetch_object()) {?>
            <option value="<?=$row->id?>">
                <?=$row->nama_provinsi?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kota" class="col-sm-3 control-label">Kabupaten/Kota</label>
    <div class="col-sm-9">
        <select class="select2 form-control" id="id_kota" name="id_kota">
            <option value="">Pilih Kab/Kota</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kecamatan" class="col-sm-3 control-label">Kecamatan</label>
    <div class="col-sm-9">
        <select class="select2 form-control" id="id_kecamatan" name="id_kecamatan">
            <option value="">Pilih Kecamatan</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kelurahan" class="col-sm-3 control-label">Kelurahan</label>
    <div class="col-sm-9">
        <select class="select2 form-control" id="id_kelurahan" name="id_kelurahan">
            <option value="">Pilih Kelurahan</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="rt" class="col-sm-3 control-label">RT/RW</label>
    <div class="col-sm-2">
        <div class="input-group">
            <input type="text" class="form-control" id="rt" name="rt" placeholder="000" value="">
            <span class="input-group-addon">/</span>
            <input type="text" class="form-control" id="rw" name="rw" placeholder="000" value="">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="kodepos" class="col-sm-3 control-label">Kodepos</label>
    <div class="col-sm-2">
        <input type="text" class="form-control" id="kodepos" name="kodepos" value="">
    </div>
</div>
<div class="form-group">
    <label for="alamat" class="col-sm-3 control-label">Alamat</label>
    <div class="col-sm-9">
        <textarea class="form-control" id="alamat" name="alamat"></textarea>
    </div>
</div>
<?php require_once("view/component/alamat_js.php"); ?>