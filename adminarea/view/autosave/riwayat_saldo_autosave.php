<?php
  require_once("../helper/all.php");
  require_once("../model/classWallet.php");
  
  $obj = new classWallet();
  $query = $obj->saldo_autosave();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Riwayat Saldo Keluar</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table" id="saldo-list">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">ID Member</th>
                        <th class="text-left">Nama Samaran</th>
                        <th class="text-left">Nama Member</th>
                        <th class="text-right">Saldo Autosave</th>
                        <th class="text-right">Transaksi</th>
                        <th class="text-left">Sisa Saldo</th>
                        <th class="text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
          $no = 1; 
          while ($data = $query->fetch_object()) {
            ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-center"><?=$data->id_member;?></td>
                        <td class="text-left"><?=$data->nama_samaran;?></td>
                        <td class="text-left"><?=$data->nama_member;?></td>
                        <td class="text-right"><?=currency($data->masuk);?></td>
                        <td class="text-right"><?=currency($data->keluar);?></td>
                        <td class="text-right"><?=currency($data->sisa);?></td>
                        <td><a target="_blank" href="index.php?go=bypass_login&id=<?=base64_encode($data->member_id)?>" class="btn btn-danger btn-xs bypass"><i class="fa fa-sign-in"></i></a></td>
                    </tr>
                    <?php
          }
          ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
<script>

    dataTable = $("#saldo-list").DataTable({
        sDom: "<'row'<'col-sm-6'l> <'col-sm-6'<'d-flex flex-wrap-reverse align-content-right'fB>>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: { orthogonal: 'export' }
            },
            {
                extend: 'excelHtml5',
                exportOptions: { orthogonal: 'export' }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: { orthogonal: 'export' }
            }
        ],
        aLengthMenu: [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ],
        iDisplayLength: 50,
        columnDefs: [{
            targets: [0, 1, -1],
            className: 'text-center'
        },{
            targets: [-4,-2,-3],
            className: 'text-right'
        }]
    });
</script>