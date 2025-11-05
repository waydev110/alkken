<?php 
require_once '../../../helper/string.php';
require_once '../../../model/classBerita.php';
if(isset($_POST['update_berita'])){
	$cp = new classBerita();
    $gambar = NULL;
	$judul = addslashes(strip_tags($_POST['judul']));
    $slug = slug($judul);
    if ($_FILES['gambar']['size'] <> 0){
        $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
        $nama_file = $_FILES['gambar']['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        $ukuran	= $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $new_filename = $slug.'.'.$ekstensi;
        $targetDir = '../../../images/berita/';
        $path = $targetDir.$new_filename;
        
        // Pastikan folder upload ada atau buat jika tidak ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if($ukuran < 16594080){	
                move_uploaded_file($file_tmp, $path);
                $gambar = $new_filename;
            }else{
                ?>	
                    <script language="javascript">
                        document.location="../../?go=berita_list&msg=edit&stat=0";
                    </script>
                <?php	
            }
        }else{
    		?>	
    	    	<script language="javascript">
    				document.location="../../?go=berita_list&msg=edit&stat=0";
    			</script>
    		<?php	
        }
    }
    session_start();
    $id_admin = $_SESSION['id_login'];

	$id = base64_decode($_POST['id']);
	$isi = $_POST['isi'];
	$publish_status = addslashes(strip_tags($_POST['publish_status']));

	$cp->set_slug($slug);
	$cp->set_judul($judul);
	$cp->set_gambar($gambar);
	$cp->set_isi($isi);
	$cp->set_publish_status($publish_status);
	$cp->set_id_admin($id_admin);

	$update = $cp->update($id);
	if($update){
		?>	
	    	<script language="javascript">
				document.location="../../?go=berita_list&msg=edit&stat=1";
			</script>
		<?php	
	}else{
		?>	
	    	<script language="javascript">
				document.location="../../?go=berita_list&msg=edit&stat=0";
			</script>
		<?php	
	}
}else{
	?>	
    	<script language="javascript">
			document.location="../../?go=berita_list";
		</script>
	<?php	
}