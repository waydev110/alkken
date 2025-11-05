<?php 
require_once '../../../helper/string.php';
require_once '../../../model/classSpinReward.php';
$obj = new classSpinReward();
if(isset($_POST['update'])){
    $mod_url = 'netspin_setting';
    $dir = 'spin_reward';
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
    				document.location="../../?go=<?=$mod_url?>&msg=edit&stat=0";
    			</script>
    		<?php	
        }
    }
    session_start();

	$id = base64_decode($_POST['id']);
	$reward = addslashes(strip_tags($_POST['reward']));
    $nominal = number($_POST['nominal']);
    $bobot = number($_POST['bobot']);
    $persentase_peluang = number($_POST['persentase_peluang']);

	$obj->reward = $reward;
    if(isset($gambar)){
        $obj->gambar = $gambar;
    }
	$obj->nominal = $nominal;
	$obj->bobot = $bobot;
	$obj->persentase_peluang = $persentase_peluang;

	$update = $obj->update($id);
	if($update){
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=edit&stat=1";
			</script>
		<?php	
	}else{
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=edit&stat=0";
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