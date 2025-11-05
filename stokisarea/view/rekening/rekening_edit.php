<?php
require_once '../model/classRekening.php';
require_once '../model/classBank.php';
$obj = new classRekening();
$cb = new classBank();

$id = base64_decode($_GET['id']);
$data= $obj->show($id);
$result_bank = $cb->index();
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
                    action="controller/<?=$mod_url?>/rekening_edit.php" method="post">
                    <input type="hidden" name="id" value="<?=$data->id?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="id_bank" class="col-sm-3 control-label">Bank</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="id_bank" name="id_bank" required="required">
                                    <?php
                                    while($row = $result_bank->fetch_object()){
                                    ?>
                                    <option value="<?=$row->id?>" <?=$data->id_bank == $row->id ? 'selected' : ''?>><?=$row->nama_bank?></option>
                                    <?php
                                    }
                                    ?>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_rekening" class="col-sm-3 control-label">No Rekening</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_rekening" name="no_rekening" required="required" value="<?=$data->no_rekening?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="atas_nama_rekening" class="col-sm-3 control-label">Atas Nama</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="atas_nama_rekening" name="atas_nama_rekening" required="required" value="<?=$data->atas_nama_rekening?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cabang_rekening" class="col-sm-3 control-label">Cabang</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="cabang_rekening" name="cabang_rekening" required="required" value="<?=$data->cabang_rekening?>">
                            </div>
                        </div>
                        <div class="bottom">
                        <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnUpdate" name="update"><i
                                    class="fa fa-save"></i> Update</button>
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