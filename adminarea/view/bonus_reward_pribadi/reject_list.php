<?php
if(!isset($_GET['plan_reward'])){
    echo 'Terjadi Kesalahan Parameter';
    exit();
}
$_plan_id = $_GET['plan_reward'];
require_once '../model/classProdukJenis.php';
$cpl = new classProdukJenis();
$_plan_reward = $cpl->show($_plan_id);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Hidden <?= $title ?></h3>
        <a href="?go=<?=$mod_url?>_transfer&plan_reward=<?=$_plan_id?>" class="btn btn-primary btn-sm pull-right"><i class="fas fa-paper-plane"></i>
            Transfer Bonus</a>
    </div>
    <div class="box-body">
        <?= vrekap_bonus() ?>
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID <?= $lang['member'] ?></th>
                    <th class="text-center">Nama <?= $lang['member'] ?></th>
                    <th class="text-center">Bank</th>
                    <th class="text-center">Kode</th>
                    <th class="text-center">No Rekening</th>
                    <th class="text-center">Cabang</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Admin</th>
                    <th class="text-center">Jumlah Transfer</th>
                    <th class="text-center" width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    var id_plan = '<?=$_plan_id?>';
    var mod_url = '<?=$mod_url?>';
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function() {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l><'col-sm-6'<'d-flex justify-content-end'fB>>><'table-responsive't><'row'<'col-sm-6'i><'col-sm-6'p>>",
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
                [10,25, 50, 100, 200, -1],
                [10,25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 10,
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: `controller/${mod_url}/reject_list.php`,
                type: "post",
                data:function(d){
                    d.id_plan = id_plan
                },
                complete: function(event, xhr, options) {
                    $('#total_bonus').text(event['responseJSON']['total_bonus']);
                    $('#total_admin').text(event['responseJSON']['total_admin']);
                    $('#total_transfer').text(event['responseJSON']['total_transfer']);
                },
            },
            columnDefs: [{
                targets: [0, 1, 3, 4, 5, -1],
                className: 'text-center'
            }, {
                targets: [6, 7, 8, 9],
                className: 'text-right'
            }]
        });
    });

    function pending(id_member, tanggal, nominal_bonus, e) {
        Swal.fire({
            title: 'Apa kamu yakin menampilkan bonus ini?',
            text: "Bonus akan ditampilkan dihalaman transfer bonus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tampilkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `controller/${mod_url}/pending.php`,
                    type: 'post',
                    data: {
                        id_member: id_member,
                        tanggal: tanggal,
                        nominal_bonus: nominal_bonus,
                    },
                    success: function(result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            $(e).closest('td').text(obj.message);
                        } else {
                            alert(obj.message);
                        }
                    }
                });
            }
        })
    }
</script>