<?php 
$id = base64_decode($_GET['id']);
require_once("../model/classSpinReward.php");
$obj = new classSpinReward();
$data = $obj->edit($id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/<?=$mod_url?>/edit.php" method="post">
                    <input type="hidden" name="id" value="<?=base64_encode($data->id)?>">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <img src="../images/spin_reward/<?=$data->gambar?>" alt="" width="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reward" class="col-sm-2 control-label">Nama Reward</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="reward" placeholder="" required="required"
                                    id="reward" value="<?=$data->reward?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nominal" class="col-sm-2 control-label">Nominal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control autonumeric3" name="nominal" placeholder="" required="required"
                                    id="nominal" value="<?=$data->nominal?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bobot" class="col-sm-2 control-label">Bobot</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control autonumeric3" name="bobot" placeholder="" required="required"
                                    id="bobot" value="<?=$data->bobot?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="persentase_peluang" class="col-sm-2 control-label">Persentase Peluang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control autonumeric5" name="persentase_peluang" placeholder="" required="required"
                                    id="persentase_peluang" value="<?=$data->persentase_peluang?>">
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="<?=site_url($mod_url)?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan"
                                name="update"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>