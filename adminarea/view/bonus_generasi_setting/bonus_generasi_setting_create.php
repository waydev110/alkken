<?php
require_once("../model/classBonusGenerasiSetting.php");
$obj = new classBonusGenerasiSetting();
require_once("../model/classPlan.php");
$cpl = new classPlan();
$plan = $cpl->index();
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
                    action="controller/<?=$mod_url?>/<?=$mod_url?>_create.php" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plan</label>
                            <div class="col-sm-9">
                                <select name="id_plan" class="form-control select2" id="id_plan" required="required">
                                    <option>-- Pilih Plan --</option>
                                    <?php
                                    while($row = $plan->fetch_object()){
                                    ?>
                                    <option value="<?=$row->id?>"><?=$row->nama_plan?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Maksimal Generasi</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="max" id="max" required="required">
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