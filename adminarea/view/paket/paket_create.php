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
                            <label for="" class="col-sm-3 control-label">Icon</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Nama <?=$lang['paket']?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                    required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Syarat Poin</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="poin" required="required" id="poin">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Syarat <?=$lang['sponsori']?></label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="sponsori"
                                    id="sponsori" required="required">
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