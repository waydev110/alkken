<?php
require_once("../model/classStokisPaket.php");
$obj = new classStokisPaket();

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
                    action="controller/<?=$mod_url?>/<?=$mod_url?>_edit.php" method="post">
                    <input type="hidden" name="id" value="<?=$data->id?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Nama Paket</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_paket" name="nama_paket" required="required" value="<?=$data->nama_paket?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Kode ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="kode_id" id="kode_id" required="required" value="<?=$data->kode_id?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Harga</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric" name="harga_paket" id="harga_paket" required="required" value="<?=$data->harga_paket?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Persentase Fee</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="persentase_fee" id="persentase_fee" required="required" value="<?=$data->persentase_fee?>">
                                    <span class="input-group-addon">%</span>
                                </div>
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