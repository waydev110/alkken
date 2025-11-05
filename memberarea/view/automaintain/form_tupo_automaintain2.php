<?php 
if(isset($_POST['btn_tupo'])){
	#generate token
	#if (empty($_SESSION['token'])) {
	    if (function_exists('mcrypt_create_iv')) {
	        $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
	    } else {
	        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
	    }
	#}
		$token = $_SESSION['token'];
	include ("model/classAutoMaintain.php");
	include ("../mysuperadminmlm/model/function.php");

	$cam = new classAutoMaintain();

	$saldo_capaian_bulan_ini = $cam->index_tupo($_SESSION['id_login_member'], date('Y-m', time()));
	$saldo_capaian_tupo      = $cam->get_max_auto('nominal_automaintain');
	$kekurangan_saldo 		 = $saldo_capaian_tupo-$saldo_capaian_bulan_ini;
	$total_transfer 		 = ($saldo_capaian_tupo-$saldo_capaian_bulan_ini)<30000?30000:$saldo_capaian_tupo-$saldo_capaian_bulan_ini;
	?>

	<div class="row">
	    <div class="col-md-12">
	      <div class="box box-primary">
	        <div class="box-header with-border">
	          <h3 class="box-title">Tutup Poin Auto Maintain</h3>
	          <div class="box-tools pull-right">
	            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	            </button>
	          </div>
	        </div>
	        <div class="box-body box-profile">
	          	<form class="form-horizontal" method="post" action="controller/automaintain/tupo_automaintain.php">
	          		<input type="hidden" name="token" value="<?=$token;?>">
			      	<div class="box-body">        
				        <div class="form-group">
				          <label for="" class="col-sm-2 control-label">Saldo Capaian</label>
				          <div class="col-sm-10">
				            <input type="text" class="form-control" name="saldo_capaian" readonly="readonly" required="required" value="Rp<?=number_format($saldo_capaian_tupo,0,',','.');?>">
				          </div>
				        </div>

				        <div class="form-group">
				          <label for="" class="col-sm-2 control-label">Saldo Anda Saat Ini</label>
				          <div class="col-sm-10">
				            <input type="text" class="form-control" name="saldo_terakhir" readonly="readonly" required="required" value="Rp<?=number_format($saldo_capaian_bulan_ini,0,',','.');?>">
				          </div>
				        </div>

				        <div class="form-group">
				          <label for="" class="col-sm-2 control-label">Kekurangan Saldo</label>
				          <div class="col-sm-10">
				            <input type="text" class="form-control" name="kekurangan_saldo" readonly="readonly" required="required" value="Rp<?=number_format($kekurangan_saldo,0,',','.');?>">
				          </div>
				        </div>

				        <div class="form-group">
				          <label for="" class="col-sm-2 control-label">Total Transfer</label>
				          <div class="col-sm-10">
				            <input type="text" class="form-control" name="total_transfer" readonly="readonly" required="required" value="Rp<?=number_format($total_transfer,0,',','.');?>">
				            <span class="text-red">Note: Jika Nominal Tupo kurang dari 30.000 maka berlaku minimal transfer 30.000. Sisa saldo Anda akan ditambahkan untuk bulan depan.</span>
				          </div>
				        </div>

				        <div class="form-group">
				          <label for="" class="col-sm-2 control-label">Pilih Bank</label>
				          <div class="col-sm-10">
				            <select name="bank_transfer" size="1" class="form-control">
				            	<option value="1">1. Bank BRI</option>
				            	<option value="2">2. Bank BCA</option>
				            	<option value="3">3. Bank Mandiri</option>
				            </select>
				            <span class="text-red">Note: Bank yang sudah Anda pilih tidak dapat diubah, karena digunakan untuk pengecekan pembayaran Tutup Poin.</span>
				          </div>
				        </div>

			    	</div>
			    	<div class="box-footer">
			    		<button type="button" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Batal</button>
			    		<button type="submit" class="btn btn-sm btn-primary pull-right" name="btn_send_tupo"><i class="fa fa-send"></i> Proses Tupo</button>
			    	</div>
			    </form>
	        </div>
	      </div>
	  </div>
	</div>



	<?php
}else{
	?>
		<script language="javascript">
			document.location="index.php";
		</script>
	<?php
}
?>