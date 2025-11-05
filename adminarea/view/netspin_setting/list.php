<?php 
    require_once("../model/classSpinReward.php");
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Setting <?=$title?></h3>
        <a href="?go=<?=$mod_url?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
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
            <?=ucwords($_GET['msg']);?> <?=$title?> berhasil disimpan.
        </div>
        <?php
        }else{
          ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            <?=ucwords($_GET['msg']);?> <?=$title?> gagal disimpan.
        </div>
        <?php
        }
      }
    ?>
        <div class="table-responsive">
            <table id="spin_reward" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Reward</th>
                        <th>Nominal</th>
                        <th>Bobot</th>
                        <th>Persentase Peluang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $cp = new classSpinReward();
                        $result = $cp->index();
                        $no = 0;
                        while ($row = $result->fetch_object()){
                        $no++;
                    ?>
                    <tr>
                        <td><?=$no?></td>
                        <td class="text-center"><img src="../images/spin_reward/<?=$row->gambar?>" height="30"></td>
                        <td><?=$row->reward?></td>
                        <td class="text-right"><?=rp($row->nominal)?></td>
                        <td class="text-center"><?=$row->bobot?></td>
                        <td class="text-center"><?=decimal4($row->persentase_peluang)?></td>
                        <td class="text-center">
                            <a href="index.php?go=<?=$mod_url?>_edit&id=<?=base64_encode($row->id)?>"
                                class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                            <form action="controller/<?=$mod_url?>/delete.php" method="post" accept-charset="utf-8"
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
            </table>
        </div>
    </div>
</div>