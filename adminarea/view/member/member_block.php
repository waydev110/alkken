<?php
require_once("../model/classProvinsi.php");
$cp = new classProvinsi();
$data_provinsi = $cp->index();
?>
<style>
  .box-filter,
  .box-filter .box-title {
    font-size: 1em;
  }

  .table-custom {
    font-size: 0.9em;
  }

  .table-custom>thead>tr>th,
  .table-custom>tfoot>tr>th {
    vertical-align: middle;
    border-bottom: 2px solid #fff;
    background: #5f8f66;
    color: #e8e8e8;
  }

  .table-custom>tbody>tr>td:last-child {
    vertical-align: middle;
  }

  .table-custom.table-striped>tbody>tr:nth-child(2n+1)>td,
  .table-custom.table-striped>tbody>tr:nth-child(2n+1)>th {
    background-color: #dff0d8;
  }

  .table-custom.table-striped>tbody>tr>td,
  .table-custom.table-striped>tbody>tr>th {
    padding: 4px 10px;
  }

  .table-custom.dataTable thead>tr>th.sorting_disabled {
    padding-right: 8px;
  }

  .table-primary>thead>tr>th,
  .table-primary>tfoot>tr>th {
    vertical-align: middle;
    border-bottom: 2px solid #fff;
    background: #0088cb;
    color: #e8e8e8;
  }

  .table-primary.table-striped>tbody>tr:nth-child(2n+1)>td,
  .table-primary.table-striped>tbody>tr:nth-child(2n+1)>th {
    background-color: #c7c7c7;
  }
</style>
<div class="box box-primary box-filter">
  <div class="box-body">
        <form action="?go=member_list" class="form-horizontal" id="form-filter">
            <div class="col-sm-3">
                <label for="" class="control-label">Jenis Akun</label>
                <select name="reposisi" id="reposisi" class="form-control">
                    <option value='' selected='selected'> -- Semua Jenis Akun -- </option>
                    <option value='0'>Berbayar</option>
                    <option value='1'>Free</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="" class="control-label">Provinsi</label>
                <select name="provinsi" id="provinsi" class="form-control select2">
                    <option value='' selected='selected'> -- Semua Provinsi -- </option>
                    <?php 
                      while ($option_prov = $data_provinsi->fetch_object()) {
                        echo '<option value="'.$option_prov->id.'">'.$option_prov->nama_provinsi.'</option>';
                      }
                    ?>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="" class="control-label">Kab/Kota</label>
                <select name="kota" id="kota" class="form-control select2">
                    <option value='' selected='selected'> -- Semua Kab/Kota -- </option>
                    ?>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="" class="control-label">Kecamatan</label>
                <select name="kecamatan" id="kecamatan" class="form-control select2">
                    <option value='' selected='selected'> -- Semua Kecamatan -- </option>
                </select>
            </div>
            <div class="col-sm-9 text-right" style="padding-top:15px">
                <button type="submit" class="btn btn-primary" id="btnFilter">Filter</button>
                <button type="reset" class="btn btn-primary" id="btnReset">Reset</button>
                <!-- <button type="button" class="btn btn-primary" onclick="download()">Download</button> -->
            </div>
        </form>
  </div>
</div>
<div class="box box-primary">
  <!-- <div class="box-header with-border"> -->
  <!-- <h3 class="box-title">Daftar Members</h3> -->
  <!--<a href="?go=member_create" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i> Add Member</a>-->
  <!-- </div> -->
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
    <div class="table-responsive">
      <table id="member-list-new" class="table table-custom table-primary table-striped table-hover" border="1"
        bordercolor="#ddd">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Member</th>
                    <th>Peringkat</th>
                    <th>Nama Member</th>
                    <!-- <th>Username</th> -->
                    <!-- <th>Kab/Kota</th> -->
                    <!-- <th>No. HP</th> -->
                    <th>Tgl Daftar</th>
                    <th>Tgl Blokir</th>
                    <th>Tgl Aktif Kembali</th>
                    <!-- <th>Password</th>
        <th>PIN Member</th> -->
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>ID Member</th>
                    <th>Peringkat</th>
                    <th>Nama Lengkap</th>
                    <!-- <th>Username</th> -->
                    <!-- <th>Kab/Kota</th> -->
                    <!-- <th>No. HP</th> -->
                    <th>Tgl Daftar</th>
                    <th>Tgl Blokir</th>
                    <th>Tgl Aktif Kembali</th>
                    <!-- <th>Password</th>
        <th>PIN</th> -->
                    <th class="text-center">Aksi</th>
                </tr>
            </tfoot>
      </table>
    </div>
  </div>
</div>

<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.all.min.js"></script>
<?php require_once("view/wilayah/wilayah.php"); ?>
<script>
  var dataTable;
  
  $(document).ready(function () {

    dataTable = $("#member-list-new").DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "controller/member/member_list_block.php",
        data: function (d) {
          d.provinsi = $('#provinsi').val();
          d.kota = $('#kota').val();
          d.kecamatan = $('#kecamatan').val();
        },
        type: "post",
      },
    });

    $('#form-filter').on('submit', (event) => {
      event.preventDefault();
      dataTable.ajax.reload();
    });

    $('#btnReset').on('click', (event) => {
      event.preventDefault();
      $('#provinsi').prop('selectedIndex', 0).trigger('change');
      $('#kota').prop('selectedIndex', 0).trigger('change');
      $('#kecamatan').prop('selectedIndex', 0).trigger('change');
      dataTable.ajax.reload();
    });
  });
  
  function aktifkan_member(id){
        Swal.fire({
          title: 'Apa kamu yakin?',
          text: "Member ini akan di aktifkan kembali.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Aktifkan Sekarang!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: 'controller/member/member_aktifkan_blockir.php',
              type: "POST",
              data: 'id=' + id,
              dataType: "JSON",
              success: function (data) {
                if (data == true) {
                    Swal.fire(
                      'Aktif!',
                      'Member berhasil di aktifkan.',
                      'success'
                    );
                    dataTable.ajax.reload();
                }
              }
            });
          }
        })
  }
</script>