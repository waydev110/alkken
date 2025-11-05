<?php 
$id = base64_decode($_GET['id']);
require_once('../model/classBerita.php');
$obj = new classBerita();
$data = $obj->edit($id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header text-right">
                <a href="?go=berita_list" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Kembali</a>
            </div>
            <div class="box-body box-profile">
                <img src="../images/berita/<?=$data->gambar?>" alt="" width="100%">
                <h3><?=$data->judul?></h3>
                <?=$data->isi?>
            </div>
        </div>
    </div>
</div>