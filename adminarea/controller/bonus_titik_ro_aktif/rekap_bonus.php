<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusUpline.php';
    require_once '../../../model/classKodeAktivasi.php';
    
    $obj = new classBonusUpline();
    $cka = new classKodeAktivasi();
    
    $bulan = date('Y-m', strtotime('-1 month'));
    // $bulan = date('Y-m');
    $jenis_bonus = 14;
    $kode_aktivasi = $cka->get_aktivasi_ro_aktif($bulan, $jenis_bonus);
    
    while($row = $kode_aktivasi->fetch_object()){
        $member_id = $row->member_id;
        $id_member = $row->id_member;
        $nama_samaran = addslashes(strip_tags($row->nama_samaran));
        $id_kodeaktivasi = $row->id;
        $bonus_upline = $row->bonus_upline;
        $max = $obj->max_generasi($jenis_bonus);
        $nama_plan_produk = $row->nama_plan.' '.$row->name;
        $harga = $row->harga;
        $keterangan = 'Paket '.$nama_plan_produk.' ('.rp($harga).')';
        $created_at = date('Y-m-d', strtotime($bulan . '-' . date('d')));
        
        echo 'Member ID :'.$member_id.'<br>';
        echo 'ID Member :'.$id_member.'<br>';
        echo 'Nama Samaran :'.$nama_samaran.'<br>';
        echo 'ID Kodeaktivasi :'.$id_kodeaktivasi.'<br>';
        echo 'Bonus Level :'.$bonus_upline.'<br>';
        echo 'Max Level :'.$max.'<br>';
        echo 'Created :'.$created_at.'<br>';
        echo 'Keterangan :'.$keterangan.'<br><br>';
        $obj->create_rekap($member_id, $id_member, $nama_samaran, $bonus_upline, $jenis_bonus, $keterangan, $id_kodeaktivasi, $max, $created_at, $bulan);
    }
    echo 'Rekap Selesai';