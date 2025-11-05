<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBank.php';
    $mod_url = 'bank';

    $obj = new classBank();
    
    $nama_bank = addslashes(strip_tags($_POST['nama_bank']));
    $kode_bank = addslashes(strip_tags($_POST['kode_bank']));
    $created_at = date('Y-m-d H:i:s');
    $slug = slug($nama_bank);
    
    if ($_FILES['logo']['size'] <> 0){
        $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
        $file = $_FILES['logo']['name'];
        $x = explode('.', $file);
        $ekstensi = strtolower(end($x));
        $nama_file = $slug.'.'.$ekstensi;
        $ukuran	= $_FILES['logo']['size'];
        $file_tmp = $_FILES['logo']['tmp_name'];	
        $path = "../../../images/bank/".$nama_file;
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            move_uploaded_file($file_tmp, $path);
            $logo = $nama_file;
        } else {
            
    	?>	
        	<script language="javascript">
    			document.location="../../?go=<?=$mod_url?>&msg=tambah&stat=0";
    		</script>
    	<?php
        }
    }
    
    if(isset($logo)){
        $obj->set_logo($logo);
    } else {
        $obj->set_logo(NULL);
    }
    $obj->set_nama_bank($nama_bank);
    $obj->set_kode_bank($kode_bank);    
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