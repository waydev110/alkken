<form class="form-horizontal" enctype="multipart/form-data" action="controller/<?=$mod_url?>/<?=$mod_url?>_edit.php"
    method="post" id="formEdit">
    <div class="box-body">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="username" id="username" value="<?=$data->username?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="password" id="password" value="<?=base64_decode($data->password)?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Ulangi Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="ulangi_password" id="ulangi_password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right" id="btnSubmit"><i class="fa fa-save"></i>
                Update</button>
            </div>
        </div>
    </div>
</form>