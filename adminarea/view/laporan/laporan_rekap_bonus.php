<?php
require_once("../helper/string.php");
require_once("../model/classMember.php");
require_once("../model/classPlan.php");

$cm = new classMember();
$cpl = new classPlan();

$member = $cm->index();
$plan = $cpl->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner text-right">
                        <h4 id="cash">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Wallet Cash</a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner text-right">
                        <h4 id="poin">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Wallet Autosave</a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-red">
                    <div class="inner text-right">
                        <h4 id="admin">Rp0,-</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Admin</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <label for="" class="control-label">Tampilan Data</label>
                <select name="custom_length" id="custom_length" class="form-control">
                    <option value='10'>10</option>
                    <option value='20'>20</option>
                    <option value='50'>50</option>
                    <option value='100'>100</option>
                    <option value='-1'>All</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="" class="control-label">Asal Bonus</label>
                <select name="asal_bonus" id="asal_bonus" class="form-control">
                    <option value='' selected='selected'>-- Semua --</option>
                    <option value='bonus_sponsor'><?=type('bonus_sponsor')?></option>
                    <option value='bonus_pasangan'><?=type('bonus_pasangan')?></option>
                    <option value='bonus_pasangan_level'><?=type('bonus_pasangan_level')?></option>
                    <option value='bonus_cashback'><?=type('bonus_cashback')?></option>
                    <option value='bonus_generasi'><?=type('bonus_generasi')?></option>
                    <option value='bonus_reward'><?=type('bonus_reward')?></option>
                    <option value='bonus_insentif'><?=type('bonus_insentif')?></option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="" class="control-label">Tanggal</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date" id="start_date">
                    <span class="input-group-addon">s/d</span>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                </div>
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
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Rekap</th>
                            <th class="text-center">Asal Bonus</th>
                            <th class="text-center">ID <?= $lang['member'] ?></th>
                            <th class="text-center">Nama <?= $lang['member'] ?></th>
                            <th class="text-center">Cash</th>
                            <th class="text-center">Autosave</th>
                            <th class="text-center">Admin</th>
                            <th class="text-center">Jumlah</th>
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
                url: "controller/laporan/laporan_rekap_bonus.php",
                type: "post",
                data: function(d) {
                    d.id_paket = $('#id_paket').val();
                    d.asal_bonus = $('#asal_bonus').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.keyword = $('#keyword').val();
                },
                complete: function(event, xhr, options) {
                    $('#cash').text(event['responseJSON']['cash']);
                    $('#poin').text(event['responseJSON']['poin']);
                    $('#admin').text(event['responseJSON']['admin']);
                },
            },
            order: [
                [3, 'desc']
            ],
            columnDefs: [{
                targets: [0, 1,3],
                className: 'text-center'
            }, {
                targets: [-1,-2,-3,-4],
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
            $('#id_paket').val('');
            $('#asal_bonus').val('1');
            $('#start_date').val('');
            $('#end_date').val('');
            $('#keyword').val('');
            dataTable.ajax.reload();
        });
    });
</script>