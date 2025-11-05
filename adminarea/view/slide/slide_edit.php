<?php 
$id = base64_decode($_GET['id']);
require_once('../model/classSlide.php');
$obj = new classSlide();
$data = $obj->edit($id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/slide/slide_edit.php" method="post" name="formSlide"
                    id="formSlide">
                    <input type="hidden" name="id" value="<?=base64_encode($data->id)?>">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <img src="../images/slide_show/<?=$data->gambar?>" alt="" width="100%">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Ganti Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="url" placeholder="" required="required"
                                    id="url" value="<?=$data->url?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Urutan Tampil</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="ordering" placeholder="" required="required"
                                    id="ordering" value="<?=$data->ordering?>">
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
                        <div class="bottom">
                            <a href="<?=site_url('slide')?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan"
                                name="update_slide"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>