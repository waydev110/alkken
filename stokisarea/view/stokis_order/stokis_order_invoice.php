<?php 
  session_start();
  require_once '../model/classStokisDeposit.php';
  require_once '../model/classStokisMember.php';
  require_once '../model/classStokisDepositDetail.php';

  $cdo = new classStokisDeposit();
  $cms = new classStokisMember();
  $cdod= new classStokisDepositDetail();

  $id_stokis_tujuan = $_SESSION['session_stokis_id'];
  $id = $_GET['id_deposit'];
  $data = $cdo->find_stokis_order($id, $id_stokis_tujuan);
  $id_stokis = $data->id_stokis;
  $data_stokis = $cms->show($id_stokis);
?>

<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> <?=code_order($data->id, $data->created_at);?>
                <small class="pull-right">Tanggal: <?=date('d/m/Y', strtotime($data->created_at));?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Dikirim ke <strong><?=$data_stokis->nama_paket;?></strong>: 
            <address>
                <strong><?=$_SESSION['session_nama_stokis'];?></strong><br>
                Phone: <?=$data_stokis->no_handphone;?><br>
                Email: <?=$data_stokis->email;?>
            </address>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Produk</th>
                        <th class="text-center">Jenis Produk</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
            $produk = $cdod->index($data->id);
            $no=1;
            $subtotal = 0;
            while ($data_produk = $produk->fetch_object()) {
                $subtotal += $data_produk->jumlah;

        ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td><?=$data_produk->nama_produk;?></td>
                        <td class="text-center"><?=$data_produk->nama_plan;?></td>
                        <td class="text-right"><?=rp($data_produk->harga);?></td>
                        <td class="text-right"><?=currency($data_produk->qty);?></td>
                        <td class="text-right"><?=rp($data_produk->jumlah);?></td>
                    </tr>
                    <?php
              $no++;
            }
          ?>
                </tbody>
                <tfoot>                    
                      <tr>
                          <th class="text-right" colspan="5">Subtotal</th>
                          <th class="text-right"><?=rp($subtotal);?></th>
                      </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>