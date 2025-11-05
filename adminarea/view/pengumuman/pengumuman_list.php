<?php 
    require_once("../model/classPengumuman.php");
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Pengumuman</h3>
        <a href="?go=pengumuman_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
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
            <?=ucwords($_GET['msg']);?> Pengumuman berhasil disimpan.
        </div>
        <?php
        }else{
          ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            <?=ucwords($_GET['msg']);?> Pengumuman gagal disimpan.
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
                        <th>Judul</th>
                        <th>Lokasi</th>
                        <th>Status Terbit</th>
                        <th>Mulai Tanggal</th>
                        <th>Sampai Tanggal</th>
                        <th>Penulis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $cp = new classPengumuman();
                        $result = $cp->index();
                        $no = 0;
                        while ($row = $result->fetch_object()){
                        $no++;
                    ?>
                    <tr>
                        <td><?=$no?></td>
                        <td><?=$row->judul?></td>
                        <td><?=$row->lokasi?></td>
                        <td><?=$row->publish_status?></td>
                        <td><?=tgl_indo($row->publish_start)?></td>
                        <td><?=tgl_indo($row->publish_end)?></td>
                        <td><?=$row->penulis?></td>
                        <td>
                            <a onclick="show('<?=base64_encode($row->id)?>')" class="btn btn-info btn-xs"><i
                                    class="fa fa-eye"></i></a>
                            <a href="index.php?go=pengumuman_edit&id=<?=base64_encode($row->id)?>"
                                class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                            <form action="controller/pengumuman/pengumuman_delete.php" method="post" accept-charset="utf-8"
                                class="inline">
                                <input type="hidden" name="id" value="<?=base64_encode($row->id)?>">
                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
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
                        <th>Judul</th>
                        <th>Lokasi</th>
                        <th>Status Terbit</th>
                        <th>Mulai Tanggal</th>
                        <th>Sampai Tanggal</th>
                        <th>Penulis</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>