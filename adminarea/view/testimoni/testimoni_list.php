<?php 
    require_once("../helper/all.php");
    require_once("../model/classTestimoni.php");
    $ct = new classTestimoni();
    $testimonies = $ct->index();
?>
<style>
    .input-group-addon {
        padding: 5px 12px;
    }

    th {
        display: none;
    }
    #table-testimoni .user-block img {
        height: auto!important;
    }
</style>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Testimoni</h3>
    </div>
    <div class="box-body">
        <table class="table table-hover" id="table-testimoni">
            <thead>
                <tr>
                    <th>Testimoni</th>
                </tr>
            </thead>
            <tbody>
                <?php
        $idtestimoni='0';
        $last_id = '';
        while ($testimoni = $testimonies->fetch_object()){
            $idtestimoni = base64_encode($testimoni->id);
        ?>
                <tr>
                    <td>
                        <div class="post">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="user-block">
                                        <img 
                                            src="../images/plan/<?=$testimoni->gambar?>">
                                        <span class="username">
                                            <a href="#"><?=$testimoni->nama_samaran?></a>
                                        </span>
                                        <span class="description"><?=$testimoni->id_member?> -
                                            <?=tgl_indo_hari($testimoni->created_at).' '.jam($testimoni->created_at)?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right" id="testimoni_<?=$testimoni->id?>">
                                <?php
                                if($testimoni->approved == '1'){
                                ?>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="hideTestimoni('<?=$testimoni->id?>', '0')">Sembunyikan Testimoni</button>
                                <?php
                                } else {
                                ?>
                                    <button class="btn btn-default btn-sm"
                                        onclick="hideTestimoni('<?=$testimoni->id?>', '1')">Tampilkan Testimoni</button>
                                    <?php
                                }
                                ?>
                                </div>
                            </div>
                            <p><?=$testimoni->testimoni?></p>
                        </div>
                    </td>
                </tr>
                <?php
        }
        ?>

            </tbody>
        </table>
    </div>
</div>
<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
    $(function () {

        $("#table-testimoni").DataTable({
            "ordering": false,
        });
    });

    function hideTestimoni(id, status) {
        $.ajax({
            url: 'controller/testimoni/testimoni_hide.php',
            method: 'POST',
            data: {
                id_testimoni: id,
                approved: status
            },
            dataType: 'json',
            success: function (result) {
                if (result.status == 'true' && result.approved == '1') {
                    $('#testimoni_' + id).html(
                        `<button class="btn btn-danger btn-sm pull-right" onclick="hideTestimoni('${id}', '0')">Sembunyikan Testimoni</button>`
                        );
                }
                if (result.status == 'true' && result.approved == '0') {
                    $('#testimoni_' + id).html(
                        `<button class="btn btn-default btn-sm pull-right" onclick="hideTestimoni('${id}', '1')">Tampilkan Testimoni</button>`
                        );
                }
            }
        });
    }
</script>