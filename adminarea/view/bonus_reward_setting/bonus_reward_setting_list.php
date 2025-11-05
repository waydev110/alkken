<?php
    require_once("../model/classBonusRewardSetting.php");
    $obj = new classBonusRewardSetting();    
    $query = $obj->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah</a>
    </div>
    <div class="box-body">
        <?php 
        if(isset($_GET['stat'])){
          if($_GET['stat']== 1){
            ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Info!</h4>
            <?=ucwords($_GET['msg']);?> sukses
        </div>
        <?php
          }else{
            ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Info!</h4>
            <?=ucwords($_GET['msg']);?> gagal
        </div>
        <?php
          }
        }
      ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="example1">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Plan</th>
                        <th class="text-center">Gambar</th>
                        <th class="text-center">Reward</th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Poin</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                $no = 1;
                while ($row= $query->fetch_object()) {
                ?>
                    <tr>
                        <td align="center"><?=$no;?></td>
                        <td align="left"><?=$row->nama_plan?></td>
                        <td class="text-center">
                            <img src="../images/reward/<?=$row->gambar?>" height="30">
                        </td>
                        <td align="right"><?=$row->reward?></td>
                        <td align="right"><?=currency($row->nominal)?></td>
                        <td align="right"><?=$row->poin?></td>
                        <td align="center">
                            <a href='index.php?go=<?=$mod_url?>_edit&id="<?=base64_encode($row->id)?>"'
                                class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a>
                        </td>
                    </tr>
                    <?php
                $no++;
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Plan</th>
                        <th class="text-center">Gambar</th>
                        <th class="text-center">Reward</th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Poin</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>