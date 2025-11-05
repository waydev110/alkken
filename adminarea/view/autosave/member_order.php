<?php
  require_once("../helper/all.php");
  require_once("../model/classMemberAutosave.php");
  require_once("../model/classJasaEkspedisi.php");
  
  $obj = new classMemberAutosave();
  $cje = new classJasaEkspedisi();
  if(isset($_GET["status"])){
    $status = $_GET['status'];
} else {
    $status = '';
}
    $query = $obj->index($status);
  $je = $cje->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Klaim Produk Autosave</h3>
        <div class="box-tools pull-right">
            <a href="index.php?go=klaim_autosave" class="btn btn-sm <?=$status == '' ? 'btn-primary' : 'btn-default'?>">Semua</a>
            <a href="index.php?go=klaim_autosave&status=0" class="btn btn-sm <?=$status == '0' ? 'btn-primary' : 'btn-default'?>">Pending</a>
            <a href="index.php?go=klaim_autosave&status=1" class="btn btn-sm <?=$status == '1' ? 'btn-primary' : 'btn-default'?>">Diproses</a>
            <a href="index.php?go=klaim_autosave&status=2" class="btn btn-sm <?=$status == '2' ? 'btn-primary' : 'btn-default'?>">Dikirim</a>
            <a href="index.php?go=klaim_autosave&status=3" class="btn btn-sm <?=$status == '3' ? 'btn-primary' : 'btn-default'?>">Selesai</a>
            <a href="index.php?go=klaim_autosave&status=4" class="btn btn-sm <?=$status == '4' ? 'btn-primary' : 'btn-default'?>">Ditolak</a>
            <a href="index.php?go=klaim_autosave&status=5" class="btn btn-sm <?=$status == '5' ? 'btn-primary' : 'btn-default'?>">Dibatalkan</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table" id="member-list">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tgl Order</th>
                        <th class="text-center">Data Member</th>
                        <th class="text-center" width="200">Alamat Kirim</th>
                        <th class="text-center" width="100">Jumlah Produk</th>
                        <th class="text-center">Saldo Autosave</th>
                        <th class="text-center">Total Bayar</th>
                        <th class="text-center">Jasa Ekspedisi</th>
                        <th class="text-center">Biaya Kirim</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
          $no = 1; 
          while ($data = $query->fetch_object()) {
            $nama_member = '<strong>'.$data->nama_member.' </strong><br>';
            $hp_member = 'No. Telp :'.$data->hp_member.' <br><br>';
            $provinsi = $data->nama_provinsi == '' ? '' : 'Provinsi '.$data->nama_provinsi.' <br>';
            $nama_kota = $data->nama_kota == '' ? '' : $data->nama_kota.' <br>';
            $nama_kecamatan = $data->nama_provinsi == '' ? '' : 'Kecamatan '.$data->nama_kecamatan.' <br>';
            $nama_kelurahan = $data->nama_kelurahan == '' ? '' : 'Kecamatan '.$data->nama_kelurahan.' <br>';
            $alamat = $nama_member.$hp_member.'<strong>Alamat</strong> : <br>'.$provinsi.$nama_kota.$nama_kecamatan.$nama_kelurahan.$data->alamat_kirim;
            ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-center"><?=$data->created_at;?></td>
                        <td class="text-left"><?=$data->member_id;?></td>
                        <td class="text-left"><?=$alamat;?></td>
                        <td class="text-left">
                        <?php
                        $query_detail_po= $obj->showdetail($data->id);
                                  $nos =1;
                            while ($data_detail_po = $query_detail_po->fetch_object()) {
                              ?>
                                    <?=$nos++;?>. <?=$data_detail_po->nama_produk;?> (<?=number_format($data_detail_po->qty,0,',','.');?>)<br>
                                    <?php
                            }
                        ?>
                        </td>
                        <td class="text-right"><?=currency($data->saldo_poin);?></td>
                        <td class="text-right"><?=currency($data->nominal);?></td>
                        <td class="text-left">
                                <?php 
                                if($data->status >= 2 && $data->status < 4){
                        ?>
                                <p><strong><?=$data->nama_jasa_ekspedisi?></strong></p>
                                <p><strong>No Resi :</strong><br><?=$data->no_resi?></p>
                        <?php
                                }
                                ?>
                        </td>
                        <td class="text-right"><?=currency($data->biaya_kirim);?></td>                        
                        <td class="text-center">
                                <?=vstatus_order($data->status)?>
                        </td>
                        <td class="text-center">
                            <a href="?go=member_autosave_detail&id=<?=base64_encode($data->id);?>" class="btn btn-success btn-xs"><i
                                    class="fa fa-eye"></i> Detail</a>   
                            <?php
                                if($data->status == '0'){
                            ?>                           
                                <button class="btn btn-danger btn-xs" onclick="batalkan_pesanan('<?=$data->id?>')">Batalkan</button>
                                <button class="btn btn-success btn-xs" onclick="proses_pesanan('<?=$data->id?>')">Proses</button>

                            <?php
                                }
                            ?>
                            <?php
                                if($data->status == '1'){
                            ?>
                            <button onclick="showFormResi(<?=$data->id?>,0);" class="btn btn-secondary btn-xs"><i class="fa fa-briefcase"></i> Input Resi</button>
                            <?php
                                }
                            ?>
                            <?php
                                if($data->status == '3'){
                            ?>
                            <button onclick="showFormEditResi(<?=$data->id?>,0);" class="btn btn-secondary btn-xs"><i class="fa fa-briefcase"></i> Edit Resi</button>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
          }
          ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="formResi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-black" id="exampleModalLabel">Input Resi</h4>
            </div>
            <div class="modal-body">
                <form id="formnoresi" method='post' action="controller/autosave/save_resi.php" accept-charset='utf-8' class='inline'>
                    <input type='hidden' name='id_order' id='id_order' value="">
                    <div class="form-group">
                        <label>Jasa Ekspedisi</label>
                        <select  class="form-control" name="jasa_ekspedisi" id="jasa_ekspedisi">
                            <?php while ($row = $je->fetch_object()) {?>
                                <option value="<?=$row->id?>"><?=$row->jasa_ekspedisi?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No Resi</label>
                        <input type="text" class="form-control" id="noresi" name="noresi" placeholder="masukkan no resi"
                            required="required">
                    </div>
                    <div class="form-group">
                        <label>Biaya Kirim</label>
                        <input type="text" class="form-control autonumeric" id="biaya_kirim" name="biaya_kirim"
                            placeholder="masukkan biaya kirim" required="required" value="0">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="save_resi" onclick="save_resi();" class="btn btn-primary">Simpan</button>
            </div>
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

    dataTable = $("#member-list").DataTable({
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
        iDisplayLength: -1,
        columnDefs: [{
            targets: [-1, -2, -6, 0],
            className: 'text-center'
        }]
    });
    function showFormResi(id) {
        $('#id_order').val(id);
        $('.modal-title').text('Input Resi');
        $('#formnoresi')[0].reset();
        $('#formResi').modal('show');
    }
    function showFormEditResi(id) {
        get_data(id);
    }
    
    function get_data(id) {
        $.ajax({
            url: 'controller/autosave/get_data.php',
            method: 'post',
            data: {id:id},
            type: 'POST',
            success: function (result) {
                    const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#id_order').val(id);
                    $('.modal-title').text('Edit Resi');
                    $('#jasa_ekspedisi').val(obj.data.jasa_ekspedisi);
                    $('#noresi').val(obj.data.no_resi);
                    $('#biaya_kirim').val(obj.data.biaya_kirim);
                    $('#formResi').modal('show');
                } else {                    
                    alert('Error.');
                }
            },
        });
    }
    
    function save_resi(id) {
        var formnoresi = $('#formnoresi');
        $.ajax({
            url: formnoresi.attr('action'),
            method: formnoresi.attr('method'),
            data: formnoresi.serialize(),
            type: 'POST',
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    alert(obj.message);
                    document.location="?go=klaim_autosave";
                } else {
                    alert(obj.message);
                    show_error(obj.message, redirect_url);
                }
            },
        });
    }
    function proses_pesanan(id) {
        $.ajax({
            url: 'controller/autosave/proses_pesanan.php',
            data: {
                id: id,
            },
            type: 'POST',
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    // aktivasi_pin();
                    alert(obj.message);
                    document.location="?go=klaim_autosave";
                } else {
                    alert(obj.message);
                    show_error(obj.message, redirect_url);
                }
            },
        });
    }
    function batalkan_pesanan(id) {
        $.ajax({
            url: 'controller/autosave/batalkan_pesanan.php',
            data: {
                id: id,
            },
            type: 'POST',
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    alert(obj.message);
                    document.location="?go=klaim_autosave";
                } else {
                    alert(obj.message);
                    show_error(obj.message, redirect_url);
                }
            },
        });
    }

    function aktivasi_pin() {
        $.ajax({
            url: '../memberarea/controller/posting_ro/posting_ro_auto.php',
            type: 'post',
            success: function (result) {
            }
        });
    }
</script>