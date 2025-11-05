<?php
session_start();
require_once '../model/classStokisProduk.php';
$obj = new classStokisProduk();
$session_stokis_id = $_SESSION['session_stokis_id'];
$query = $obj->index_stok($session_stokis_id);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Stok Produk</h3>
        <!-- <a href="?go=stokis_deposit_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah Produk</a> -->
    </div>
    <div class="box-body">
        <?php
        if (isset($_GET['stat'])) {
            if ($_GET['stat'] == 1) {
        ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Info!</h4>
                    <?= ucwords($_GET['msg']); ?> sukses
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Info!</h4>
                    <?= ucwords($_GET['msg']); ?> gagal
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
                        <th class="text-center">Gambar</th>
                        <th class="text-center">SKU</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $query->fetch_object()) {
                    ?>
                        <tr>
                            <td align="center"><?= $no; ?></td>
                            <td class="text-center">
                                <img src="../images/produk/<?= $row->gambar ?>" height="30">
                            </td>
                            <td class="text-center"><?= $row->sku; ?></td>
                            <td><?= $row->nama_produk_detail; ?></td>
                            <td align="center"><?= $row->jumlah_stock ?></td>
                            <td align="center">
                                <a href='index.php?go=mutasi_stok_produk&id_produk="<?= base64_encode($row->id) ?>"' class='btn btn-primary btn-xs'>Riwayat</a>
                            </td>
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