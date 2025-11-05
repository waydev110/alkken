<?php 
  require_once("../helper/all.php");
  require_once("../model/classMemberOrder.php");
  require_once("../model/classMemberOrderDetail.php");
  require_once("../model/classMember.php");

  $cmo   = new classMemberOrder();
  $obj   = new classMemberOrderDetail();
  $cm = new classMember();
  // echo base64_decode($_GET['id']);
  $id_po  = base64_decode($_GET['id']);
  $data_po = $cmo->show($id_po);
  $query = $obj->index($id_po);
  $member = $cm->detail($data_po->id_member);
?>
<style>
    .page-header {
        margin: 0px 0 20px 0;
        font-size: 22px;
    }
</style>
<section class="invoice">
    <div class="row page-header">
        <div class="col-xs-6">
            <h5 class="row">#<?=$data_po->id?></h5>
        </div>
        <div class="col-xs-6">
            <h5 class="row text-right">Tanggal: <?=date('d/m/Y', strtotime($data_po->created_at))?></h5>
        </div>
    </div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Data Member
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-5">ID Member</label>
                <label class="col-xs-7">: <?=$member->id_member?></label>
            </div>
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-5">Nama Member</label>
                <label class="col-xs-7">: <?=$member->nama_member?></label>
            </div>
        </div>
        <div class="col-sm-4 invoice-col">
            Kirim ke
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-3">Nama</label>
                <label class="col-xs-9">: <?=$member->nama_member?></label>
            </div>
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-3">Alamat</label>
                <label class="col-xs-9">: <?=$data_po->alamat_kirim?></label>
            </div>
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-3">No HP</label>
                <label class="col-xs-9">: <?=$member->hp_member?></label>
            </div>
        </div>
        <div class="col-sm-4 invoice-col">
            Status
            <p><?=vstatus_order($data_po->status)?></p>
            <?php if($data_po->status == 3){?>
                <div class="form-group row" style="margin-bottom:0">
                    <label class="col-xs-5">Jasa Ekspedisi</label>
                    <label class="col-xs-7">:<?=$data_po->jasa_ekspedisi?></label>
                </div>
                <div class="form-group row" style="margin-bottom:0">
                    <label class="col-xs-5">No Resi</label>
                    <label class="col-xs-7">: <?=$data_po->no_resi?></label>
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
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-left">Nama Produk</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
          $no =1;
            while ($row = $query->fetch_object()) {
              ?>
                    <tr>
                        <td class="text-center"><?=$no++?></td>
                        <td><?=$row->nama_produk?></td>
                        <td class="text-right"><?=currency($row->harga)?></td>
                        <td class="text-right"><?=currency($row->qty)?></td>
                        <td class="text-right"><?=currency($row->jumlah)?></td>
                    </tr>
                    <?php
            }
          ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="4">Total</td>
                        <td class="text-right"><?=currency($data_po->nominal)?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <?php if($data_po->status == '0') {?>
    <div class="row no-print">
        <div class="col-xs-6">
            <button class="btn btn-danger btn-block" onclick="batalkan_pesanan('<?=$data_po->id?>')">Total Pesanan</button>
        </div>
        <div class="col-xs-6">
            <button class="btn btn-success btn-block" onclick="proses_pesanan('<?=$data_po->id?>')">Proses Pesanan</button>
        </div>
    </div>
    <?php } ?>
</section>

<script>
    function proses_pesanan(id) {
        if(confirm('Apakah anda yakin akan memproses pesanan ini?')){
            $.ajax({
                url: 'controller/member_order/proses_pesanan.php',
                data: {
                    id: id,
                },
                type: 'POST',
                dataType: 'html',
                success: function (pesan) {
                    if (pesan == "ok") {
                        alert('Pesanan berhasil diproses.');
                    } else {                    
                        alert('Pesanan gagal diproses.');
                    }
                    document.location="?go=member_order";
                },
            });
        }
    }
    function batalkan_pesanan(id) {
        if(confirm('Apakah anda yakin akan menolak pesanan ini?')){
            $.ajax({
                url: 'controller/member_order/batalkan_pesanan.php',
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
                    document.location="?go=member_order";
                },
            });
        }
    }
</script>