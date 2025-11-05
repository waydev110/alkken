<?php 
  require_once("../helper/all.php");
  require_once("../model/classMemberAutosave.php");
  require_once("../model/classMember.php");

  $ctro   = new classMemberAutosave();
  $cm = new classMember();
  // echo base64_decode($_GET['id']);
  $id_po  = base64_decode($_GET['id']);
  $data_po= $ctro->show($id_po);
  $provinsi = $data_po->nama_provinsi == '' ? '' : 'Provinsi '.$data_po->nama_provinsi.' <br>';
  $nama_kota = $data_po->nama_kota == '' ? '' : $data_po->nama_kota.' <br>';
  $nama_kecamatan = $data_po->nama_provinsi == '' ? '' : 'Kecamatan '.$data_po->nama_kecamatan.' <br>';
  $nama_kelurahan = $data_po->nama_kelurahan == '' ? '' : 'Kecamatan '.$data_po->nama_kelurahan.' <br>';
  $alamat = $provinsi.$nama_kota.$nama_kecamatan.$nama_kelurahan.$data_po->alamat_kirim;


  
  $query_detail_po= $ctro->showdetail($id_po);
  $member = $cm->detail($data_po->id_member);
?>

<div class="box box-primary">
    <div class="box-body">
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Data Member
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-5">ID Member</label>
                <label class="col-xs-7">:<?=$member->id_member;?></label>
            </div>
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-5">Nama Member</label>
                <label class="col-xs-7">:<?=$member->nama_member;?></label>
            </div>
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-5">Nama Samaran</label>
                <label class="col-xs-7">:<?=$member->nama_samaran;?></label>
            </div>
        </div>
        <div class="col-sm-4 invoice-col">
            Kirim ke
            <address>
                <strong>Nama : <?=$member->nama_member;?></strong><br>
                <strong>Alamat : <br><?=$alamat;?></strong><br>
                <strong>No WA : <?=$member->hp_member?></strong>
            </address>
        </div>
        <div class="col-sm-4 invoice-col">
            <p>Tanggal: <?=date('d/m/Y', strtotime($data_po->created_at));?></p>
            Status
            <p><?=vstatus_order($data_po->status);?></p>
            <?php if($data_po->status == 3){?>
                <div class="form-group row" style="margin-bottom:0">
                    <label class="col-xs-5">Jasa Ekspedisi</label>
                    <label class="col-xs-7">:<?=$data_po->nama_jasa_ekspedisi;?></label>
                </div>
                <div class="form-group row" style="margin-bottom:0">
                    <label class="col-xs-5">No Resi</label>
                    <label class="col-xs-7">: <?=$data_po->no_resi;?></label>
                </div>
                <div class="form-group row" style="margin-bottom:0">
                    <label class="col-xs-5">Biaya Kirim</label>
                    <label class="col-xs-7">: <?=currency($data_po->biaya_kirim)?></label>
                </div>
            
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
          $no =1;
            while ($data_detail_po = $query_detail_po->fetch_object()) {
              ?>
                    <tr>
                        <td><?=$no++;?></td>
                        <td><?=$data_detail_po->nama_produk;?></td>
                        <td class="text-right"><?=currency($data_detail_po->harga);?></td>
                        <td class="text-right"><?=number_format($data_detail_po->qty,0,',','.');?></td>
                        <td class="text-right"><?=currency($data_detail_po->jumlah);?></td>
                    </tr>
                    <?php
            }
          ?>
                </tbody>

            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <p class="lead"></p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="text-right">Total Harga:</th>
                        <td class="text-right"><?=currency($data_po->nominal+$data_po->saldo_poin);?></td>
                    </tr>
                    <tr>
                        <th class="text-right">Saldo Autosave:</th>
                        <td class="text-right"><?=currency($data_po->saldo_poin);?></td>
                    </tr>
                    <tr>
                        <th class="text-right">Total Bayar:</th>
                        <td class="text-right"><?=currency($data_po->nominal);?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <?php if($data_po->status == '0') {?>
    <div class="row no-print">
        <div class="col-xs-6">
            <button class="btn btn-danger btn-block" onclick="batalkan_pesanan('<?=$data_po->id?>')">Batalkan Pesanan</button>
        </div>
        <div class="col-xs-6">
            <button class="btn btn-success btn-block" onclick="proses_pesanan('<?=$data_po->id?>')">Proses Pesanan</button>
        </div>
    </div>
    <?php } ?>
    </div>
    </div>

<script>
    function proses_pesanan(id) {
        $.ajax({
            url: 'controller/autosave/proses_pesanan.php',
            data: {
                id: id,
            },
            type: 'POST',
            dataType: 'html',
            success: function (pesan) {
                if (pesan == "ok") {
                    aktivasi_pin();
                    alert('Pesanan berhasil diproses.');
                } else {                    
                    alert('Pesanan gagal diproses.');
                }
                document.location="?go=klaim_autosave";
            },
        });
    }
    function batalkan_pesanan(id) {
        $.ajax({
            url: 'controller/autosave/batalkan_pesanan.php',
            data: {
                id: id,
            },
            type: 'POST',
            dataType: 'html',
            success: function (pesan) {
                if (pesan == "ok") {
                    alert('Pesanan berhasil dibatalkan.');
                } else {                    
                    alert('Pesanan gagal dibatalkan.');
                }
                document.location="?go=klaim_autosave";
            },
        });
    }

    function aktivasi_pin() {
        $.ajax({
            url: '../memberarea/controller/posting_ro/posting_autosave.php',
            type: 'post',
            success: function (result) {
            }
        });
    }
</script>