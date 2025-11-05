<?php
	require_once("../model/classUndianKupon.php");
	$obj = new classUndianKupon();
    
    $query = $obj->index(2);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="example1">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Kupon</th>
                        <th class="text-center">Tanggal</th>
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
                        <td align="center"><?=$row->kupon_id?></td>
                        <td align="center"><?=$row->created_at?></td>
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
                        <th class="text-center">Kupon</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>