<?php
if(isset($_GET['id'])){
    require_once("../model/classUndianPemenang.php");
    $obj = new classUndianPemenang();
    $id = $_GET['id'];
    $data = $obj->show_master($id);
    $query = $obj->index_transfer($id);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?> <?=$data->undian?></h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="example1">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Doorprize</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                $no = 1;
                while ($row= $query->fetch_object()) {
                ?>
                    <tr>
                        <td align="center"><?=$no;?></td>
                        <td align="center"><?=$row->id_member?></td>
                        <td align="left"><?=$row->nama_member?></td>
                        <td align="center"><?=$row->doorprize?></td>
                        <td align="center"><?=$row->start_date?> s/d <?=$row->end_date?></td>
                        <td align="center"><?=$row->created_at?></td>
                        <td align="center"><button type="button" class="btn btn-primary btn-xs" onclick="transfer('<?=$row->id?>', this)"><i class="fas fa-paper-plane"></i> Proses</button></td>
                    </tr>
                    <?php
                $no++;
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Doorprize</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php
}
?>
<script>
    function transfer(id, e){
        $.ajax({
            url: 'controller/undian/pemenang_proses.php',
            type: 'post',
            data: {
                    id:id
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