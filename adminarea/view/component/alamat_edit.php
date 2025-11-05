<?php
require_once("../model/classProvinsi.php");
$classProvinsi = new classProvinsi();
$provinsi = $classProvinsi->index();

require_once("../model/classKota.php");
$classKota = new classKota();
$kota = $classKota->index();

require_once("../model/classKecamatan.php");
$classKecamatan = new classKecamatan();
$kecamatan = $classKecamatan->index();

require_once("../model/classKelurahan.php");
$classKelurahan = new classKelurahan();
$kelurahan = $classKelurahan->index();
?>
<div class="form-group">
    <label for="id_provinsi" class="col-sm-3 control-label">Provinsi</label>
    <div class="col-sm-9">
        <select class="form-control select2" id="id_provinsi" name="id_provinsi">
            <option value="">Pilih Provinsi</option>
            <?php while ($row = $provinsi->fetch_object()) {?>
            <option value="<?=$row->id?>" <?=$data->id_provinsi == $row->id ? 'selected="selected"':''?>><?=$row->nama_provinsi?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kota" class="col-sm-3 control-label">Kabupaten/Kota</label>
    <div class="col-sm-9">
        <select class="select2 form-control" id="id_kota" name="id_kota">
            <option value="">Pilih Kab/Kota</option>
            <?php while ($row = $kota->fetch_object()) {?>
            <option value="<?=$row->id?>" <?=$member->id_kota == $row->id ? 'selected="selected"' : ''?>>
                <?=$row->nama_kota?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kecamatan" class="col-sm-3 control-label">Kecamatan</label>
    <div class="col-sm-9">
        <select class="select2 form-control" id="id_kecamatan" name="id_kecamatan">
            <option value="">Pilih Kecamatan</option>
            <?php while ($row = $kecamatan->fetch_object()) {?>
            <option value="<?=$row->id?>" <?=$member->id_kecamatan == $row->id ? 'selected="selected"' : ''?>>
                <?=$row->nama_kecamatan?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kelurahan" class="col-sm-3 control-label">Kelurahan</label>
    <div class="col-sm-9">
        <select class="select2 form-control" id="id_kelurahan" name="id_kelurahan">
            <option value="">Pilih Kelurahan</option>
            <?php while ($row = $kelurahan->fetch_object()) {?>
            <option value="<?=$row->id?>" <?=$member->id_kelurahan == $row->id ? 'selected="selected"' : ''?>>
                <?=$row->nama_kelurahan?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="rt" class="col-sm-3 control-label">RT</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="rt" name="rt" value="">
    </div>
</div>
<div class="form-group">
    <label for="rt" class="col-sm-3 control-label">RW</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="rw" name="rw" value="">
    </div>
</div>
<div class="form-group">
    <label for="kodepos" class="col-sm-3 control-label">Kodepos</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="kodepos" name="kodepos" value="<?=$member->kodepos_member?>">
    </div>
</div>
<div class="form-group">
    <label for="alamat" class="col-sm-3 control-label">Alamat</label>
    <div class="col-sm-9">
        <textarea class="form-control" id="alamat" name="alamat"><?=$member->alamat_member?></textarea>
    </div>
</div>
<?php require_once("view/component/alamat_js.php"); ?>