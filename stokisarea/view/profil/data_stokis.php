<form class="form-horizontal" enctype="multipart/form-data" action="controller/<?=$mod_url?>/<?=$mod_url?>_edit.php"
    method="post" id="formEdit">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label">Pilih Paket</label>
        <div class="col-sm-10">
            <input type="text" value="<?=$paket_stokis?>" class="form-control" disabled>
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-2 control-label">Nama Stokis</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nama_stokis" name="nama_stokis" value="<?=$data->nama_stokis?>">
        </div>
    </div>
    <div class="form-group">
        <label for="no_handphone" class="col-sm-2 control-label">No WhatsApp</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="no_handphone" id="no_handphone"
                value="<?=$data->no_handphone?>">
            <span class="text-danger size-12" id="error_hp"></span>
            <span class="text-success size-12" id="valid_hp"></span>
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="email" id="email" value="<?=$data->email?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary pull-right" id="btnSubmit"><i class="fa fa-save"></i>
            Update</button>
        </div>
    </div>
</form>