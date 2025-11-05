<?php
require_once("../model/classStokisPaket.php");
require_once("../model/classStokisMember.php");
require_once("../model/classMember.php");
require_once("../model/classPlan.php");
require_once("../model/classProdukJenis.php");

$csp = new classStokisPaket();
$csm = new classStokisMember();
$cm = new classMember();
$cpl = new classPlan();
$cpj = new classProdukJenis();

$stokis_paket = $csp->index();
$stokis = $csm->index();
$member = $cm->index();
$plan = $cpl->index();
$produk_jenis = $cpj->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <label for="" class="control-label">Paket</label>
                <select name="jenis_aktivasi" id="jenis_aktivasi" class="form-control">
                    <option>-- Pilih Paket --</option>
                    <?php
                    while ($row = $plan->fetch_object()) {
                    ?>
                        <option value="<?= $row->id ?>"><?= $row->nama_plan ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="" class="control-label">Jenis Produk</label>
                <select name="jenis_produk" id="jenis_produk" class="form-control">
                    <option value=''>-- Pilih Jenis Produk --</option>
                    <?php
                    while ($row = $produk_jenis->fetch_object()) {
                    ?>
                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="" class="control-label">Berbayar</label>
                <select name="berbayar" id="berbayar" class="form-control">
                    <option value=''>-- Semua --</option>
                    <option value='1' selected='selected'>Ya</option>
                    <option value='0'>Tidak</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-sm-2">
                <label for="" class="control-label">Tampilan Data</label>
                <select name="custom_length" id="custom_length" class="form-control">
                    <option value='10' selected='selected'>10</option>
                    <option value='20'>20</option>
                    <option value='50'>50</option>
                    <option value='100'>100</option>
                    <option value='-1'>All</option>
                </select>
            </div>
            <div class="col-sm-5">
                <label for="" class="control-label">Tanggal Aktivasi</label>
                <div class="input-group">
                    <input type="datetime-local" class="form-control" name="start_date" id="start_date">
                    <span class="input-group-addon">s/d</span>
                    <input type="datetime-local" class="form-control" name="end_date" id="end_date">
                </div>
            </div>
            <div class="col-sm-5">
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
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Aktivasi</th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Nama Paket</th>
                            <th class="text-center">Jenis Produk</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">ID <?= $lang['member'] ?></th>
                            <th class="text-center">Nama <?= $lang['member'] ?></th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function() {
        dataTable = $("#dataTable").DataTable({
            // sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            sDom: "<'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/kodeaktivasi/aktivasi_list.php",
                type: "post",
                data: function(d) {
                    d.jenis_aktivasi = $('#jenis_aktivasi').val();
                    d.jenis_produk = $('#jenis_produk').val();
                    d.berbayar = $('#berbayar').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.keyword = $('#keyword').val();
                }
            },
            order: [
                [1, 'desc']
            ],
            columnDefs: [{
                targets: [0,1,2,3,4,6,-1],
                className: 'text-center'
            }, {
                targets: [5],
                className: 'text-right'
            }]
        });

        $('#custom_length').on('change', function() {
            dataTable.page.len($(this).val()).draw();
        });
        $('#btnFilter').click(function() {
            dataTable.ajax.reload();
        });
        $('#btnReset').click(function() {
            $('#jenis_aktivasi').val('');
            $('#jenis_produk').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            $('#berbayar').val('1');
            $('#keyword').val('');
            dataTable.ajax.reload();
        });
    });
</script>