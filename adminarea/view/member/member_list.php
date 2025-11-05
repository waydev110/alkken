<?php
require_once("../model/classProvinsi.php");
require_once("../model/classPaket.php");
require_once("../model/classPlan.php");
require_once("../model/classBonusFounder.php");
$cp = new classProvinsi();
$csp = new classPaket();
$cpl = new classPlan();
$cbf = new classBonusFounder();
$data_provinsi = $cp->index();
$data_paket = $csp->index();
$data_plan = $cpl->index(0);
$founder = $cbf->index_founder();
require_once('../model/classProdukJenis.php');
$cpj = new classProdukJenis();
$produk_jenis = $cpj->index(0);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Member</h3>            
        <div class="pull-right">
        </div>
    </div>
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
        <div class="row" id="filterCard">
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="" class="control-label">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control select2">
                                <option value='' selected='selected'></option>
                                <?php 
                              while ($option_prov = $data_provinsi->fetch_object()) {
                                echo '<option value="'.$option_prov->id.'">'.$option_prov->nama_provinsi.'</option>';
                              }
                            ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="control-label">Kab/Kota</label>
                            <select name="kota" id="kota" class="form-control select2">
                                <option value='' selected='selected'></option>
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="control-label">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control select2">
                                <option value='' selected='selected'></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Paket Join</label>
                    <select name="plan" id="plan" class="form-control">
                        <option value='' selected='selected'></option>
                        <?php
                        while($row = $data_plan->fetch_object()){
                        ?>
                        <option value="<?=$row->id?>"><?=$row->nama_plan?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="control-label" for="id_produk_jenis">Jenis Paket</label>
                    <select class="form-control" id="id_produk_jenis" name="id_produk_jenis">
                        <option value=""></option>
                        <?php while ($row = $produk_jenis->fetch_object()) {?>
                        <option value="<?=$row->id?>"
                            <?=$data->id_produk_jenis == $row->id ? 'selected="selected"' : ''?>>
                            <?=$row->short_name?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Founder</label>
                    <select name="founder" id="founder" class="form-control">
                        <option value='' selected='selected'></option>
                        <?php 
                      while ($row = $founder->fetch_object()) {
                        echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                      }
                    ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Reposisi</label>
                    <select name="reposisi" id="reposisi" class="form-control">
                        <option value='' selected='selected'></option>
                        <option value='1'>Ya</option>
                        <option value='0'>Tidak</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="" class="control-label">Status Sharing Profit</label>
                    <select name="qualified" id="qualified" class="form-control">
                        <option value='' selected='selected'>Semua Status</option>
                        <option value='1'>Qualified</option>
                        <option value='0'>Not Qualified</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="" class="control-label">Show</label>
                    <select name="custom_length" id="custom_length" class="form-control">
                        <option value='10' selected='selected'>10</option>
                        <option value='20'>20</option>
                        <option value='50'>50</option>
                        <option value='100'>100</option>
                        <option value='-1'>All</option>
                    </select>
                </div>
                <div class="col-sm-8">
                    <label for="" class="control-label">Pencarian</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="keyword" name="keyword">    
                        <div class="input-group-btn">              
                            <button type="button" class="btn btn-md btn-primary" id="btnFilter"><i class="fa fa-search"></i> Filter Data</button>
                            <button type="reset" class="btn btn-md btn-primary" id="btnReset">Reset Filter</button>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table id="member-list" class="table table-custom table-primary table-striped table-hover" border="1"
                    bordercolor="#ddd">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?=$lang['paket']?></th>
                            <th>ID <?=$lang['member']?></th>
                            <th>Nama <?=$lang['member']?></th>
                            <th>Tgl Daftar</th>
                            <th>Sponsor</th>
                            <th>Stok PIN</th>
                            <th class="text-center" width="80">Aksi</th>
                        </tr>
                    </thead>
                </table>
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
<?php require_once("view/wilayah/wilayah.php"); ?>
<script>
    var dataTable;
    $(document).ready(function () {

        dataTable = $("#member-list").DataTable({
            // sDom: "<'row'<'col-sm-6'l> <'col-sm-6'f>><'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            sDom: "<'table-responsive't><'row'<'col-sm-6'i> <'col-sm-6'p>>",
            processing: true,
            serverSide: true,
            ajax: {
                url: "controller/member/member_list.php",
                data: function (d) {
                    d.provinsi = $('#provinsi').val();
                    d.kota = $('#kota').val();
                    d.kecamatan = $('#kecamatan').val();
                    d.reposisi = $('#reposisi').val();
                    d.id_plan = $('#plan').val();
                    d.id_produk_jenis = $('#id_produk_jenis').val();
                    d.founder = $('#founder').val();
                    d.keyword = $('#keyword').val();
                    d.qualified = $('#qualified').val();
                },
                type: "post",
            },
            columnDefs: [{
                targets: [-1, 0, 1],
                className: 'text-center'
            },{
                targets: [-2],
                className: 'text-right'
            }]
        });


        $('#custom_length').on( 'change', function () {
            dataTable.page.len($(this).val()).draw();
        } );
        $('#btnFilter').click(function(){
            dataTable.ajax.reload();
        });
        $('#btnToggle').click(function(){
            $('#filterCard').toggle();
        });

        $('#btnReset').on('click', (event) => {
            event.preventDefault();
            $('#provinsi').prop('selectedIndex', 0).trigger('change');
            $('#kota').prop('selectedIndex', 0).trigger('change');
            $('#kecamatan').prop('selectedIndex', 0).trigger('change');
            $('#status_member').prop('selectedIndex', 0).trigger('change');
            $('#plan').prop('selectedIndex', 0).trigger('change');
            $('#id_produk_jenis').prop('selectedIndex', 0).trigger('change');
            $('#paket').prop('selectedIndex', 0).trigger('change');
            // $('#reposisi').prop('selectedIndex', 0).trigger('change');
            dataTable.ajax.reload();
        });
    });

    function suspend_member(id_member) {
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Member ini akan di blokir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Blokir Sekarang!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'controller/member/member_suspend.php',
                    type: "POST",
                    data: 'id_member=' + id_member,
                    dataType: "JSON",
                    success: function (data) {
                        if (data == true) {
                            Swal.fire(
                                'Blokir!',
                                'Member berhasil di blokir.',
                                'success'
                            );
                            dataTable.ajax.reload();
                        }
                    }
                });
            }
        })
    }

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


    function sendsmsmember(idmember) {
        if (confirm("Kirim sms ulang?")) {
            $.ajax({
                url: "controller/member/sendsms.php",
                type: "POST",
                data: {
                    id: idmember
                },
                dataType: "html",
                success: function (data) {
                    if (data == 'success') {
                        alert("sukses kirim sms!");
                    } else {
                        alert("gagal kirim sms!");
                    }
                }
            });
        }
    }
</script>