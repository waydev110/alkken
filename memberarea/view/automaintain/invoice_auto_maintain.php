<?php 
  include("model/classMember.php");
  include("model/classTutupPoinAutoMaintain.php");
  $cm = new classMember();
  $ctpam = new classTutupPoinAutoMaintain();

  $id = base64_decode($_GET['q']);
  $data = $ctpam->show($id);

  $data_member=$cm->show($data->id_member);
?>
<style type="text/css" media="screen">
  .btn-app{
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: left;
    height: 90px;
    width: 90px;
    text-align: center;
    
  }
  .btn-app>.fa {
    font-size: 45px !important;
  }
</style>
<section class="invoice">
  <!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-globe"></i> INVOICE #<?=$data->kode_bayar;?>
        <small class="pull-right">Tanggal Transaksi: <?=date('d/m/Y', strtotime($data->created_at));?></small>
      </h2>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-5 invoice-col">
      Dari
      <address>
        <strong><?=$_SESSION['nama_login_member'];?></strong><br>
        <?=$_SESSION['nama_paket_member'];?><br>
        No. Handphone: <?=$data_member->hp_member;?><br>
        Email: <?=$data_member->email_member;?>
      </address>
    </div>
    <div class="col-sm-5 invoice-col">
      Kepada
      <address>
        <strong>Head Office</strong><br>
        PT. ARNET SUKSES MANDIRI<br>
        Ruko Demarakesh<br>
Blok A1 No.6 Derwati-Bandung-Jawa Barat<br>
Phone: 6222 - 87528463<br>
      </address>
    </div>
    <div class="col-sm-2 invoice-col">
      <?php 
      if($data->status_diterima == 0){
        echo '<button type="button" class="btn btn-primary btn-app"><i class="fa fa-exclamation-circle"></i></button>';
      }else{
        echo '<button type="button" class="btn btn-primary btn-app"><i class="fa fa-check-circle-o text-green"></i></button>';
      }
      ?>
      
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12 table-responsive">
      <table class="table table-striped">
          <thead>
            <tr>
              <th width="20%">Item</th width="1%"> <th></th><th>Nominal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Saldo Capaian</th> <th>: </th><td align="right">Rp<?=number_format($data->nominal_automaintain,0,',','.');?></td>
            </tr>
            <tr>
              <th>Saldo Anda bulan Ini</th> <th>: </th><td align="right">Rp<?=number_format($data->nominal_saldo,0,',','.');?></td>
            </tr>
            <tr>
              <th>Kekurangan Saldo</th> <th>: </th><td align="right">Rp<?=number_format($data->nominal_automaintain-$data->nominal_saldo,0,',','.');?></td>
            </tr>
            <tr>
              <th>Total Transfer</th> <th>: </th><td align="right">Rp<?=number_format($data->nominal_kekurangan,0,',','.');?></td>
            </tr>
          </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <!-- accepted payments column -->
    <div class="col-xs-6">
      <p class="lead">Keterangan:</p>
      
      <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
        Silahkan melakukan pembayaran melalui rekening berikut, dengan menyertakan <strong>NO INVOICE PADA BERITA TRANSER</strong> <br><br>
        
      </p>
      <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
        Silahkan melakukan pembayaran melalui rekening berikut: <br>
        <br>
        Kemudian lakukan konfirmasi pembayaran melalui WA/Telp ke: <br>
        
      </p>
    </div>
    
    <div class="col-xs-6">
      <p class="lead"></p>

      <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:50%">Subtotal:</th>
            <td align="right">Rp<?=number_format($data->nominal_kekurangan,0,',','.');?></td>
          </tr>
          <tr>
            <th>Tax (0%)</th>
            <td align="right">Rp0</td>
          </tr>
          <tr>
            <th>Total:</th>
            <td align="right">Rp<?=number_format($data->nominal_kekurangan,0,',','.');?></td>
          </tr>
        </table>
      </div>
    </div>
    
  </div>
  
  <div class="row no-print">
    <div class="col-xs-12">
      <a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>    
    </div>
  </div>
</section>