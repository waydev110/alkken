<?php

if(!function_exists('post_date')){
    function post_date($date){
        if($date <> ''){
            $date = str_replace('/', '-', $date);
            return date('Y-m-d', strtotime($date));
        }        
        return $date;
    }
}

if(!function_exists('bulan')){
    function bulan($bulan){
        if($bulan <> ''){
            $bulan = date("m", strtotime($bulan));
        
            switch ($bulan) {
                case '01':$bulan = "Januari";break;
                case '02':$bulan = "Februari";break;
                case '03':$bulan = "Maret";break;
                case '04':$bulan = "April";break;
                case '05':$bulan = "Mei";break;
                case '06':$bulan = "Juni";break;
                case '07':$bulan = "Juli";break;
                case '08':$bulan = "Agustus";break;
                case '09':$bulan = "September";break;
                case '10':$bulan = "Oktober";break;
                case '11':$bulan = "November";break;
                case '12':$bulan = "Desember";break;
                default:break;
            }
        }        
        return $bulan;
    }
}

if(!function_exists('tgl_indo_full')){
    function tgl_indo_full($date){
        if($date <> ''){
            $tgl = date("d", strtotime($date));
            $bulan = bulan($date);
            $thn = date("Y", strtotime($date));
            $jam = date("H:i", strtotime($date));
        
            $date = $tgl." ".$bulan." ".$thn.", <br>".$jam;
        }        
        return $date;
    }
}
if(!function_exists('tgl_indo_jam')){
    function tgl_indo_jam($date){
        if($date <> ''){
            $tgl = date("d", strtotime($date));
            $bulan = bulan($date);
            $thn = date("Y", strtotime($date));
            $jam = date("H:i", strtotime($date));
        
            $date = $tgl." ".$bulan." ".$thn." ".$jam;
        }        
        return $date;
    }
}

if(!function_exists('tgl_indo')){
    function tgl_indo($date){
        if($date <> ''){
            $tgl = date("d", strtotime($date));
            $bulan = bulan($date);
            $thn = date("Y", strtotime($date));        
            $date = $tgl." ".$bulan." ".$thn;
        }        
        return $date;
    }
}

if(!function_exists('tgl_bulan')){
    function tgl_bulan($date){
        if($date <> ''){
            $tgl = date("d", strtotime($date));
            $bulan = bulan($date);
        
            $date = $tgl." ".$bulan;
        }        
        return $date;
    }
}


if(!function_exists('hari')){
    function hari($l){
        switch ($l) {
            case 'Monday':$hari = "Senin";break;
            case 'Tuesday':$hari = "Selasa";break;
            case 'Wednesday':$hari = "Rabu";break;
            case 'Thursday':$hari = "Kamis";break;
            case 'Friday':$hari = "Jum'at";break;
            case 'Saturday':$hari = "Sabtu";break;
            case 'Sunday':$hari = "Minggu";break;
            default:
                return false;
            break;
        }
    
        return $hari;
    }
}

if(!function_exists('tgl_indo_hari')){
    function tgl_indo_hari($date){
        if($date <> ''){
            $l = hari(date("l", strtotime($date)));
            $d = date("d", strtotime($date));
            $m = bulan($date);
            $Y = date("Y", strtotime($date));
    
            $date = $l.', '. $d.' '.$m.' '.$Y;
        }        
        return $date;
    }
}

if(!function_exists('jam')){
    function jam($date){
        if($date <> ''){
            $date = date("H:i", strtotime($date));
        }        
        return $date;
    }
}

if(!function_exists('tgl_indo')){
    function tgl_indo($date){
        if($date <> ''){
            $tgl = date("d", strtotime($date));
            $bulan = bulan($date);
            $thn = date("Y", strtotime($date));        
            $date = $tgl." ".$bulan." ".$thn;
        }        
        return $date;
    }
}

if(!function_exists('bulan_tahun')){
    function bulan_tahun($date){
        if($date <> ''){
            $bulan = bulan($date);
            $thn = date("Y", strtotime($date));        
            $date = $bulan." ".$thn;
        }        
        return $date;
    }
}
    
if(!function_exists('tgl_bonus')){
    function tgl_bonus($tanggal, $jam=''){
        if($jam <> ''){
            $html = '<p class="text-end mt-2 mb-0 size-11 text-muted">'.$tanggal.',</p>
                    <p class="text-end mb-0 size-11 text-muted">'.$jam.'</p>';
        } else {
            $html = '<p class="text-end mt-2 mb-0 size-11 text-muted">'.$tanggal.'</p>';
        }
        return $html;
    }
}