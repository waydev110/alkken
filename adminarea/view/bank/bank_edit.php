<?php
require_once("../model/classBank.php");
$obj = new classBank();

$id = base64_decode($_GET['id']);
$data= $obj->show($id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$title?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/<?=$mod_url?>/bank_edit.php" method="post">
                    <input type="hidden" name="id" value="<?=$data->id?>">
                    <input type="hidden" name="logo_sebelumnya" value="<?=$data->logo?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Logo</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="logo" id="logo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Nama Bank</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_bank" name="nama_bank" required="required" value="<?=$data->nama_bank?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Kode Bank</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kode_bank" name="kode_bank" required="required" value="<?=$data->kode_bank?>">
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan" name="simpan"><i
                                    class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../assets/plugins/ckeditor4_basic/ckeditor.js"></script>
<script>

</script>