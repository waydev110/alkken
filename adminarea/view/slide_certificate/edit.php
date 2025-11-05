<?php 
$id = base64_decode($_GET['id']);
require_once('../model/classSlideCertificate.php');
$obj = new classSlideCertificate();
$data = $obj->edit($id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Slide Certificate</h3>
            </div>
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/slide_certificate/edit.php" method="post" name="formSlide"
                    id="formSlide">
                    <input type="hidden" name="id" value="<?=base64_encode($data->id)?>">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <img src="../images/slide_certificate/<?=$data->gambar?>" alt="" width="100%">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Ganti Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
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
                            <a href="?go=slide_certificate" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan"
                                name="update_slide"><i class="fa fa-save"></i> Update</button>
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