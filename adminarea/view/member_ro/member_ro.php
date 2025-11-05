<?php
require_once("../model/classPaket.php");
$csp = new classPaket();
$data_paket = $csp->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>            
        <div class="pull-right">
            <div class="btn-group" id="btn-group">
                <button type="button" class="btn btn-sm btn-primary" id="btnToggle"><i class="fa fa-filter"></i> Filter</button>
                <!-- <button type="button" class="btn btn-primary" onclick="download()"><i class="fa fa-download"></i></button> -->
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row" id="filterCard">
            <div class="col-sm-10">
                <div class="row">
                    <label for="" class="control-label col-sm-2">Mulai Tanggal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control datepicker" id="start_date" name="start_date" placeholder="Mulai Tanggal">
                    </div>
                    <label for="" class="control-label col-sm-2">Sampai Tanggal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control datepicker" id="end_date" name="end_date" placeholder="Mulai Tanggal">
                    </div>
                </div>
            </div>
            <div class="col-sm-2 text-right">
                <button type="button" class="btn btn-sm btn-primary" id="btnFilter">Submit</button>
                <button type="reset" class="btn btn-sm btn-primary" id="btnReset">Reset</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table id="member-listro" class="table table-custom table-primary table-striped table-hover" border="1"
                        bordercolor="#ddd">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID <?=$lang['member']?></th>
                                <th>Nama <?=$lang['member']?></th>
                                <th>Tgl Pertama RO</th>
                                <th>Tgl Terbaru RO</th>
                                <th>Jumlah RO</th>
                                <th>Nominal RO</th>
                                <th class="text-center" width="80">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">History <?=$lang['paket']?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="table-history-paket" class="table table-hover" border="1" bordercolor="#ddd">
                        <thead>
                            <tr>
                                <th><?=$lang['paket']?></th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataHistory">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.all.min.js"></script>
<script>
    var dataTable;
    $(document).ready(function () {

        dataTable = $("#member-listro").DataTable({
            sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            processing: false,
            serverSide: true,
            ajax: {
                url: "controller/member_ro/member_ro.php",
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
                type: "post",
            },
            columnDefs: [{
                targets: [-1,-3, 0, 1, 2, 4, 5],
                className: 'text-center'
            },{
                targets: [-2],
                className: 'text-right'
            }]
        });

        $('#btnFilter').click(function(){
            dataTable.ajax.reload();
        });
        $('#btnToggle').click(function(){
            $('#filterCard').toggle();
        });

        $('#btnReset').on('click', (event) => {
            event.preventDefault();
            $('#start_date').val('')
            dataTable.ajax.reload();
        });
    });

    function showPaket(id_member) {
        $.ajax({
            url: 'controller/member/getpaket.php',
            type: "POST",
            data: 'id_member=' + id_member,
            dataType: "html",
            success: function (data) {
                $('#dataHistory').html(data);
                $('#history').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
    }
</script>