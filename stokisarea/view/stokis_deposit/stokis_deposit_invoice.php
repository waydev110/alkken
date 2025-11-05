<?php 
  session_start();
  require_once '../model/classStokisDeposit.php';
  require_once '../model/classStokisMember.php';
  require_once '../model/classStokisDepositDetail.php';
  require_once '../model/classRekeningPerusahaan.php';

  $cdo = new classStokisDeposit();
  $cms = new classStokisMember();
  $cdod= new classStokisDepositDetail();
  $crp= new classRekeningPerusahaan();

  $id_stokis = $_SESSION['session_stokis_id'];
  $id = $_GET['id_deposit'];
  $data = $cdo->show($id, $id_stokis);
  $data_stokis = $cms->show($id_stokis);
  $rekening = $crp->index();
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
            Kepada <strong><?=$data_stokis->nama_paket;?></strong>: 
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
                        <th class="text-center">SKU</th>
                        <th>Nama Produk</th>
                        <th class="text-center">Jumlah Satuan</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Diskon</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
            $produk = $cdod->index($data->id);
            $no=1;
            $fee_stokis = 0;
            while ($data_produk = $produk->fetch_object()) {
                $jumlah_total = $data_produk->jumlah - $data_produk->fee_stokis;

        ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-center"><?=$data_produk->sku;?></td>
                        <td><?=$data_produk->nama_produk_detail;?></td>
                        <td class="text-center"><?=currency($data_produk->total_produk);?> <?=$data_produk->satuan;?></td>
                        <td class="text-right"><?=rp($data_produk->harga);?></td>
                        <td class="text-right"><?=currency($data_produk->qty);?></td>
                        <td class="text-right"><?=rp($data_produk->jumlah);?></td>
                        <td class="text-right"><?=rp($data_produk->fee_stokis);?></td>
                        <td class="text-right"><?=rp($jumlah_total);?></td>
                    </tr>
                    </tr>
                    <?php
              $no++;
            }
          ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p class="lead">Metode Pembayaran:</p>
            <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                <p>Silahkan melakukan pembayaran melalui rekening berikut:</p>
                <?php while($row = $rekening->fetch_object()) {
                ?>                 
                <img src="../images/bank/<?=$row->logo?>" width="80" alt="<?=$row->nama_bank?>">
                <h4>(<?=$row->kode_bank?>) <?=$row->no_rekening?></h4>
                <h4>a.n. <?=$row->atas_nama_rekening?></h4>
                <?php
                }
                ?>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <p class="lead"></p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <th class="text-right"><?=rp($data->subtotal);?></th>
                    </tr>
                    <tr>
                        <th>Diskon</th>
                        <th class="text-right">-<?=rp($data->diskon);?></th>
                    </tr>
                    <tr>
                        <th>Total Bayar:</th>
                        <th class="text-right"><?=rp($data->nominal);?></th>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
</section>