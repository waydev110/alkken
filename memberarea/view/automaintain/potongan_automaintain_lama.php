<?php 
include ("model/classAutoMaintain.php");
include ("../mysuperadminmlm/model/function.php");

$cam = new classAutoMaintain();

$query = $cam->index($_SESSION['id_login_member']);

?>

<div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Potongan Auto Maintain</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
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
                        while ($data = $query->fetch_object()) {
                            $total += $data->nominal_auto_maintain;
                            ?>
                                <tr>
                                    <td><?=$no;?></td>
                                    <td><?=date('d/m/Y', strtotime($data->created_at));?></td>
                                    <td align="right">Rp<?=rp($data->nominal_auto_maintain);?></td>
                                </tr>
                            <?php
                            
                            $no++;
                        }
                        // echo $total;
                        ?>
                        <tr>
                            <td colspan="2" style="background-color: #CCC;"> Total Automaintain</td>
                            <td align="right" style="background-color: #CCC;"><i><b>Rp<?=rp($total);?></b></i></td>
                        </tr>
            		</tbody>
            		<tfoot>
            			<tr>
                            <th>No</th>
                            <th>Tanggal Potongan</th>
                            <th>Nominal</th>
            			</tr>
            		</tfoot>
            	</table>
            </div>
        </div>
    	</div>
	</div>
</div>