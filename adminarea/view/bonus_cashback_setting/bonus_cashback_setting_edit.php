<?php
require_once("../model/classBonusCashbackSetting.php");
require_once("../model/classPaket.php");
$obj = new classBonusCashbackSetting();
$cp = new classPaket();

$result_paket = $cp->index();

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
                    <input type="hidden" name="id_paket" value="<?=$data->id_paket?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Pilih <?=$lang['paket']?></label>
                            <div class="col-sm-9">
                            <select class="form-control select2" required="required" disabled>
                                    <option>-- Pilih <?=$lang['paket']?> --</option>
                                    <?php
                                    while($row = $result_paket->fetch_object()){
                                    ?>
                                    <option value="<?=$row->id?>" <?=$data->id_paket == $row->id ? 'selected':''?>><?=$row->nama_paket?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Persentase Bonus</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="persentase_bonus" id="persentase_bonus" required="required" value="<?=$data->persentase_bonus?>">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan" name="simpan"><i
                                    class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>