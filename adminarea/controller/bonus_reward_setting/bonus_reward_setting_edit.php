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
    
    $id = addslashes(strip_tags($_POST['id']));
    $id_peringkat = addslashes(strip_tags($_POST['id_peringkat']));
    $gambar_sebelumnya = addslashes(strip_tags($_POST['gambar_sebelumnya']));
    $poin = number($_POST['poin']);
    $updated_at = date('Y-m-d H:i:s');
    
    if(isset($gambar)){
        $obj->set_gambar($gambar);
    } else {
        $obj->set_gambar($gambar_sebelumnya);
        
    }
    $obj->set_reward($reward);
	$obj->set_nominal($nominal);
	$obj->set_poin($poin);
    $obj->set_id_peringkat($id_peringkat);
    $obj->set_updated_at($updated_at);
    
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