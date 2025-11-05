<?php 
  require_once '../helper/all.php';
  require_once '../model/classMemberOrder.php';
  require_once '../model/classMemberOrderDetail.php';
  require_once '../model/classMember.php';

  $cmo   = new classMemberOrder();
  $obj   = new classMemberOrderDetail();
  $cm = new classMember();
  // echo base64_decode($_GET['id']);
  $id_po  = base64_decode($_GET['id']);
  $order = $cmo->show($id_po, $session_stokis_id);
  $query = $obj->index($id_po);
  $member = $cm->detail($order->id_member);
?>
<style>
    .page-header {
        margin:0px 0 20px 0;
        font-size:22px;
    }

    p {
        margin-bottom: 0px;
    }
</style>
<section class="invoice">
    <div class="row page-header">
        <div class="col-xs-6">
            <h5 class="row">ID : <?=code_order($order->id, $order->created_at)?></h5>
        </div>
        <div class="col-xs-6">
            <h5 class="row text-right">Tanggal : <?=$order->created_at?></h5>
        </div>
    </div>
    <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
            Kirim ke :
            <p class="text-bold"><?=$member->nama_member?></p>
            <p class="text-bold"><?=$member->hp_member?></p>
            <p><?=$order->nama_provinsi?>, <?=$order->nama_kota?></p>
            <p><?=$order->nama_kecamatan?>, <?=$order->nama_kelurahan?></p>
            <p><?=$order->alamat_kirim?></p>
            <p><?=$order->kodepos?></p>
        </div>
        <div class="col-sm-4 invoice-col">
            Status
            <p><?=vstatus_order($order->status)?></p>
            <?php if($order->status == 3){?>
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-5">Jasa Ekspedisi</label>
                <label class="col-xs-7">: <?=$order->nama_jasa_ekspedisi?></label>
            </div>
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-5">No Resi</label>
                <label class="col-xs-7">: <?=$order->no_resi?></label>
            </div>
            <div class="form-group row" style="margin-bottom:0">
                <label class="col-xs-5">Biaya Kirim</label>
                <label class="col-xs-7">: <?=currency($order->biaya_kirim)?></label>
            </div>
            <?php } ?>
        </div>
        <div class="col-sm-2 invoice-col">
            <?php if($order->status == 0){?>
            <p class="text-bold">Bukti Bayar :</p>
            <a href="../images/bukti_bayar/<?=$order->bukti_bayar?>" target="_blank">Lihat Bukti Bayar</a>
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
          $total = 0;
            while ($row = $query->fetch_object()) {
              $total += $row->jumlah;
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
                        <td class="text-bold text-right" colspan="4">Total Harga</td>
                        <td class="text-bold text-right"><?=currency($total)?></td>
                    </tr>
                    <!-- <tr>
                        <td class="text-bold text-right" colspan="4">Kode Unik</td>
                        <td class="text-bold text-right"><?=currency($order->nominal-$total)?></td>
                    </tr>
                    <tr>
                        <td class="text-bold text-right" colspan="4">Total Transfer</td>
                        <td class="text-bold text-right"><?=currency($order->nominal)?></td>
                    </tr> -->
                </tfoot>
            </table>
        </div>
    </div>

    <?php if($order->status <= 0) {?>
    <div class="row no-print">
        <div class="col-xs-6">
            <button class="btn btn-danger btn-block" onclick="batalkan_pesanan('<?=$order->id?>')">Tolak
                Pesanan</button>
        </div>
        <div class="col-xs-6">
            <button class="btn btn-success btn-block" onclick="proses_pesanan('<?=$order->id?>')">Proses
                Pesanan</button>
        </div>
    </div>
    <?php } ?>
</section>
<div class="modal fade bs-example-modal-sm" id="modalSuccess" tabindex="-1" role="dialog"
    aria-labelledby="modalSuccessLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header border-none">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center" id="message">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">Close</span></button>
            </div>
        </div>
    </div>
</div>


<script>
    var modalSuccess = $('#modalSuccess');
    function proses_pesanan(id) {
        if(confirm('Apakah anda yakin akan memproses pesanan ini?')){
            $.ajax({
                url: 'controller/member_order/proses_pesanan.php',
                data: {
                    id: id,
                },
                type: 'POST',
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        aktivasi_pin();
                        $('#message').html(obj.message);
                        modalSuccess.modal('show');
                    } else {
                        alert(obj.message);
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

    function aktivasi_pin() {
        $.ajax({
            url: '../memberarea/controller/posting_ro/posting_ro_auto.php',
            type: 'post',
            success: function (result) {
            }
        });
    }
</script>