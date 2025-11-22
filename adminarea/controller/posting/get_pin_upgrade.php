<?php
    session_start();
    require_once '../../../helper/all.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classConnection.php';

    $cka = new classKodeAktivasi();
    $cm = new classMember();
    $cpl = new classPlan();
    $conn = new classConnection();

    if(!isset($_POST['member_id']) || !isset($_POST['owner_id']) || !isset($_POST['current_plan'])){
        echo '<option value="">- PIN tidak tersedia -</option>';
        return false;
    }

    $member_id = number($_POST['member_id']);
    $owner_id = number($_POST['owner_id']);
    $current_plan = number($_POST['current_plan']);

    // Get available upgrade PINs (jenis_aktivasi > current_plan, status_aktivasi = '0')
    $query = "SELECT ka.*, p.nama_plan 
              FROM mlm_kodeaktivasi ka
              LEFT JOIN mlm_plan p ON ka.jenis_aktivasi = p.id
              WHERE ka.id_member = '$owner_id' 
              AND ka.jenis_aktivasi > '$current_plan'
              AND ka.status_aktivasi = '0'
              AND ka.deleted_at IS NULL
              ORDER BY ka.jenis_aktivasi ASC, ka.created_at DESC";
    
    $pins = $conn->_query($query);

    if($pins->num_rows == 0){
        echo '<option value="">- PIN tidak tersedia -</option>';
        return false;
    }

    echo '<option value="">- Pilih PIN -</option>';
    while($pin = $pins->fetch_object()){
        $plan_name = $pin->nama_plan ? $pin->nama_plan : 'Paket ' . $pin->jenis_aktivasi;
        echo '<option value="'.$pin->id.'" data-plan-id="'.$pin->jenis_aktivasi.'" data-plan-name="'.$plan_name.'">'.$pin->kode_aktivasi.' - '.$plan_name.'</option>';
    }
