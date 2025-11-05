<?php
require_once("../helper/language.php");
require_once("../model/classAdmin.php");

$obj = new classAdmin();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $data = $obj->show($id);
} else {
    exit();
}

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
                    action="controller/<?=$mod_url?>/edit.php" method="post">
                    <input type="hidden" name="id" value="<?=$data->id?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Level Admin</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="level_admin" name="level_admin" required="required">
                                    <option>-- Pilih Level Admin --</option>
                                    <?php
                                    foreach($arr_level_admin as $index => $value ){
                                    ?>
                                    <option value="<?=$index?>" <?=$data->level_admin == $index ? 'selected':''?>><?=$value?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Nama User</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_admin" id="nama_admin" value="<?=$data->nama_admin?>" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="user_admin" id="user_admin" value="<?=$data->user_admin?>" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pass_admin" id="pass_admin" value="<?=base64_decode($data->pass_admin)?>" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Status Admin</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="status_admin" name="status_admin" required="required">
                                    <option>-- Pilih Status Admin --</option>
                                    <option value="1" <?=$data->status_admin == 1 ? 'selected':''?>>Aktif</option>
                                    <option value="0" <?=$data->status_admin == 0 ? 'selected':''?>>Blokir</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan" name="simpan"><i
                                    class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>