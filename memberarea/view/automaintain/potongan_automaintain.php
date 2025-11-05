<?php 
include ("model/classAutoMaintain.php");
include ("../mysuperadminmlm/model/function.php");

$cam = new classAutoMaintain();


$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Daftar Potongan Auto Maintain</h3>

<div class="box-body">
    
<form action="index.php?go=potongan_automaintain" method="post" accept-charset="utf-8">  
Bulan : &nbsp;
<select name="bln">
    <?php
    if ($_POST['thn']){
        $bln = $_POST['bln'];
    }else{    
        $bln = date("m");
    }
    for ($i=1;$i<13;$i++){
        if ($i==$bln){
            echo "<option value='$i' selected>".$nama_bln[$i]."</option>";
        }else{
            echo "<option value='$i'>".$nama_bln[$i]."</option>";
        }
    }
    ?>
</select>&nbsp;&nbsp;
Tahun : &nbsp;
<select name="thn">
    <?php
    if ($_POST['thn']){
        $xthn = $_POST['thn'];
    }else{    
        $xthn = date("Y");
    }
    $thn = date("Y");
    while ($thn>=2019){
        if ($thn==$xthn){
        echo "<option value='$thn' selected>".$thn."</option>";    
        }else{
        echo "<option value='$thn'>".$thn."</option>";
        }
        $thn=$thn-1;
    }
    ?>
</select>&nbsp;
<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-send"></i> Tampilkan</button><br>
</form>
  </div>

      <div class="box-body">
        
        <div class="box-body box-profile">
            <div class="table-responsive">
            	<table class="table table-bordered" id="">
            		<thead>
            			<tr>
                            <th>No</th>
            				<th>Tanggal Potongan</th>
            				<th>Nominal</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php 
                        $no=1;
                        $auto_maintain_ke = 1;
                        $total = 0;
                        $max = $cam->get_max_auto("nominal_automaintain");
                        
                        $query = $cam->index2($_SESSION['id_login_member'],$bln,$xthn);
                        $tot=0;
                        while ($data = $query->fetch_object()) {
                            $total += $data->nominal_auto_maintain;
                            ?>
                                <tr>
                                    <td><?=$no;?></td>
                                    <td><?=date('d/m/Y', strtotime($data->created_at));?></td>
                                    <td align="right">Rp<?=rp($data->nominal_auto_maintain);?></td>
                                </tr>
                            <?php
                            
                            if($total ==$max){
                                ?>
                                <tr>
                                    <td colspan="2" style="background-color: #CCC;"> <i><b>Tercapai Auto Maintain ke-<?=$auto_maintain_ke;?> pada: <?=date('d/m/Y', strtotime($data->created_at));?></b></i></td>
                                    <td align="right" style="background-color: #CCC;"><i><b>Rp<?=rp($total);?></b></i></td>
                                </tr>
                                <?php
                                $total-=$max;
                                $no--;
                                $auto_maintain_ke++;
                            }
                            $tot+=$total;
                            $no++;
                        }
                        ?>
            		</tbody>
            		<tfoot>
            			<tr>
                            <th><?=$no-1;?></th>
                            <th>Tanggal Potongan</th>
                            <th class="text-right">Rp.<?=number_format(round($total),0);?></th>
            			</tr>
            		</tfoot>
            	</table>
            </div>
        </div>
    	</div>
