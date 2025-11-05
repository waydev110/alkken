<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_transfer" class="btn btn-primary btn-sm pull-right"><i class="fa fa-paper-plane"></i>
            Transfer Bonus</a>
    </div>
    <div class="box-body">
        <?=vrekap_bonus()?>
        <div class="row">
            <div class="col-sm-5">
                <label for="" class="control-label">Tanggal</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date" id="start_date" value="<?=date('Y-m-d')?>">
                    <span class="input-group-addon">s/d</span>
                    <input type="date" class="form-control" name="end_date" id="end_date" value="<?=date('Y-m-d')?>">
                </div>
            </div>
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
                <label for="" class="control-label">Pencarian</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="keyword" name="keyword">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-primary" id="btnFilter">
                            <i class="fa fa-search"></i>
                            Filter</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID <?=$lang['member']?></th>
                    <th class="text-center">Nama <?=$lang['member']?></th>
                    <th class="text-center">Bank</th>
                    <th class="text-center">No Rekening</th>
                    <th class="text-center">Cabang</th>
                    <th class="text-center">Sponsor</th>
                    <th class="text-center">Monoleg</th>
                    <th class="text-center">Pasangan</th>
                    <th class="text-center">Admin</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Tgl Transfer</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-none">
                <h3 class="modal-title">Detail Bonus</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="detail">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">Close</span></button>
            </div>
        </div>
    </div>
</div>
<script>
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            // sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            sDom: "<'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/bonus/bonus_laporan.php",
                type: "post",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
                complete: function (event, xhr, options) {
                    $('#total_bonus').text(event['responseJSON']['total_bonus']);
                    $('#total_admin').text(event['responseJSON']['total_admin']);
                    $('#total_transfer').text(event['responseJSON']['total_transfer']);
                },
            },
            order: [[7, 'desc']],
            columnDefs: [{
                targets: [0,1,3,4,5,-1],
                className: 'text-center'
            },{
                targets: [-3,-4, -5, -6, -7],
                className: 'text-right'
            }]
        });

        $('#custom_length').on('change', function() {
            dataTable.page.len($(this).val()).draw();
        });
        $('#btnFilter').click(function() {
            dataTable.ajax.reload();
        });
    });

    function send_notif(id_member, tanggal, nominal_bonus, e){
        $.ajax({
            url: 'controller/bonus/send_notif.php',
            type: 'post',
            data: {
                    id_member:id_member, 
                    tanggal:tanggal, 
                    nominal_bonus:nominal_bonus, 
                },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $(e).closest('td').text(obj.message);
                } else {
                    alert(obj.message);
                }
            }
        });
    }
</script>