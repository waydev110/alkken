<?php 
    require_once '../../../helper/string.php';
    require_once '../../../model/classPeringkat.php';
    $mod_url = 'peringkat';
    
    $obj = new classPeringkat();
    $id = addslashes(strip_tags($_POST['id']));
    $nama_peringkat = addslashes(strip_tags($_POST['nama_peringkat']));
    $gambar_sebelumnya = $_POST['gambar_sebelumnya'];
	$slug = slug($nama_peringkat);

    if ($_FILES['gambar']['size'] <> 0){
        $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
        $file = $_FILES['gambar']['name'];
        $x = explode('.', $file);
        $ekstensi = strtolower(end($x));
        $nama_file = $slug.'.'.$ekstensi;
        $ukuran	= $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];	
        $path = "../../../images/peringkat/".$nama_file;
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            move_uploaded_file($file_tmp, $path);
            $gambar = $nama_file;
        } else {
            
		?>	
	    	<script language="javascript">
				document.location="../../?go=<?=$mod_url?>&msg=edit&stat=0";
			</script>
		<?php
        }
    }

    $poin = number($_POST['poin']);
    $sponsori = number($_POST['sponsori']);
    $updated_at = date('Y-m-d H:i:s');
    
    if(isset($nama_peringkat)){
        if(isset($gambar)){
            $obj->set_gambar($gambar);
        } else {
            $obj->set_gambar($gambar_sebelumnya);
            
        }
        $obj->set_nama_peringkat($nama_peringkat);
        $obj->set_poin($poin);
        $obj->set_sponsori($sponsori);
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
    }
?>