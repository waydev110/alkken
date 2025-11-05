<?php 
include("model/classPeraihAutoMaintain.php");
include("model/classProdukPaketAutoMaintain.php");
include ("model/classAutoMaintain.php");



$cam = new classAutoMaintain();
$cpam = new classPeraihAutoMaintain();
$cppam = new classProdukPaketAutoMaintain();
$query = $cpam->index($_SESSION['id_login_member']);
$query_paket = $cppam->index();

$total =$cam->cek_total_auto_maintain($_SESSION['id_login_member']);
$sisa_saldo =$cam->sisa_saldo($_SESSION['id_login_member']);
?>

<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Klaim Produk Auto Maintain</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body box-profile">
              <h4 class="box-title">Total Saldo Automaintain : Rp. <?=rp($total)?></h4>
              <h4 class="box-title">Sisa Saldo Automaintain  : Rp. <?=rp($sisa_saldo)?></h4>
            </div>
			<div class="box-body box-profile">
				<?php 
		            if(isset($_GET['stat'])){
		              if($_GET['stat']== 1){
		                ?>
		                <div class="alert alert-success alert-dismissible">
		                    <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">&times;</button>
		                    <h4><i class="icon fa fa-check"></i> Info!</h4>
		                    <?=ucwords($_GET['msg']);?> produk automaintain sukses
		                </div>
		                <?php
		              }else{
		                ?>
		                <div class="alert alert-danger alert-dismissible">
		                    <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">&times;</button>
		                    <h4><i class="icon fa fa-ban"></i> Info!</h4>
		                    <?=ucwords($_GET['msg']);?> produk automaintain gagal
		                </div>
		                <?php
		              }
		            }
		          ?>
				<div class="table-responsive">
	            	<table class="table table-bordered" id="example1" style="font-size: 0.9em;">
	            		<thead>
	            			<tr>
	                            <th>No</th>
	            				<th>Tanggal</th>
	            				<th>Produk</th>
	            				<th>Alamat Pengiriman</th>
	            				<th>No Resi</th>
	            				<th>Status Klaim</th>
	            				<th>Aksi</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			<?php 
	            			$no =1 ;
	            			while ($data = $query->fetch_object()) {
	            				// $query_paket = $cppas->index();
	            				?>
	            				<tr>
	            					<td><?=$no;?></td>
	            					<td><?=date('d/m/Y', strtotime($data->created_at));?></td>
	            					<td><?=$data->id_produk_paketautomaintain=='0'?'-':$cppam->get_nama_paket_produk($data->id_produk_paketautomaintain);?></td>
	            					<td><?=$data->alamat_pengiriman;?></td>
	            					<td><?=$data->resi_pengiriman;?></td>
	            					<td><?=$data->status_klaim_produk=='0'?'<span class="text-red">Belum diklaim</span>':'<span class="text-green">Sudah Diklaim</span>';?>
	            					</td>
	            					<td>
	            						<?php
	            						if($data->status_klaim_produk=='0'){
	            							?>
	            							<button type="button" class="btn btn-danger btn-xs" name="proses_klaim" data-toggle="modal" data-target="#myModalKlaimAutoMaintain" data-idklaim="<?=$data->id;?>" ><i class="fa fa-tags"></i> Klaim Produk</button>
	            							<?php
	            						}else{
	            							?>
	            								<form method="POST" action="https://www.jet.co.id/track" accept-charset="UTF-8" id="track-package-form" target="_blank">
	            									<input name="_token" type="hidden" value="cAiVvSzccn2kAbidYC1TezninYqHW2ZsolEm5SlN">
	            									<input type="hidden" name="billcode" value="<?=$data->resi_pengiriman;?>">
	            									<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-truck"></i> Trace & Track</button>
	            								</form>
	            							<?php
	            						}
	            						?>
	            								
	            					</td>
	            				</tr>
	            				<?php
	            				$no ++;
	            			}
	            			?>
	            		</tbody>
	            		<tfoot>
	            			<tr>
	                            <th>No</th>
	            				<th>Tanggal</th>
	            				<th>Produk</th>
	            				<th>Alamat Pengiriman</th>
	            				<th>No Resi</th>
	            				<th>Status Klaim</th>
	            				<th>Aksi</th>
	            			</tr>
	            		</tfoot>
	            	</table>
	            </div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalKlaimAutoMaintain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<h4 class="modal-title" id="myModalLabel">Klaim Produk Auto Maintain</h4>
		</div>
	    <form action="" method="post" accept-charset="utf-8" class="form-horizontal">
			<div class="modal-body">        
				<input type="hidden" name="id_klaim" id="idklaim">
				<div class="box-body">
			        <div class="form-group">
			          	<label for="exampleInputEmail1">Pilih Produk</label>
			         	<select name="id_paket" id="idpaket" size="1" class="form-control" required="required">
							<option value="-" selected="selected">-- Pilih Paket Produk --</option>
							option
							<?php 
							while ($data_paket = $query_paket->fetch_object()) {
								echo '<option value="'.$data_paket->id.'">'.strtoupper($data_paket->nama_paket).'</option>';
							}
							?>
						</select>
			        </div>
					<div class="form-group">
						<label for="recipient-name">Masukkan Alamat Pengiriman</label>
						<textarea name="alamat_pengiriman" class="form-control" id="alamatpengiriman" required="required"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" id="btn-klaim-produk">Klaim sekarang</button>
			</div>
      	</form>
    </div>
  </div>
</div>