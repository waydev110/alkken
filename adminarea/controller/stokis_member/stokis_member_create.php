<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisMember.php';
    require_once '../../../model/classStokisPaket.php';
    require_once '../../../model/classSMS.php';
    $mod_url = 'stokis_member';

    $obj = new classStokisMember();
    $cp = new classStokisPaket();
    $sms = new classSMS();
    $id_paket = addslashes(strip_tags($_POST['id_paket']));
    $nama_stokis = addslashes(strip_tags($_POST['nama_stokis']));
    $no_handphone = number($_POST['no_handphone']);
    $username = addslashes(strip_tags($_POST['username']));
    // $id_provinsi = addslashes(strip_tags($_POST['id_provinsi']));
    $id_kota = addslashes(strip_tags($_POST['id_kota']));
    // $id_kecamatan = addslashes(strip_tags($_POST['id_kecamatan']));
    // $id_kelurahan = addslashes(strip_tags($_POST['id_kelurahan']));
    // $rt = addslashes(strip_tags($_POST['rt']));
    // $rw = addslashes(strip_tags($_POST['rw']));
    // $kodepos = addslashes(strip_tags($_POST['kodepos']));
    // $alamat = addslashes(strip_tags($_POST['alamat']));
    $email = addslashes(strip_tags($_POST['email']));
    $status = 1;
    $created_at = date('Y-m-d H:i:s');
    
    $password = generatePassword();
    $pin = generatePIN();
    $obj->set_id_paket($id_paket);
    $obj->set_nama_stokis($nama_stokis);
    $obj->set_no_handphone($no_handphone);
    $obj->set_username($username);
    $obj->set_pin($pin);
    $obj->set_password($password);
    // $obj->set_id_provinsi($id_provinsi);
    $obj->set_id_kota($id_kota);
    // $obj->set_id_kecamatan($id_kecamatan);
    // $obj->set_id_kelurahan($id_kelurahan);
    // $obj->set_rt($rt);
    // $obj->set_rw($rw);
    // $obj->set_kodepos($kodepos);
    // $obj->set_alamat($alamat);
    $obj->set_email($email);
    $obj->set_status($status);
    $obj->set_created_at($created_at);
    
    $create = $obj->create();
    
    if($create){
        $prefix = $cp->prefix($id_paket);
        $id_stokis = generateID(3, $create, $prefix);
        $obj->set_id_stokis($id_stokis);
        $update = $obj->update_id_stokis($create);        
        $sms->smsPendaftaranStokis($create);
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