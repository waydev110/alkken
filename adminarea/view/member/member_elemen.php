<?php
    require_once('../model/classMember.php');
    $cm = new classMember();
    
    $elemen = $cm->daftar_elemen();
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Daftar Members</h3>
    <!--<a href="?go=member_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i> Add Member</a>-->
  </div> 
  <!-- /.box-header -->
  <div class="box-body">
    <?php 
      if(isset($_GET['stat'])){
        if($_GET['stat']== 1){
          ?>
          <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-check"></i> Info!</h4>
              <?=ucwords($_GET['msg']);?> data sukses
          </div>
          <?php
        }else{
          ?>
          <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Info!</h4>
              <?=ucwords($_GET['msg']);?> data gagal
          </div>
          <?php
        }
      }
    ?>
    <div class="row mb-4" id="filterCard">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3">
                    <label for="" class="control-label">Nama Elemen</label>
                    <select name="angka_elemen" id="angka_elemen" class="form-control">
                        <option value=''>Tampilkan Semua</option>
                    <?php 
                        while ($row = $elemen->fetch_object()) {
                        echo '<option value="'.$row->id.'">'.$row->nama_elemen.'</option>';
                        }
                    ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Tampilkan</label>
                    <select name="tgl_lahir_member" id="tgl_lahir_member" class="form-control select2">
                        <option value="<?=date('Y-m-d')?>" selected='selected'>Member Ulang Tahun</option>
                        <option value=''>Tampilkan Semua</option>
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="" class="control-label">Notif</label>
                    <select name="notif" id="notif" class="form-control select2">
                        <option value='2'>Belum</option>
                        <option value='1'>Terkirim</option>
                        <option value='0'>Semua</option>
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Pencarian</label>
                    <input type="text" class="form-control" id="keyword" name="keyword">
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
      <table id="member-elemen" class="table table-custom table-primary table-striped table-hover" border="1" bordercolor="#ddd">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Member</th>
            <th>Nama Member</th>
            <th>Tanggal Lahir</th>
            <th>Angka Elemen</th>
            <th>Nama Elemen</th>
            <th>Kiri</th>
            <th>Kanan</th>            
            <th>Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>No</th>
            <th>ID Member</th>
            <th>Nama Member</th>
            <th>Tanggal Lahir</th>
            <th>Angka Elemen</th>
            <th>Nama Elemen</th>
            <th>Kiri</th>
            <th>Kanan</th>            
            <th>Aksi</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.all.min.js"></script>
<script>
  var dataTable;
  $(document).ready(function () {

    dataTable = $("#member-elemen").DataTable({
    sDom: "<'row'<'col-sm-6'l>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
    processing: true,
    serverSide: true,
      ajax: {
        url: "controller/member/member_elemen.php",
        data: function (d) {
            d.angka_elemen = $('#angka_elemen').val();
            d.tgl_lahir_member = $('#tgl_lahir_member').val();
            d.keyword = $('#keyword').val();
            d.custom_length = $('#custom_length').val();
            d.notif = $('#notif').val();
        },
        type: "post",
      },
    });
    
    $('#angka_elemen').change(function(){
       dataTable.ajax.reload(); 
    });
    $('#tgl_lahir_member').change(function(){
       dataTable.ajax.reload(); 
    });
    $('#keyword').keyup(function(){
       dataTable.ajax.reload(); 
    });
    $('#custom_length').change(function(){
       dataTable.ajax.reload(); 
    });
    $('#notif').change(function(){
       dataTable.ajax.reload(); 
    });
  });
  

    function sendsmsbirthday(idmember){
        if (confirm("Kirim notif Ulang tahun?")){    
          $.ajax({
            url: "controller/member/sendsmsbirthday.php",
            type: "POST",
            data: {id : idmember},
            dataType: "html",
            success: function(data){
                alert("sukses kirim sms!");
                dataTable.ajax.reload(); 
            }
          });
        }
    }

</script>
