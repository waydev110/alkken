<?php
    if(!function_exists('greetings')){
        function greetings($hours)
        {
            if ($hours >= 0 && $hours <= 12) {
                // return "Good Morning";
                return "Selamat Pagi";
            } else {
                if ($hours > 12 && $hours <= 17) {
                    // return "Good Afternoon";
                    return "Selamat Sore";
                } else {                    
                    if ($hours > 17 && $hours <= 20) {
                        // return "Good Evening";
                        return "Selamat Petang";
                    } else {
                        // return "Good Night";
                        return "Selamat Malam";
                    }
                }
            }
        }
    }

    if(!function_exists('code_bonus')){
        function code_bonus($string)
        {
            $string = '#B'.str_pad($string,11,"18052023",STR_PAD_LEFT);
            return $string;
        }
    }
    if(!function_exists('code_transfer')){
        function code_transfer($string)
        {
            $string = strtotime($string);
            $string = '#T'.str_pad($string,11,"18052023",STR_PAD_LEFT);
            return $string;
        }
    }
    if(!function_exists('code_topup')){
        function code_topup($string)
        {
            $string = strtotime($string);
            $string = '#U'.str_pad($string,11,"18052023",STR_PAD_LEFT);
            return $string;
        }
    }
    if(!function_exists('code_order')){
        function code_order($string, $tgl)
        {
            $tgl = date('Ymd', strtotime($tgl));
            $string = '#D'.$tgl.str_pad($string,4,'0000',STR_PAD_LEFT);
            return $string;
        }
    }

    if(!function_exists('get_name')){
        function get_name($string)
        {
            $i = strpos($string, ' ');
            if($i !== false){
                $name = substr( $string, 0, $i );
            } else {
                $name = $string;
            }
            if(strlen($name) > 10){
                $name = substr( $string, 0, 9 );
            }
            return ucwords(strtolower( $name ) );
        }
    }

    if(!function_exists('get_full_name')){
        function get_full_name($string)
        {
            return ucwords(strtolower( $string ) );
        }
    }

    if(!function_exists('icon_paket')){
        function icon_paket($string)
        {
            if(substr($string, 0, 1) == 'R'){
                $string = substr($string, 1);
            }
            return strtolower( $string ).'.png';
        }
    }

    if(!function_exists('paket_sebenarnya')){
        function paket_sebenarnya($string)
        {
            if(substr($string, 0, 1) == 'R'){
                $string = substr($string, 1);
            }
            return $string;
        }
    }

    if(!function_exists('get_kota')){
        function get_kota($string)
        {
            return str_replace("Administrasi ", "", str_replace("Kabupaten ", "", str_replace("Kota ", "", ucwords(strtolower($string) ) ) ) );
        }
    }

    if(!function_exists('currency')){
        function currency($number)
        {
            if($number > 0){
                $number = number_format($number,0,'.',',');
            } else {
                $number = '0';
            }
            return $number;
        }
    }

    if(!function_exists('currency_minus')){
        function currency_minus($number)
        {
            $number = number_format($number,0,'.',',');
            return $number;
        }
    }

    if(!function_exists('currencyID')){
        function currencyID($number)
        {
            if($number > 0){
                $number = number_format($number,0,',','.');
            } else {
                $number = '0';
            }
            return $number;
        }
    }

    if(!function_exists('decimal')){
        function decimal($number)
        {
            if($number > 0){
                $number = number_format($number,2,',','.');
            } else {
                $number = '0';
            }
            return $number;
        }
    }
    if(!function_exists('tnt')){
        function tnt($number)
        {
            if($number > 0){
                $number = number_format($number,8,',','.');
            } else {
                $number = '0';
            }
            return $number;
        }
    }

    if(!function_exists('rp')){
        function rp($number)
        {
            if($number > 0){
                $number = 'Rp'.number_format($number,0,',','.').',-';
            } else {
                $number = 'Rp0,-';
            }
            return $number;
        }
    }

    if(!function_exists('progress')){
        function progress($current, $maks){
            if($current > 0 && $maks > 0){
                $progress = floor($current / $maks * 100);
            } else {
                $progress = 0;
            }
            return $progress;
        }
    }

    if(!function_exists('capital_word')){
        function capital_word($string){
            if($string <> ''){
                $string = ucwords(strtolower( $string ));
            }
            return $string;
        }
    }

    if(!function_exists('number')){
        function number($string){      
            $number = preg_replace('/[^0-9.,]/', '', $string);

            if (strpos($number, '.') !== false) {
                $number = str_replace('.', '', $number); // Hapus semua titik
            }
            // Jika ada koma, ubah menjadi titik (untuk format desimal yang valid di MySQL)
            if (strpos($number, ',') !== false) {
                $number = str_replace(',', '.', $number);
            }
            
            return $number;   
        }    
    }
    if(!function_exists('generateID')){
        function generateID($len, $posfix, $prefix=''){
    		$charset = "0123456789";

    		$result = '';
    		$charArray = str_split($charset);
    		for($i = 0; $i < $len; $i++){
    		  $randItem = array_rand($charArray);
    		  $result .= "".$charArray[$randItem];
    		}
            $posfix = str_pad($posfix,4,'0000',STR_PAD_LEFT);
    		$newID = $prefix.$result.$posfix;
            return $newID;
    	}
    }

    if(!function_exists('generatePassword')){        
        function generatePassword() {        
            $alphabet = "123456789";        
            $password = array();        
            $alphaLength = strlen($alphabet) - 1;        
            for ($i = 0; $i < 6; $i++) {        
                $n = rand(0, $alphaLength);        
                $password[] = $alphabet[$n];        
            } 
            $password =  implode($password);
            return base64_encode($password);   
        } 
    }

    if(!function_exists('generatePIN')){        
        function generatePIN() {        
            $alphabet = "123456789";        
            $pin = array();        
            $alphaLength = strlen($alphabet) - 1;        
            for ($i = 0; $i < 4; $i++) {        
                $n = rand(0, $alphaLength);        
                $pin[] = $alphabet[$n];        
            } 
            $pin =  implode($pin);
            return base64_encode($pin);   
        } 
    }
    
    if(!function_exists('generateInvoice')){        
        function generateInvoice() {        
            $alphabet = "123456789";        
            $pin = array();        
            $alphaLength = strlen($alphabet) - 1;        
            for ($i = 0; $i < 8; $i++) {        
                $n = rand(0, $alphaLength);        
                $pin[] = $alphabet[$n];        
            } 
            $invoice = '#INV'.implode($pin); 
            return $invoice;     
        } 
    }

    if(!function_exists('percent')){
        function percent($number){
            $percent 	= round($number)."%";
        
            return $percent;
        }
    }


    if(!function_exists('type')){
        function type($string){
            switch ($string) {
                case 'bonus_sponsor':
                    $string = 'Bonus Sponsor';
                    break;
                case 'bonus_pasangan':
                    $string = 'Bonus Pasangan';
                    break;
                case 'bonus_pasangan_level':
                    $string = 'Bonus Matching';
                    break;
                case 'bonus_cashback':
                    $string = 'Bonus Cashback';
                    break;
                case 'bonus_reward':
                    $string = 'Bonus Reward';
                    break;
                case 'bonus_insentif':
                    $string = 'Bonus Insentif';
                    break;
                case 'bonus_generasi':
                    $string = 'Bonus Generasi';
                    break;
                case 'bonus_generasi_sponsor':
                    $string = 'Bonus Generasi Sponsor';
                    break;
                case 'bonus_generasi_upline':
                    $string = 'Bonus Generasi Upline';
                    break;
                case 'bonus_bagi_hasil':
                    $string = 'Bonus Bagi Hasil';
                    break;
                case 'bonus_balik_modal':
                    $string = 'Bonus Balik Modal';
                    break;
                case 'bonus_unilevel':
                    $string = 'Bonus Unilevel';
                    break;
                case 'penarikan':
                    $string = 'Ditransfer';
                    break;
                case 'penukaran':
                    $string = 'Penukaran ';
                    break;
                    
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }
    

    if(!function_exists('icon_type')){
        function icon_type($string){
            switch ($string) {
                case 'bonus_pasif_join':
                    $string = '<i class="fa-solid fa-badge-dollar"></i>';
                    break;

                case 'bonus_pasangan':
                    $string = '<i class="fa-solid fa-money-bill-transfer"></i>';
                    break;

                case 'bonus_automaintain':
                    $string = '<i class="fa-solid fa-cart-shopping-fast"></i>';
                    break;
                    
                case 'cash':
                    $string = '<i class="fa-solid fa-money-bill-trend-up"></i>';
                    break;
                    
                case 'bonus_generasi':
                    $string = '<i class="fa-solid fa-money-bill-trend-up"></i>';
                    break;
                    
                case 'bonus_generasi_sponsor':
                    $string = '<i class="fa-solid fa-money-bill-trend-up"></i>';
                    break;
                    
                case 'bonus_generasi_upline':
                    $string = '<i class="fa-solid fa-money-bill-trend-up"></i>';
                    break;

                case 'bonus_bagi_hasil':
                    $string = '<i class="fa-solid fa-money-bill-wave"></i>';
                    break;

                case 'bonus_balik_modal':
                    $string = '<i class="fa-solid fa-money-bill-wave"></i>';
                    break;

                case 'bonus_balik_modal_ro':
                    $string = '<i class="fa-solid fa-money-bill-wave"></i>';
                    break;

                case 'bonus_sponsor':
                    $string = '<i class="fa-solid fa-money-bill-wave"></i>';
                    break;

                case 'bonus_reward':
                    $string = '<i class="fa-solid fa-medal"></i>';
                    break;

                case 'bonus_reward_ro':
                    $string = '<i class="fa-solid fa-medal"></i>';
                    break;

                case 'bonus_unilevel':
                    $string = '<i class="fa-solid fa-money-bill-trend-up"></i>';
                    break;

                case 'penarikan':
                    $string = '<i class="fa-solid fa-money-simple-from-bracket"></i>';
                    break;

                case 'penukaran':
                    $string = '<i class="fa-solid fa-gift"></i>';
                    break;

                default :
                    $string = '<i class="fa-solid fa-money-bill-transfer"></i>';
                break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('color_type')){
        function color_type($string){
            switch ($string) {
                case 'bonus_sponsor':
                    $string = 'success';
                    break;
                case 'bonus_sponsor_ro':
                    $string = 'primary';
                    break;
                case 'bonus_generasi':
                    $string = 'teal';
                    break;
                case 'bonus_bagi_hasil':
                    $string = 'teal';
                    break;
                case 'bonus_peringkat_omset':
                    $string = 'teal';
                    break;
                case 'bonus_balik_modal':
                    $string = 'teal';
                    break;                
                case 'bonus_unilevel':
                    $string = 'teal';
                    break;
                case 'bonus_pasangan':
                    $string = 'danger';
                    break;
                case 'bonus_automaintain':
                    $string = 'danger';
                    break;
                case 'bonus_reward':
                    $string = 'danger';
                    break;
                case 'bonus_reward_ro':
                    $string = 'danger';
                    break;
                case 'penarikan':
                    $string = 'primary';
                    break;
                case 'penukaran':
                    $string = 'theme';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('jenis_saldo')){
        function jenis_saldo($string){
            switch ($string) {
                case 'cash':
                    $string = 'Saldo Cash';
                    break;
                case 'ppob':
                    $string = 'Saldo Market';
                    break;
                case 'cash':
                    $string = 'Saldo Bonus';
                    break;
                case 'admin':
                    $string = 'Admin Bonus';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('status_aktif')){
        function status_aktif($string){
            switch ($string) {
                case '0':
                    $string = 'Tidak Aktif';
                    break;
                case '1':
                    $string = 'Aktif';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('status')){
        function status($string){
            switch ($string) {
                case '1':
                    $string = 'Aktif';
                    break;
                case '2':
                    $string = 'Diblokir';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('level_admin')){
        function level_admin($string){
            switch ($string) {
                case '1':
                    $string = 'Super Admin';
                    break;
                case '2':
                    $string = 'Administrator';
                    break;
                case '3':
                    $string = 'Admin Bonus';
                    break;
                case '4':
                    $string = 'Admin User';
                    break;
                case '5':
                    $string = 'Admin Undian';
                    break;
                case '6':
                    $string = 'Admin Elemen';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('status_transfer')){
        function status_transfer($string){
            switch ($string) {
                case '-1':
                    $string = 'Waiting';
                    break;
                case '0':
                    $string = 'Pending';
                    break;
                case '1':
                    $string = 'Ditransfer';
                    break;
                case '2':
                    $string = 'Hidden';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('status_proses')){
        function status_proses($string){
            switch ($string) {
                case '0':
                    $string = 'Pending';
                    break;
                case '1':
                    $string = 'Diproses';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }
    
    if(!function_exists('status_saldo')){
        function status_saldo($status_saldo){
            switch ($status_saldo) {
                case 'd':
                    $icon = 'fa-arrow-down';
                    $class_name = 'success';
                    $keterangan = 'Masuk';
                    break;
                case 'k':
                    $icon = 'fa-arrow-up';
                    $class_name = 'primary';
                    $keterangan = 'Keluar';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = '';
                    break;
            }
            
            return '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
        }
    }
    if(!function_exists('status_aktivasi')){
        function status_aktivasi($string){
            switch ($string) {
                case '0':
                    $string = '<span class="label label-default rounded-pill">Belum Aktif</span>';
                    break;
                case '1':
                    $string = '<span class="label label-success rounded-pill">Sudah Aktif</span>';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('bg_jenis_produk')){
        function bg_jenis_produk($string){
            switch ($string) {
                case '0':
                    $string = 'success';
                    break;
                case '1':
                    $string = 'danger';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('juta')){
        function juta($number){
            if($number > 0){
                if (strlen($number) <= 6 ){
                    $number = $number/1000;
                    $number = number_format($number, 0, '.', ',').'rb';
                } else if (strlen($number) <= 9 ){
                    $number = $number/1000000;
                    $number = number_format($number, 0, '.', ',').'jt';
                } else if (strlen($number) <= 12 ){
                    $number = $number/1000000000;
                    $number = number_format($number, 0, '.', ',').'m';
                } else {
                    $number = number_format($number, 0, '.', ',');
                }
            }
            return $number;
        }
    }
    if(!function_exists('slug')){
        function slug($string){
            $slug = trim($string); // trim the string
            $slug= preg_replace('/[^a-zA-Z0-9 -]/','',$slug ); // only take alphanumerical characters, but keep the spaces and dashes too...
            $slug= str_replace(' ','-', $slug); // replace spaces by dashes
            $slug= strtolower($slug);  // make it lowercase
            return $slug;
        }
    }
    if(!function_exists('greetings')){
        function greetings($hours)
        {
            if ($hours >= 0 && $hours <= 12) {
                // return "Good Morning";
                return "Selamat Pagi";
            } else {
                if ($hours > 12 && $hours <= 17) {
                    // return "Good Afternoon";
                    return "Selamat Sore";
                } else {                    
                    if ($hours > 17 && $hours <= 20) {
                        // return "Good Evening";
                        return "Selamat Petang";
                    } else {
                        // return "Good Night";
                        return "Selamat Malam";
                    }
                }
            }
        }
    }

    if(!function_exists('code_bonus')){
        function code_bonus($string)
        {
            // $string = '#B'.str_pad($string,11,"00000",STR_PAD_LEFT);
            $string = '#B'.str_pad($string,11,"00000",STR_PAD_LEFT);
            return $string;
        }
    }
    if(!function_exists('code_transfer')){
        function code_transfer($string)
        {
            $string = strtotime($string);
            $string = '#T'.str_pad($string,11,"18052023",STR_PAD_LEFT);
            return $string;
        }
    }
    if(!function_exists('code_topup')){
        function code_topup($string)
        {
            $string = strtotime($string);
            $string = '#U'.str_pad($string,11,"18052023",STR_PAD_LEFT);
            return $string;
        }
    }
    if(!function_exists('code_order')){
        function code_order($string)
        {
            $string = strtotime($string);
            $string = '#O'.str_pad($string,11,"18052023",STR_PAD_LEFT);
            return $string;
        }
    }

    if(!function_exists('get_name')){
        function get_name($string)
        {
            $i = strpos($string, ' ');
            if($i !== false){
                $name = substr( $string, 0, $i );
            } else {
                $name = $string;
            }
            if(strlen($name) > 10){
                $name = substr( $string, 0, 9 );
            }
            return ucwords(strtolower( $name ) );
        }
    }
    

    if(!function_exists('icon_type')){
        function icon_type($string){
            switch ($string) {
                case 'bonus_sponsor':
                    $string = 'Bonus Sponsor';
                    $string = '<i class="fa-solid fa-chalkboard-teacher"></i>';
                    break;
                case 'bonus_pasangan':
                    $string = 'Bonus Pasangan';
                    $string = '<i class="fa-solid fas fa-people-arrows"></i>';
                    break;
                case 'bonus_automaintain':
                    $string = 'Potongan Automaintain';
                    $string = '<i class="fa-solid fa-cart-shopping-fast"></i>';
                    break;
                case 'bonus_reward':
                    $string = 'Bonus Reward';
                    $string = '<i class="fa-solid fa-award"></i>';
                    break;
                case 'bonus_reward_ro':
                    $string = 'Bonus Reward RO';
                    $string = '<i class="fa-solid fa-award-simple"></i>';
                    break;
                case 'bonus_reward_promo':
                    $string = 'Bonus Reward Promo';
                    $string = '<i class="fa-solid fa-briefcase"></i>';
                    break;
                case 'bonus_reward_fast':
                    $string = 'Bonus Fast Reward';
                    $string = '<i class="fa-solid fa-jet-fighter"></i>';
                    break;
                case 'bonus_unilevel':
                    $string = 'Bonus Unilevel';
                    $string = '<i class="fa-solid fa-badge-dollar"></i>';
                    break;
                case 'bonus_unilevel_ro':
                    $string = '<i class="fa-solid fa-badge-dollar"></i>';
                    break;

                case 'penarikan':
                    $string = '<i class="fa-solid fa-money-simple-from-bracket"></i>';
                    break;

                case 'penukaran':
                    $string = '<i class="fa-solid fa-gift"></i>';
                    break;

                default :
                    $string = '<i class="fa-solid fa-money-bill-transfer"></i>';
                break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }
    
    if(!function_exists('color_type')){
        function color_type($string){
            switch ($string) {
                case 'bonus_sponsor':
                    $string = 'success';
                    break;
                case 'bonus_sponsor_ro':
                    $string = 'primary';
                    break;
                case 'bonus_generasi':
                    $string = 'teal';
                    break;
                case 'bonus_bagi_hasil':
                    $string = 'teal';
                    break;
                case 'bonus_peringkat_omset':
                    $string = 'teal';
                    break;
                case 'bonus_balik_modal':
                    $string = 'teal';
                    break;                
                case 'bonus_unilevel':
                    $string = 'teal';
                    break;
                case 'bonus_pasangan':
                    $string = 'danger';
                    break;
                case 'bonus_automaintain':
                    $string = 'danger';
                    break;
                case 'bonus_reward':
                    $string = 'danger';
                    break;
                case 'bonus_reward_ro':
                    $string = 'danger';
                    break;
                case 'bonus_reward_promo':
                    $string = 'danger';
                    break;
                case 'penarikan':
                    $string = 'primary';
                    break;
                case 'penukaran':
                    $string = 'theme';
                    break;
                default:
                    $string = 'theme';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('get_full_name')){
        function get_full_name($string)
        {
            if(!empty($string)){
                return ucwords(strtolower( $string ) );
            }
            return $string;
        }
    }

    if(!function_exists('icon_peringkat')){
        function icon_peringkat($string)
        {
            if(substr($string, 0, 1) == 'R'){
                $string = substr($string, 1);
            }
            return strtolower( $string ).'.png';
        }
    }

    if(!function_exists('peringkat_sebenarnya')){
        function peringkat_sebenarnya($string)
        {
            if(substr($string, 0, 1) == 'R'){
                $string = substr($string, 1);
            }
            return $string;
        }
    }

    if(!function_exists('get_kota')){
        function get_kota($string)
        {
            if(!empty($string)){
                return str_replace("Administrasi ", "", str_replace("Kabupaten ", "", str_replace("Kota ", "", ucwords(strtolower($string) ) ) ) );
            }
            return $string;
        }
    }

    if(!function_exists('currency')){
        function currency($number)
        {
            if($number > 0){
                $number = number_format($number,0,',','.');
            } else {
                $number = '0';
            }
            return $number;
        }
    }

    if(!function_exists('poin')){
        function poin($number)
        {
            $number = number_format($number,2,',','.');
            return $number.' poin';
        }
    }

    if(!function_exists('decimal')){
        function decimal($number)
        {
            if($number > 0){
                $number = number_format($number,2,',','.');
            } else {
                $number = '0';
            }
            return $number;
        }
    }

    if(!function_exists('decimal4')){
        function decimal4($number)
        {
            if($number > 0){
                $number = number_format($number,4,',','.');
            } else {
                $number = '0';
            }
            return $number;
        }
    }

    if(!function_exists('rp')){
        function rp($number)
        {
            if($number > 0){
                $number = 'Rp'.number_format($number,0,',','.').',-';
            } else {
                $number = 'Rp0,-';
            }
            return $number;
        }
    }

    if(!function_exists('rps')){
        function rps($number)
        {
            if($number > 0){
                $number = '<small class="mt-2"><sup>Rp</sup></small> '.number_format($number,0,',','.').',-';
            } else {
                $number = '<small class="mt-2"><sup>Rp</sup></small> 0,-';
            }
            return $number;
        }
    }

    if(!function_exists('progress')){
        function progress($current, $maks){
            if($current > 0 && $maks > 0){
                $progress = floor($current / $maks * 100);
            } else {
                $progress = 0;
            }
            return $progress;
        }
    }

    if(!function_exists('capital_word')){
        function capital_word($string){
            if($string <> ''){
                $string = ucwords(strtolower( $string ));
            }
            return $string;
        }
    }

    if(!function_exists('number')){
        function number($string){    
            return preg_replace( '/[^0-9]/', '', $string );    
        }    
    }
    
    if(!function_exists('generatePassword')){
        function generatePassword() {        
            $alphabet = "123456789";        
            $pass = array();        
            $alphaLength = strlen($alphabet) - 1;         
            for ($i = 0; $i < 6; $i++) {        
                $n = rand(0, $alphaLength);        
                $pass[] = $alphabet[$n];        
            }
            return implode($pass);         
        } 
    }

    if(!function_exists('generatePIN')){        
        function generatePIN() {        
            $alphabet = "123456789";        
            $pin = array();        
            $alphaLength = strlen($alphabet) - 1;        
            for ($i = 0; $i < 4; $i++) {        
                $n = rand(0, $alphaLength);        
                $pin[] = $alphabet[$n];        
            } 
            return implode($pin);      
        } 
    }
    
    if(!function_exists('generateInvoice')){        
        function generateInvoice() {        
            $alphabet = "123456789";        
            $pin = array();        
            $alphaLength = strlen($alphabet) - 1;        
            for ($i = 0; $i < 8; $i++) {        
                $n = rand(0, $alphaLength);        
                $pin[] = $alphabet[$n];        
            } 
            $invoice = '#INV'.implode($pin); 
            return $invoice;     
        } 
    }

    if(!function_exists('percent')){
        function percent($number){
            $percent 	= round($number)."%";
        
            return $percent;
        }
    }
    if(!function_exists('percent_bonus')){
        function percent_bonus($number){
            $percent 	= round($number)."%";
            if($number == 100){
                $percent = '';
            }
            return $percent;
        }
    }

    if(!function_exists('jenis_saldo')){
        function jenis_saldo($string){
            switch ($string) {
                case 'cash':
                    $string = 'Saldo Cash';
                    break;
                case 'ppob':
                    $string = 'Saldo Market';
                    break;
                case 'cash':
                    $string = 'Saldo Bonus';
                    break;
                case 'admin':
                    $string = 'Admin Bonus';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('juta')){
        function juta($number){
            if($number > 0){
                if (strlen($number) <= 6 ){
                    $number = $number/1000;
                    $number = number_format($number, 0, '.', ',').'rb';
                } else if (strlen($number) <= 9 ){
                    $number = $number/1000000;
                    $number = number_format($number, 0, '.', ',').'jt';
                } else if (strlen($number) <= 12 ){
                    $number = $number/1000000000;
                    $number = number_format($number, 0, '.', ',').'m';
                } else {
                    $number = number_format($number, 0, '.', ',');
                }
            }
            return $number;
        }
    }
    if(!function_exists('slug')){
        function slug($string){
            $slug = trim($string); // trim the string
            $slug= preg_replace('/[^a-zA-Z0-9 -]/','',$slug ); // only take alphanumerical characters, but keep the spaces and dashes too...
            $slug= str_replace(' ','-', $slug); // replace spaces by dashes
            $slug= strtolower($slug);  // make it lowercase
            return $slug;
        }
    }


    if(!function_exists('jenis_aktivasi')){
        function jenis_aktivasi($string){
            switch ($string) {
                case '0':
                    $string = 'Pendaftaran';
                    break;
                case '1':
                    $string = 'RO';
                    break;
            }
            return $string;
        }
    }
    
    if(!function_exists('bg_jenis_produk')){
        function bg_jenis_produk($string){
            switch ($string) {
                case '0':
                    $string = 'success';
                    break;
                case '1':
                    $string = 'danger';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }
    if(!function_exists('currencyID')){
        function currencyID($number)
        {
            if($number > 0){
                $number = number_format($number,0,',','.');
            } else {
                $number = '0';
            }
            return $number;
        }
    }
    
    if(!function_exists('status_bonus')){
        function status_bonus($status_transfer){
            switch ($status_transfer) {
                case '-1':
                    $icon = 'fa-stopwatch';
                    $class_name = 'secondary';
                    $keterangan = 'Waiting';
                    break;
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Pending';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Ditransfer';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Tidak Qualified';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = '';
                    break;
            }
            
            return '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
        }
    }

    if(!function_exists('status_klaim')){
        function status_klaim($status){
            switch ($status) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Pending';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Diklaim';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Expired';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = '';
                    break;
            }
            
            return '<p class="text-end mb-0 size-12 text-'.$class_name.' fw-bold">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
        }
    }
    
    if(!function_exists('status_poin')){
        function status_poin($status){
            switch ($status) {
                case 'd':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Masuk';
                    break;
                case 'k':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Keluar';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            return '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold" style="position:absolute;right:15px;bottom:15px;">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
        }
    }

    if(!function_exists('formatPesanEmail')){
        function formatPesanEmail($inputString) {
            $inputString = replaceNewLine($inputString);
            $inputString = replaceBintang($inputString);
            $inputString = replaceUnderscore($inputString);
            return $inputString;
        }
    }

    if(!function_exists('replaceNewLine')){
        function replaceNewLine($inputString) {
            $inputString = str_replace("\n", "<br/>", $inputString);
            return $inputString;
        }
    }

    if(!function_exists('replaceBintang')){
        function replaceBintang($inputString) {
            // Temukan semua teks yang diapit oleh karakter "*" di dalam string
            preg_match_all("/\*(.*?)\*/", $inputString, $matches);
        
            // Lakukan penggantian untuk setiap teks yang ditemukan
            foreach ($matches[0] as $match) {
                $replacement = "<strong>" . trim($match, "*") . "</strong>";
                $inputString = str_replace($match, $replacement, $inputString);
            }
        
            return $inputString;
        }
    }

    if(!function_exists('replaceUnderscore')){
        function replaceUnderscore($inputString) {
            // Temukan semua teks yang diapit oleh karakter "*" di dalam string
            preg_match_all("/\b_(.*?)_\b/", $inputString, $matches);
        
            // Lakukan penggantian untuk setiap teks yang ditemukan
            foreach ($matches[0] as $match) {
                $replacement = "<i>" . trim($match, "_") . "</i>";
                $inputString = str_replace($match, $replacement, $inputString);
            }
        
            return $inputString;
        }
    }
    
    if(!function_exists('validateEmail')){
        function validateEmail($email) {
            // Menggunakan filter_var untuk validasi sederhana
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }
    }

    if(!function_exists('status_order')){
        function status_order($status_order){
            switch ($status_order) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Pending';
                    break;
                case '1':
                    $icon = 'fa-box';
                    $class_name = 'success';
                    $keterangan = 'Diproses';
                    break;
                case '2':
                    $icon = 'fa-truck-fast';
                    $class_name = 'success';
                    $keterangan = 'Dikirim';
                    break;
                case '3':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Selesai';
                    break;
                case '4':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                case '5':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Dibatalkan';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            return '<p class="text-'.$class_name.' fw-bold" >
            <span class="text-'.$class_name.'"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
        }
    }

    if(!function_exists('status_sync')){
        function status_sync($string){
            switch ($string) {
                case '0':
                    $string = 'Belum';
                    break;
                case '1':
                    $string = 'Sudah';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('metode_pembayaran')){
        function metode_pembayaran($string){
            switch ($string) {
                case 'cash':
                    $string = 'Cash';
                    break;
                case 'poin':
                    $string = 'Poin';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }

    if(!function_exists('status_tampil')){
        function status_tampil($string){
            switch ($string) {
                case '1':
                    $string = 'Ya';
                    break;
                case '0':
                    $string = 'Tidak';
                    break;
            }
            // $string = ucwords(implode(' ', explode('_',$string)));
            return $string;
        }
    }
?>