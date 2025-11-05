<?php
require_once("../model/classPaket.php");
$obj = new classPaket();

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
                            <input type="hidden" name="gambar_sebelumnya" value="<?=$data->gambar;?>">

                            <?php if($data->gambar<>''){ ?>
                            <label for="" class="col-sm-3 control-label">Icon Sebelumnya</label>
                            <div class="col-sm-9">
                                <img src="../images/paket/<?=$data->gambar?>" width="100">
                            </div>
                            <?php }?>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Ganti Icon</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Nama <?=$lang['paket']?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                    placeholder="masukkan nama paket" value="<?=$data->nama_paket;?>"
                                    required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Syarat Poin</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="poin" value="<?=$data->poin?>" required="required" id="poin">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Syarat <?=$lang['sponsori']?></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="sponsori" value="<?=$data->sponsori;?>"
                                    required="required" id="sponsori">
                            </div>
                        </div>
                        <div class="bottom">
                        <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Update</button>
                        </div>
                        

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>