<?php
	require_once '../model/classStokisProduk.php';
	$obj = new classStokisProduk();
    $id_produk = '';
    if(isset($_GET['id_produk'])){
        $id_produk = base64_decode($_GET['id_produk']);
    }
    $query = $obj->mutasi_stok($session_stokis_id, $id_produk);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=stokis_deposit_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah Produk</a>
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
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">SKU</th>
                        <th>Nama Produk</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                $no = 1;
                while ($row= $query->fetch_object()) {
                ?>
                    <tr>
                        <td align="center"><?=$no;?></td>
                        <td align="left"><?=$row->created_at?></td>
                        <td class="text-center"><?=$row->sku;?></td>
                        <td><?=$row->nama_produk_detail;?></td>
                        <td align="center"><?=$row->qty?></td>
                        <td align="center"><?=$row->status == 'd' ? 'masuk' : 'keluar'?></td>
                        <td align="center"><?=$row->keterangan?></td>
                    </tr>
                    <?php
                $no++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>