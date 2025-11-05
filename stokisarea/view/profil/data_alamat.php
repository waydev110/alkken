<form class="form-horizontal" enctype="multipart/form-data" action="controller/<?=$mod_url?>/<?=$mod_url?>_edit.php"
    method="post" id="formEdit">
    <div class="box-body">
        <?php require_once("view/component/alamat_edit.php"); ?>
        <div class="form-group">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right" id="btnSubmit"><i class="fa fa-save"></i>
                Update</button>
            </div>
        </div>
    </div>
</form>