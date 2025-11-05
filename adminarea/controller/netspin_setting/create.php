<?php 
require_once '../../../helper/string.php';
require_once '../../../model/classSpinReward.php';

if(isset($_POST['simpan'])){
	$obj = new classSpinReward();
    $gambar = NULL;    
    $mod_url = 'netspin_setting';
    $dir = 'spin_reward';
    $gambar = NULL;
    if ($_FILES['gambar']['size'] <> 0){
        $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
        $nama_file = $_FILES['gambar']['name'];
        $x = explode('.', $nama_file);
        $slug = slug($x[0]);
        $ekstensi = strtolower(end($x));
        $ukuran	= $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $new_filename = $slug.'.'.$ekstensi;	
        $path = "../../../images/".$dir."/".$new_filename;

        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){		
            move_uploaded_file($file_tmp, $path);
            $gambar = $new_filename;
        }else{
    		?>	
    	    	<script language="javascript">
    				document.location="../../?go=<?=$mod_url?>&msg=tambah&stat=0";
    			</script>
    		<?php	
        }
    }
    session_start();
	$reward = addslashes(strip_tags($_POST['reward']));
    $nominal = number($_POST['nominal']);
    $bobot = number($_POST['bobot']);
    $persentase_peluang = $_POST['persentase_peluang'];

	$obj->reward = $reward;
	$obj->gambar = $gambar;
	$obj->nominal = $nominal;
	$obj->bobot = $bobot;
	$obj->persentase_peluang = $persentase_peluang;
	$create = $obj->create();
	if($create){
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=tambah&stat=1";
			</script>
		<?php	
	}else{
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=tambah&stat=0";
			</script>
		<?php	
	}
}else{
	?>	
    	<script language="javascript">
			document.location="../../?go=<?=$mod_url?>";
		</script>
	<?php	
}