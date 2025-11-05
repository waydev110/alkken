<?php 
$id = base64_decode($_GET['id']);
require_once('../model/classSlideCertificate.php');
$obj = new classSlideCertificate();
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Tambah Slide Certificate</h3>
            </div>
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/slide_certificate/create.php" method="post" name="formSlide"
                    id="formSlide">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Urutan Tampil</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="ordering" placeholder="" required="required"
                                    id="ordering">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Terbitkan</label>
                            <div class="col-sm-10">
                                <select name="publish_status" class="form-control select2" id="publish_status"
                                    required="required">
                                    <option value="Y">Ya</option>
                                    <option value="N">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="?go=slide_certificate" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan"
                                name="simpan_slide"><i class="fa fa-save"></i> Simpan</button>
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