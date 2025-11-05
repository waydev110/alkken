<?php
    require_once '../helper/all.php';
    require_once '../model/classMemberOrder.php';
    require_once '../model/classJasaEkspedisi.php';

    $obj = new classMemberOrder();
    $cje = new classJasaEkspedisi();
    if(isset($_GET["status"])){
        $status = $_GET['status'];
    } else {
        $status = '2';
    }
    $query = $obj->index_stokis($session_stokis_id, $status);
    $je = $cje->index();
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Order Produk</h3>
        <div class="box-tools pull-right">
            <!-- <a href="index.php?go=member_order" class="btn btn-sm <?=$status == '' ? 'btn-primary' : ''?>">Semua</a> -->
            <!-- <a href="index.php?go=member_order&status=-1" class="btn btn-sm <?=$status == '-1' ? 'btn-primary' : ''?>">Menunggu Pembayaran</a>
            <a href="index.php?go=member_order&status=0" class="btn btn-sm <?=$status == '0' ? 'btn-primary' : ''?>">Pending</a> -->
            <a href="index.php?go=member_order&status=1" class="btn btn-sm <?=$status == '1' ? 'btn-primary' : ''?>">Perlu Dikirim</a>
            <a href="index.php?go=member_order&status=2" class="btn btn-sm <?=$status == '2' ? 'btn-primary' : ''?>">Dikirim</a>
            <a href="index.php?go=member_order&status=3" class="btn btn-sm <?=$status == '3' ? 'btn-primary' : ''?>">Selesai</a>
            <a href="index.php?go=member_order&status=4" class="btn btn-sm <?=$status == '4' ? 'btn-primary' : ''?>">Ditolak</a>
            <a href="index.php?go=member_order&status=5" class="btn btn-sm <?=$status == '5' ? 'btn-primary' : ''?>">Dibatalkan</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-hover" border="1" bordercolor="#ddd" id="example1">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal Order</th>
                        <th class="text-center">ID Member</th>
                        <th class="text-center">Nama Member</th>
                        <th class="text-center">Total Harga</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
          $no = 1; 
          while ($data = $query->fetch_object()) {
            ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-center"><?=$data->created_at;?></td>
                        <td class="text-center"><?=$data->member_id;?></td>
                        <td class="text-center"><?=$data->nama_member;?></td>
                        <td class="text-right"><?=currency($data->nominal);?></td>
                        <td class="text-center"><?=vstatus_order($data->status)?></td>
                        <td class="text-center">
                            <a href="?go=member_order_detail&id=<?=base64_encode($data->id);?>" class="btn btn-success btn-xs"><i
                                    class="fa fa-eye"></i> Detail</a>
                            <?php
                                if($data->status == '1'){
                            ?>
                            <button onclick="showFormResi(<?=$data->id?>,0);" class="btn btn-primary btn-xs"><i class="fa fa-briefcase"></i> Input Resi</button>
                            <?php
                                }
                            ?>
                            <?php
                                if($data->status == '2'){
                            ?>
                            <button onclick="showFormEditResi(<?=$data->id?>,0);" class="btn btn-primary btn-xs"><i class="fa fa-briefcase"></i> Edit Resi</button>
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
                <h4 class="modal-title" id="exampleModalLabel">Input Resi</h4>
            </div>
            <div class="modal-body">
                <form id="formnoresi" method='post' action="controller/member_order/save_resi.php" accept-charset='utf-8' class='inline'>
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
                        <input type="text" class="form-control" id="biaya_kirim" name="biaya_kirim" required="required" value="0">
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
<script>
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
            url: 'controller/member_order/get_data.php',
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
                    alert('Resi pengiriman berhasil diinput.');
                    formnoresi.modal('hide');
                } else {                    
                    alert('Error. Resi pengiriman gagal diinput.');
                }
                document.location="?go=member_order";
            },
        });
    }
</script>