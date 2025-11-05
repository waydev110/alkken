<?php
    session_start();
    $id_stokis = $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../helper/date.php';
    require_once '../../../model/classStokisMember.php';
    require_once '../../../model/classStokisPaket.php';
    require_once '../../../model/classSMS.php';
    $mod_url = 'profil';

    $obj = new classStokisMember();
    $cp = new classStokisPaket();
    $csms    = new classSMS();
    if(isset($_POST['nama_stokis'])){
        $nama_stokis = addslashes(strip_tags($_POST['nama_stokis']));
        $no_handphone = addslashes(strip_tags($_POST['no_handphone']));
        $email = addslashes(strip_tags($_POST['email']));
        $obj->set_nama_stokis($nama_stokis);
        $obj->set_no_handphone($no_handphone);
        $obj->set_email($email);
    }
    if(isset($_POST['username'])){
    
        $username = addslashes(strip_tags($_POST['username']));
        $password = base64_encode($_POST['password']);
        $obj->set_username($username);
        $password = base64_encode($_POST['password']);
    }
    if(isset($_POST['id_provinsi'])){
        $id_provinsi = addslashes(strip_tags($_POST['id_provinsi']));
        $id_kota = addslashes(strip_tags($_POST['id_kota']));
        $id_kecamatan = addslashes(strip_tags($_POST['id_kecamatan']));
        $id_kelurahan = addslashes(strip_tags($_POST['id_kelurahan']));
        $rt = addslashes(strip_tags($_POST['rt']));
        $rw = addslashes(strip_tags($_POST['rw']));
        $kodepos = addslashes(strip_tags($_POST['kodepos']));
        $alamat = addslashes(strip_tags($_POST['alamat']));
        $obj->set_id_provinsi($id_provinsi);
        $obj->set_id_kota($id_kota);
        $obj->set_id_kecamatan($id_kecamatan);
        $obj->set_id_kelurahan($id_kelurahan);
        $obj->set_rt($rt);
        $obj->set_rw($rw);
        $obj->set_kodepos($kodepos);
        $obj->set_alamat($alamat);
    }
    $updated_at = date('Y-m-d H:i:s');
    $obj->set_updated_at($updated_at);
    
    $update = $obj->update($id_stokis);
    $csms->smsEditProfil($id_stokis, $updated_at);
    if($update){
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