<?php 
    require_once '../../../helper/string.php';
    require_once '../../../model/classBank.php';
    $mod_url = 'bank';
    
    $obj = new classBank();
    $id = addslashes(strip_tags($_POST['id']));
    $nama_bank = addslashes(strip_tags($_POST['nama_bank']));
    $kode_bank = addslashes(strip_tags($_POST['kode_bank']));
    $logo_sebelumnya = $_POST['logo_sebelumnya'];
    $updated_at = date('Y-m-d H:i:s');

    if ($_FILES['logo']['size'] <> 0){
        $slug = slug($nama_bank);
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
        $obj->set_logo($logo_sebelumnya);
        
    }
    $obj->set_nama_bank($nama_bank);
    $obj->set_kode_bank($kode_bank);    
    $obj->set_updated_at($updated_at);

    $update = $obj->update($id);

    if($update){
        ?>	
            <script language="javascript">
                document.location="../../index.php?go=<?=$mod_url?>&msg=edit&stat=1";
            </script>
        <?php	
    }else{
        ?>	
            <script language="javascript">
                document.location="../../?go=<?=$mod_url?>&msg=edit&stat=0";
            </script>
        <?php
    }
?>