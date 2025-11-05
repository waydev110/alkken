<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusRewardSetting.php';
    $mod_url = 'bonus_reward_setting';

    $obj = new classBonusRewardSetting();
    
    $reward = addslashes(strip_tags($_POST['reward']));
    $nominal = number($_POST['nominal']);
    $slug = slug($reward);
    
    if ($_FILES['gambar']['size'] <> 0){
        $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
        $file = $_FILES['gambar']['name'];
        $x = explode('.', $file);
        $ekstensi = strtolower(end($x));
        $nama_file = $slug.'.'.$ekstensi;
        $ukuran	= $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];	
        $path = "../../../images/reward/".$nama_file;
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            move_uploaded_file($file_tmp, $path);
            $gambar = $nama_file;
        } else {
            
    	?>	
        	<script language="javascript">
    			document.location="../../?go=<?=$mod_url?>&msg=tambah&stat=0";
    		</script>
    	<?php
        }
    }
    
    $id_peringkat = addslashes(strip_tags($_POST['id_peringkat']));
    $poin = number($_POST['poin']);
    $created_at = date('Y-m-d H:i:s');
    
    if(isset($gambar)){
        $obj->set_gambar($gambar);
    }
    $obj->set_reward($reward);
	$obj->set_nominal($nominal);
	$obj->set_poin($poin);
    $obj->set_id_peringkat($id_peringkat);
    $obj->set_created_at($created_at);
    
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