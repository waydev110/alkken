<?php 
    require_once("../model/classSlide.php");
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Slide</h3>
        <a href="?go=slide_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah</a>

    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php 
      if(isset($_GET['stat'])){
        if($_GET['stat']== 1){
          ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <?=ucwords($_GET['msg']);?> Slide berhasil disimpan.
        </div>
        <?php
        }else{
          ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            <?=ucwords($_GET['msg']);?> Slide gagal disimpan.
        </div>
        <?php
        }
      }
    ?>
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>URL</th>
                        <th>Urutan Tampil</th>
                        <th>Status Terbit</th>
                        <th>Penulis</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $cp = new classSlide();
                        $result = $cp->index();
                        $no = 0;
                        while ($row = $result->fetch_object()){
                        $no++;
                    ?>
                    <tr>
                        <td><?=$no?></td>
                        <td class="text-center"><img src="../images/slide_show/<?=$row->gambar?>" height="30"></td>
                        <td><?=$row->url?></td>
                        <td><?=$row->ordering?></td>
                        <td><?=$row->publish_status?></td>
                        <td><?=$row->penulis?></td>
                        <td class="text-center">
                            <a href="index.php?go=slide_edit&id=<?=base64_encode($row->id)?>"
                                class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                            <form action="controller/slide/slide_delete.php" method="post" accept-charset="utf-8"
                                class="inline">
                                <input type="hidden" name="id" value="<?=base64_encode($row->id)?>">
                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>URL</th>
                        <th>Urutan Tampil</th>
                        <th>Status Terbit</th>
                        <th>Penulis</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>