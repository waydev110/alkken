<?php 
$id = base64_decode($_GET['id']);
require_once('../model/classPengumuman.php');
$obj = new classPengumuman();
$data = $obj->edit($id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/pengumuman/pengumuman_edit.php" method="post" name="formPengumuman"
                    id="formPengumuman">
                    <input type="hidden" name="id" value="<?=base64_encode($data->id)?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Judul</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="judul" placeholder="" required="required"
                                    id="judul" value="<?=$data->judul?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <img src="../images/pengumuman/<?=$data->gambar?>" alt="" width="100%">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Ganti Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Isi</label>
                            <div class="col-sm-10">
                                <textarea class="form-control ckeditor" id="ckeditor" name="isi" placeholder=""
                                    required="required">
                                    <?=$data->isi?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Lokasi</label>
                            <div class="col-sm-10">
                                <select name="lokasi" class="form-control select2" id="lokasi">
                                    <option value="">Pilih Lokasi Popup</option>
                                    <option value="Login Member" <?=$data->lokasi == 'Login Member' ? 'selected':'' ?>>
                                        Login Member</option>
                                    <option value="Dashboard Member"
                                        <?=$data->lokasi == 'Dashboard Member' ? 'selected':'' ?>>Dashboard Member
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Terbitkan</label>
                            <div class="col-sm-10">
                                <select name="publish_status" class="form-control select2" id="publish_status"
                                    required="required">
                                    <option value="Y" <?=$data->publish_status == 'Y' ? 'selected':'' ?>>Ya</option>
                                    <option value="N" <?=$data->publish_status == 'N' ? 'selected':'' ?>>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Terbitkan Mulai (optional)</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control datepicker" name="publish_start"
                                    id="publish_start" value="<?=date('d/m/Y', strtotime($data->publish_start))?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Terbitkan Sampai (optional)</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control datepicker" name="publish_end" id="publish_end"
                                    value="<?=date('d/m/Y', strtotime($data->publish_end))?>">
                            </div>
                        </div>
                        <div class="bottom">
                            <button type="button" class="btn btn-default" onclick="history.back()"> <i class="fa fa-arrow-left"></i>
                                Kembali</button>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan"
                                name="update_pengumuman"><i class="fa fa-save"></i> Update</button>
                        </div>
                        <!--/form-group-->

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../assets/plugins/ckeditor4_basic/ckeditor.js"></script>
<script>
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
</script>