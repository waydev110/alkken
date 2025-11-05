<?php
require_once '../model/classProvinsi.php';
$classProvinsi = new classProvinsi();
$provinsi = $classProvinsi->index();

require_once '../model/classKota.php';
$classKota = new classKota();
$kota = $classKota->get_kota($data->id_provinsi);

require_once '../model/classKecamatan.php';
$classKecamatan = new classKecamatan();
$kecamatan = $classKecamatan->get_kecamatan($data->id_kota);

require_once '../model/classKelurahan.php';
$classKelurahan = new classKelurahan();
$kelurahan = $classKelurahan->get_kelurahan($data->id_kecamatan);
?>
<div class="form-group">
    <label for="id_provinsi" class="col-sm-2 control-label">Provinsi</label>
    <div class="col-sm-10">
        <select class="form-control" id="id_provinsi" name="id_provinsi">
            <option value="">Pilih Provinsi</option>
            <?php while ($row = $provinsi->fetch_object()) {?>
            <option value="<?=$row->id?>" <?=$data->id_provinsi == $row->id ? 'selected="selected"' : ''?>><?=$row->nama_provinsi?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kota" class="col-sm-2 control-label">Kabupaten/Kota</label>
    <div class="col-sm-10">
        <select class="form-control" id="id_kota" name="id_kota">
            <option value="">Pilih Kab/Kota</option>
            <?php while ($row = $kota->fetch_object()) {?>
            <option value="<?=$row->id?>" <?=$data->id_kota == $row->id ? 'selected="selected"' : ''?>>
                <?=$row->nama_kota?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kecamatan" class="col-sm-2 control-label">Kecamatan</label>
    <div class="col-sm-10">
        <select class="form-control" id="id_kecamatan" name="id_kecamatan">
            <option value="">Pilih Kecamatan</option>
            <?php while ($row = $kecamatan->fetch_object()) {?>
            <option value="<?=$row->id?>" <?=$data->id_kecamatan == $row->id ? 'selected="selected"' : ''?>>
                <?=$row->nama_kecamatan?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="id_kelurahan" class="col-sm-2 control-label">Kelurahan</label>
    <div class="col-sm-10">
        <select class="form-control" id="id_kelurahan" name="id_kelurahan">
            <option value="">Pilih Kelurahan</option>
            <?php while ($row = $kelurahan->fetch_object()) {?>
            <option value="<?=$row->id?>" <?=$data->id_kelurahan == $row->id ? 'selected="selected"' : ''?>>
                <?=$row->nama_kelurahan?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="rt" class="col-sm-2 control-label">RT</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="rt" name="rt" value="">
    </div>
</div>
<div class="form-group">
    <label for="rt" class="col-sm-2 control-label">RW</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="rw" name="rw" value="">
    </div>
</div>
<div class="form-group">
    <label for="kodepos" class="col-sm-2 control-label">Kodepos</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="kodepos" name="kodepos" value="<?=$data->kodepos?>">
    </div>
</div>
<div class="form-group">
    <label for="alamat" class="col-sm-2 control-label">Alamat</label>
    <div class="col-sm-10">
        <textarea class="form-control" id="alamat" name="alamat"><?=$data->alamat?></textarea>
    </div>
</div>
<?php require_once("view/component/alamat_js.php"); ?>