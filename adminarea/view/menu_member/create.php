<?php 
require_once('../model/classMenu.php');
$cmenu = new classMenu();
$kategori_menu = $cmenu->kategori_menu();
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Tambah <?=$title?></h3>
            </div>
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/<?=$mod_url?>/create.php" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Icon</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Kategori Menu</label>
                            <div class="col-sm-10">
                            <select class="form-control" name="id_kategori" id="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php
                                while($row = $kategori_menu->fetch_object()){
                                ?>
                                <option value="<?=$row->id?>"><?=$row->kategori?></option>
                                <?php
                                }
                                ?>
                            </select>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nama Menu</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" placeholder="" required="required"
                                    id="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="url" placeholder="" required="required"
                                    id="url">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Urutan Tampil</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="ordering" placeholder="" required="required"
                                    id="ordering">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Dashboard</label>
                            <div class="col-sm-10">
                                <select name="home_menu" class="form-control select2" id="home_menu"
                                    required="required">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Tampilkan di Paket NetSpin</label>
                            <div class="col-sm-10">
                                <select name="show_netspin" class="form-control select2" id="show_netspin"
                                    required="required">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" name="create"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>