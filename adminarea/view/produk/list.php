<?php
require_once '../model/classProduk.php';
require_once '../model/classProdukJenis.php';
require_once '../model/classPlan.php';
$obj = new classProduk();
$cpj = new classProdukJenis();
$cpl = new classPlan();

$query = $obj->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title ?></h3>
        <a href="?go=<?= $mod_url ?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah</a>
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
        <div class="row">
            <div class="col-sm-1">
                <label for="" class="control-label">Show</label>
                <select name="custom_length" id="custom_length" class="form-control">
                    <option value='10' selected='selected'>10</option>
                    <option value='20'>20</option>
                    <option value='50'>50</option>
                    <option value='100'>100</option>
                    <option value='-1'>All</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="" class="control-label">Paket</label>
                <select name="id_plan" id="id_plan" class="form-control">
                    <option val="">-- Semua --</option>
                    <?php
                    $plan = $cpl->index();
                    while ($row = $plan->fetch_object()) {
                    ?>
                        <option value="<?= $row->id ?>"><?= $row->nama_plan ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="" class="control-label">Jenis Produk</label>
                <select class="form-control" name="jenis_produk" id="jenis_produk">
                    <option value="">Semua Jenis Produk</option>
                    <?php
                    $produk_jenis = $cpj->index();
                    while ($row = $produk_jenis->fetch_object()) {
                    ?>
                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="" class="control-label">Tampilkan</label>
                <select name="tampilkan" id="tampilkan" class="form-control">
                    <option value='' selected='selected'></option>
                    <option value='1'>Ya</option>
                    <option value='0'>Tidak</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="" class="control-label">Pencarian</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="keyword" name="keyword">
                    <div class="input-group-btn">
                        <!-- <div class="btn-group" id="btn-group"> -->
                        <button type="button" class="btn btn-primary" id="btnFilter">
                            <i class="fa fa-search"></i>
                            Filter</button>
                        <button type="reset" class="btn btn-primary" id="btnReset">Reset Filter</button>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="produk-list">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">No.</th>
                        <th class="text-center" rowspan="2">Gambar</th>
                        <th class="text-center" rowspan="2">SKU</th>
                        <th class="text-center" rowspan="2">Nama Produk</th>
                        <th class="text-center" rowspan="2">Harga</th>
                        <th class="text-center" rowspan="2">Bonus Sponsor</th>
                        <th class="text-center" colspan="3">Poin</th>
                        <th class="text-center" rowspan="2">Paket</th>
                        <th class="text-center" rowspan="2">Tampilkan</th>
                        <th class="text-center" rowspan="2" width="100">Aksi</th>
                    </tr>
                    <tr>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Pasangan</th>
                        <th class="text-center">Reward</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    var dataTable;
    $(document).ready(function() {

        dataTable = $("#produk-list").DataTable({
            // sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            sDom: "<'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/produk/list.php",
                data: function(d) {
                    d.id_plan = $('#id_plan').val();
                    d.jenis_produk = $('#jenis_produk').val();
                    d.keyword = $('#keyword').val();
                    d.tampilkan = $('#tampilkan').val();
                },
                type: "post",
            },
            order: [
                [3, 'asc']
            ],
            columnDefs: [{
                    targets: [-1, -2, -3, -4, -5, -6, 0, 1, 2],
                    className: 'text-center'
                },
                {
                    targets: [4, 5],
                    className: 'text-right'
                }
            ]
        });

        $('#custom_length').on('change', function() {
            dataTable.page.len($(this).val()).draw();
        });
        $('#btnFilter').click(function() {
            dataTable.ajax.reload();
        });
        $('#btnReset').click(function() {
            $('#id_plan').val('');
            $('#jenis_produk').val('');
            $('#tampilkan').val('');
            $('#keyword').val('');
            dataTable.ajax.reload();
        });
    });
    
    function delete_item(id, e) {
        //tambahkan konfirmasi sweetalert
        if (!confirm('Apakah anda yakin ingin menghapus data ini?')) {
            return false;
        }
        $.ajax({
            url: 'controller/produk/delete_item.php',
            type: 'post',
            data: {
                id: id
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    alert(obj.message);
                    dataTable.ajax.reload();
                } else {
                    alert(obj.message);
                }
            }
        });
    }
</script>