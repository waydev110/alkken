<?php
include ("model/classReferall.php");
#include ("model/classSetBonusReferall.php");
#include ("model/classKomisiCashback.php");

$cr = new classReferall();
#$csbr = new classSetBonusReferall();
#$ckc = new classKomisiCashback();
if(isset($_GET['id'])){
  $query = $cr->index(base64_decode($_GET['id']));
}else{
  $query = $cr->index($_SESSION['id_login_member']);  
}

if(!isset($_GET['gen'])){
  $generasi_ke = '1';
}else{
  $generasi_ke = base64_decode($_GET['gen']);
}
#$cek_status_claim = $ckc->cek_status_claim($_SESSION['id_login_member']);
#$data_jum_sponsor = $cr->count_sponsor_cashback($_SESSION['id_login_member']);
#$data_prosentase = $csbr->get_value_bonus('1', 'prosentase');
#$data_syarat = $csbr->get_value_bonus('1', 'syarat_ref');
?>

<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Referal Member</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body box-profile">
          <div class="table-responsive">
            <?php 
            
            if(isset($_GET['stat'])){
              if($_GET['stat']== 1){
                ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info-circle"></i> Info!</h4>
                    <?=ucwords($_GET['msg']);?> bonus sukses
                </div>
                <?php
              }else{
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Info!</h4>
                    <?=ucwords($_GET['msg']);?> bonus gagal
                </div>
                <?php
              }
            }
            ?>
            <table class="table table-bordered" id="example1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID Member</th>
                  <th>Nama Member</th>
                  <th>Paket</th>                  
                  <th>Terdaftar Pada</th>
                  <th>Jumlah Sponsor</th>
                  <th>Generasi ke</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no =1 ;
                while ($data_referal = $query->fetch_object()) {

                  ?>
                    <tr>
                      <td><?=$no;?></td>
                      <td><?=$data_referal->id_member;?></td>
                      <td><?=$data_referal->nama_member;?></td>
                      <td><?=$data_referal->nama_paket;?></td>
                      <td><?=date('d-m-Y', strtotime($data_referal->created_at));?></td>
                      <td><?=$data_referal->jsponsor;?></td>
                      <td><?=$generasi_ke;?></td>                 
                      <td>
                        <a href="?go=generasi_list&id=<?=base64_encode($data_referal->id);?>&gen=<?=base64_encode($generasi_ke+1);?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Lihat Generasi ke -<?=($generasi_ke+1);?></a>
                      </td>
                    </tr>

                  <?php
                  $no++;
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>ID Member</th>
                  <th>Nama Member</th>
                  <th>Paket</th>
                  <th>Terdaftar Pada</th>
                  <th>Jumlah Sponsor</th>
                  <th>Generasi ke</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>