<?php
require_once("../model/classStokisPaket.php");
require_once("../model/classStokisMember.php");
require_once("../model/classMember.php");
require_once("../model/classProduk.php");
require_once '../model/classProdukJenis.php';
$csp = new classStokisPaket();
$csm = new classStokisMember();
$cm = new classMember();
$cp = new classProduk();
$cpj = new classProdukJenis();
$stokis_paket = $csp->index();
$stokis = $csm->index();
$produk = $cp->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title ?></h3>
        <!-- <a href="?go=<?= $mod_url ?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah</a> -->
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner text-right">
                        <h4 id="subtotal">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Total Nominal</a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner text-right">
                        <h4 id="diskon">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Total Diskon</a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-red">
                    <div class="inner text-right">
                        <h4 id="nominal">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Total Deposit</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="" class="control-label">Stokis</label>
                <select name="id_stokis" id="id_stokis" class="form-control select2">
                    <option value='' selected='selected'>Semua Stokis</option>
                    <?php
                    while ($option = $stokis->fetch_object()) {
                        echo '<option value="' . $option->id . '">' . $option->nama_stokis . ' (' . $option->id_stokis . ')</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="" class="control-label">Jenis Produk</label>
                <select class="form-control" name="jenis_produk" id="jenis_produk">
                    <option value="">Semua Jenis Produk</option>                            
                    <?php
                    $produk_jenis = $cpj->index();
                    while($row = $produk_jenis->fetch_object()){
                    ?>
                    <option value="<?=$row->id?>"><?=$row->name?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="" class="control-label">Produk</label>
                <select name="id_produk" id="id_produk" class="form-control select2">
                    <option value='' selected='selected'>Semua Produk</option>
                    <?php
                    while ($option = $produk->fetch_object()) {
                        echo '<option value="' . $option->id . '">' . $option->nama_produk . '</option>';
                    }
                    ?>
                </select>
            </div>
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
                <label for="" class="control-label">Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value='' selected='selected'>Semua Bulan</option>
                    <?php
                    $star_date = date('Y-m-d', strtotime('2023-01-01'));
                    $tanggal = date('Y-m-d');
                    while (strtotime($tanggal) > strtotime($star_date)) {
                    ?>
                        <option value="<?= date('Y-m', strtotime($tanggal)) ?>"><?= bulan_tahun($tanggal) ?></option>
                    <?php
                        $tanggal = date('Y-m-d', strtotime("-1 month", strtotime($tanggal)));
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-5">
                <label for="" class="control-label">Tanggal Proses</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date" id="start_date">
                    <span class="input-group-addon">s/d</span>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                </div>
            </div>
            <div class="col-sm-4">
                <label for="" class="control-label">Pencarian</label>
                <div class="input-group" id="btn-group">
                    <input type="text" class="form-control" id="keyword" name="keyword">
                    <dinv class="input-group-btn">
                        <button type="button" class="btn btn-primary" id="btnFilter">
                            <i class="fa fa-search"></i>
                            Filter</button>
                        <button type="reset" class="btn btn-primary" id="btnReset">Reset Filter</button>
                    </dinv>
                </div>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">ID Order</th>
                    <th class="text-center">Tanggal Order</th>
                    <th class="text-center">ID Stokis</th>
                    <th class="text-center">Nama Stokis</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Tanggal Proses</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?php include '../helper/detail_produk.php' ?>
<script>
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function() {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: "controller/stokis_deposit/stokis_deposit_riwayat.php",
                type: "post",
                data: function(d) {
                    d.bulan = $('#bulan').val();
                    d.id_stokis = $('#id_stokis').val();
                    d.id_produk = $('#id_produk').val();
                    d.jenis_produk = $('#jenis_produk').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.keyword = $('#keyword').val();
                },
                complete: function(event, xhr, options) {
                    $('#subtotal').text(event['responseJSON']['subtotal']);
                    $('#diskon').text(event['responseJSON']['diskon']);
                    $('#nominal').text(event['responseJSON']['nominal']);
                },
            },
            order:[[1, 'desc']],
            columnDefs: [{
                targets: [0, 1, -1, -2, -3],
                className: 'text-center'
            }, {
                targets: [4],
                className: 'text-right'
            }]
        });
    });

    $('#keyword').on('keyup', function() {
        dataTable.ajax.reload();
    });

    $('#custom_length').on('change', function() {
        dataTable.page.len($(this).val()).draw();
    });
    $('#btnFilter').click(function() {
        dataTable.ajax.reload();
    });
    $('#btnReset').click(function() {
        $('#bulan').val('');
        $('#id_stokis').val('');
        $('#id_produk').val('');
        $('#jenis_produk').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#keyword').val('');
        dataTable.ajax.reload();
    });

    function detail_produk(id_deposit) {
        $.ajax({
            url: 'controller/stokis_deposit/stokis_deposit_detail.php',
            type: 'post',
            data: {
                id_deposit: id_deposit
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#detail_produk').html(obj.html);
                    modalDetail.modal('show');
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function approve(id_deposit) {
        var status = '1';
        $.ajax({
            url: 'controller/stokis_deposit/stokis_deposit_proses.php',
            type: 'post',
            data: {
                id_deposit: id_deposit,
                status: status
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload();
                } else {
                    alert(obj.message);
                }
            }
        });
    }

    function reject(id_deposit) {
        var status = '2';
        $.ajax({
            url: 'controller/stokis_deposit/stokis_deposit_proses.php',
            type: 'post',
            data: {
                id_deposit: id_deposit,
                status: status
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload();
                } else {
                    alert(obj.message);
                }
            }
        });
    }
</script>