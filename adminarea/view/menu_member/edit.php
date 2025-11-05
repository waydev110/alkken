<?php 
$id = base64_decode($_GET['id']);
require_once('../model/classMenu.php');
$obj = new classMenu();
$kategori_menu = $obj->kategori_menu(); // Pastikan ini menggunakan objek yang benar ($obj)
$data = $obj->show($id); // Ambil data berdasarkan $id
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit <?=$title?></h3>
            </div>
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/<?=$mod_url?>/edit.php" method="post">
                    <div class="box-body">
                        <!-- Hidden input for the ID -->
                        <input type="hidden" name="id" value="<?=$id?>">

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Icon</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" id="gambar">
                                <!-- Tampilkan gambar jika ada -->
                                <?php if (!empty($data->icon)) { ?>
                                    <img src="../images/icons/<?=$data->icon?>" alt="Icon" width="100">
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Kategori Menu</label>
                            <div class="col-sm-10">
                            <select class="form-control" name="id_kategori" id="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php
                                while($row = $kategori_menu->fetch_object()){
                                    $selected = ($row->id == $data->id_kategori) ? 'selected' : ''; // Untuk menandai kategori yang terpilih
                                ?>
                                <option value="<?=$row->id?>" <?=$selected?>><?=$row->kategori?></option>
                                <?php
                                }
                                ?>
                            </select>    
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nama Menu</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="<?=$data->name?>" required="required" id="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="url" value="<?=$data->url?>" required="required" id="url">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Urutan Tampil</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="ordering" value="<?=$data->ordering?>" required="required" id="ordering">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Dashboard</label>
                            <div class="col-sm-10">
                                <select name="home_menu" class="form-control select2" id="home_menu" required="required">
                                    <option value="1" <?=($data->home_menu == 1) ? 'selected' : ''?>>Ya</option>
                                    <option value="0" <?=($data->home_menu == 0) ? 'selected' : ''?>>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Tampilkan di Paket NetSpin</label>
                            <div class="col-sm-10">
                                <select name="show_netspin" class="form-control select2" id="show_netspin"
                                    required="required">
                                    <option value="1" <?=($data->show_netspin == 1) ? 'selected':''?> >Ya</option>
                                    <option value="0" <?=($data->show_netspin == 0) ? 'selected':''?>>Tidak</option>
                                </select>
                            </div>
                        </div>

                        <div class="bottom">
                            <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" name="update"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
