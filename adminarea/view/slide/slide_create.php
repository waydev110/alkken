<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/slide/slide_create.php" method="post" name="formSlide"
                    id="formSlide">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="url" placeholder="" required="required"
                                    id="url">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ordering" class="col-sm-2 control-label">Urutan Tampil</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="ordering" placeholder="" required="required"
                                    id="ordering">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="publish_status" class="col-sm-2 control-label">Terbitkan</label>
                            <div class="col-sm-10">
                                <select name="publish_status" class="form-control select2" id="publish_status"
                                    required="required">
                                    <option value="Y">Ya</option>
                                    <option value="N">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="<?=site_url('slide')?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan"
                                name="simpan_slide"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>