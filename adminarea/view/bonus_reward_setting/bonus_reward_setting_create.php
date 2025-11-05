<?php
require_once("../model/classBonusRewardSetting.php");
require_once("../model/classPeringkat.php");
$obj = new classBonusRewardSetting();
$cp = new classPeringkat();

$result_peringkat = $cp->index();

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
                            <label for="" class="col-sm-3 control-label">Gambar Reward</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Reward</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reward" id="reward" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Nominal</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric2" name="nominal" value="<?=$data->nominal?>" required="required"
                                        id="nominal">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Peringkat</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="id_peringkat" name="id_peringkat" required="required">
                                    <option>-- Pilih Peringkat --</option>
                                    <?php
                                    while($row = $result_peringkat->fetch_object()){
                                    ?>
                                    <option value="<?=$row->id?>"><?=$row->nama_peringkat?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Poin</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="poin" id="poin" required="required">
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
<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../assets/plugins/ckeditor4_basic/ckeditor.js"></script>
<script>

</script>