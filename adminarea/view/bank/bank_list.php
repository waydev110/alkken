<?php
	require_once("../model/classBank.php");
	$obj = new classBank();
    
    $query = $obj->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i>
            Tambah</a>
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
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Logo</th>
                        <th class="text-center">Nama Bank</th>
                        <th class="text-center">Kode Bank</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Logo</th>
                        <th class="text-center">Nama Bank</th>
                        <th class="text-center">Kode Bank</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            AutoWidth: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/bank/bank_list.php",
                type: "post"
            },
            columnDefs: [{
                targets: [0,1,-1,-2],
                className: 'text-center'
            }]
        });
    });
    function hapus(id) {
        $.ajax({
            url: 'controller/bank/bank_delete.php',
            type: 'post',
            data: {id:id},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload(); 
                    // alert('Bank berhasil dihapus.');
                } else {
                    alert('Bank gagal dihide.');
                }
            }
        });
    }
    function restore(id) {
        $.ajax({
            url: 'controller/bank/bank_restore.php',
            type: 'post',
            data: {id:id},
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    dataTable.ajax.reload(); 
                } else {
                    // alert('Bank gagal dihide.');
                }
            }
        });
    }
</script>