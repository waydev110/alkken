<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusRoyaltiOmset.php';
    
    $cbro = new classBonusRoyaltiOmset();
    
    $bulan = date('Y-m', strtotime('-1 month'));
    // $bulan = date('Y-m');
    $budget = 20000;
    $omset = $cbro->omset($bulan, $budget);
    $created_at = date('Y-m-d H:i:s');
    
    $log_file = '../../../log/bonus_royalti_omset/log-'.$bulan.'.txt';
    $log = '';
    
    $log .= "Bulan. :".$bulan."\n";
    $log .= "Budget. :".rp($budget)." x poin reward \n";
    $log .= "Omset. :".rp($omset)."\n\n";
    $setting = $cbro->setting_bonus();
    
    while($row = $setting->fetch_object()){
        $persentase = $row->percent_royalti;
        $id_peringkat = $row->id;
        $total_royalti = $omset*$persentase/100;
        $last_date = date('Y-m-t', strtotime($bulan . '-01'));
        $total_member = $cbro->total_member_peringkat($last_date, $id_peringkat);
            
        if($total_royalti > 0 && $total_member > 0){
            $nominal_bonus = floor($total_royalti/$total_member);
        } else {
            $nominal_bonus = 0;
        }
        
        $keterangan = $row->nama_peringkat;
        $cbro->create_rekap($last_date, $id_peringkat, $omset, $persentase, $total_royalti, $total_member, $nominal_bonus, $keterangan, $created_at);
        
        if($nominal_bonus > 0){
            $cbro->create_bonus($last_date, $id_peringkat, $nominal_bonus, $created_at);
        }
        
        // Menulis log ke buffer
        $log .= "ID Peringkat : ".$id_peringkat."\n";
        $log .= "Nama Peringkat : ".$row->nama_peringkat."\n";
        $log .= "Percent Royalti :".percent($persentase)."\n";
        $log .= "Total Royalti :".rp($total_royalti)."\n";
        $log .= "Total Member :".currency($total_member)."\n";
        $log .= "Nominal Bonus :".rp($nominal_bonus)."\n\n";
    }
    file_put_contents($log_file, $log, FILE_APPEND);