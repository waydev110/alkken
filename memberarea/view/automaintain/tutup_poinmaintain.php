<?php 
include ("model/classAutoMaintain.php");
include ("model/classTutupPoinAutoMaintain.php");

$cam = new classAutoMaintain();
$ctpam = new classTutupPoinAutoMaintain();

$cek_tupo_bulan_ini = $ctpam->cek_id($_SESSION['id_login_member']);
$saldo_capaian_bulan_ini = $cam->index_tupo($_SESSION['id_login_member'], date('Y-m', time()));
$saldo_capaian_tupo      = $cam->get_max_auto('nominal_automaintain');

$query = $ctpam->index($_SESSION['id_login_member']);
?>
<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Tutup Point Auto Maintain</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body box-profile">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Saldo Capaian</th>
                  <th>Saldo Automaintain (hingga bulan ini)</th>
                  <th>Kekurangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php
                
                // if(date('D', time()) === 'Sun' || date('D', time()) === 'Mon' || date('D', time()) === 'Tue' || date('d', time()) === date('t', time())) {
                  ?>
                    <!--<tr>-->
                    <!--  <td colspan="5" align="center">Tidak ada jadwal tutup poin hari ini.</td>-->
                    <!--</tr>-->
                  <?php
                // }else{
                  if($cek_tupo_bulan_ini){
                    if(($saldo_capaian_tupo - $saldo_capaian_bulan_ini)>0){
                    ?>
                      <tr>
                        <td><?=date('d/m/Y',time());?></td>
                        <td>Rp<?=number_format($saldo_capaian_tupo,0,',','.');?></td>
                        <td>Rp<?=number_format($saldo_capaian_bulan_ini,0,',','.');?></td>
                        <td>Rp<?=number_format($saldo_capaian_tupo - $saldo_capaian_bulan_ini,0,',','.');?></td>
                        <td>
                          <form action="?go=form_tupo_automaintain" method="post" accept-charset="utf-8">
                            <button type="submit" name="btn_tupo" class="btn btn-xs btn-danger"><i class="fa fa-sign-in"></i> Tutup Poin</button>
                          </form>
                        </td>
                      </tr>
                    <?php
                    }else{
                      ?>
                        <tr>
                          <td colspan="5" align="center">Anda sudah tutup poin bulan ini.</td>
                        </tr>
                      <?php
                    }
                  }else{
                    ?>
                      <tr>
                        <td colspan="5" align="center">Tidak ada data</td>
                      </tr>
                    <?php
                  }
                // }
                
                
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Tutup Poin Auto Maintain</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body box-profile">
          <div class="table-responsive">
            
            <table class="table table-bordered" id="example1">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Tanggal Bayar</th>
                  <th>Nominal Capaian</th>
                  <th>Nominal Terakhir</th>
                  <th>Nominal Tupo</th>
                  <th>Tanggal Proses</th>
                  <th>Invoice</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $no = 1;
                while ($data = $query->fetch_object()) {
                  ?>
                  <tr>
                    <td><?=$no;?></td>
                    <td><?=date('d/m/Y', strtotime($data->created_at));?></td>
                    <td align="right">Rp<?=number_format($data->nominal_automaintain,0,',','.');?></td>
                    <td align="right">Rp<?=number_format($data->nominal_saldo,0,',','.');?></td>
                    <td align="right">Rp<?=number_format($data->nominal_kekurangan,0,',','.');?></td>
                    <td><?=$data->tgl_diterima=='0000-00-00 00:00:00'?'<span class="text-red">Menungu</span>':date('d/m/Y', strtotime($data->tgl_diterima));?></td>
                    <td><a href="?go=invoice_tupo&q=<?=base64_encode($data->id);?>" class="btn btn-primary btn-xs"> <i class="fa fa-print"></i> </a></td>
                  </tr>
                  <?php
                  $no++;
                }
              ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>No.</th>
                  <th>Tanggal Bayar</th>
                  <th>Nominal Capaian</th>
                  <th>Nominal Terakhir</th>
                  <th>Nominal Tupo</th>
                  <th>Tanggal Proses</th>
                  <th>Invoice</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>