<?php
    $_binary = true; // true or false
    $_setting_admin = 'nominal';
    $_admin = 10000; // admin transfer 10%
    $_limit_transfer = 2000000;
    $_sponsor_static = false; // true or false
    $_maintenance = false;
    $_harga_spin = 30000000; // Harga Spin Reward

    if(!function_exists('saldo_bonus')){
        function saldo_bonus($member_id)
        {
            $sql  = "SELECT 
            
                        COALESCE(SUM(CASE 
                            WHEN sp.status = 'd'
                            THEN sp.nominal
                            ELSE 0 
                        END) - SUM(CASE 
                            WHEN sp.status = 'k'
                            THEN sp.nominal
                            ELSE 0 
                        END),0) AS total                
                    FROM mlm_saldo_penarikan sp
                    WHERE sp.id_member = '$member_id' 
                    AND sp.jenis_saldo = 'saldo_wd' 
                    AND sp.deleted_at is null
                    ";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total;
        }
    }

    $localPath = 'alkken';

    function storeImage($file, $slug, $dir, $rootDir = '../../../images/') {
        $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
        $nama_file = $file['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        // $ukuran	= $file['size'];
        $file_tmp = $file['tmp_name'];
        $new_filename = $slug.'.'.$ekstensi;
        $targetDir = $rootDir.$dir.'/';
        $path = $targetDir.$new_filename;
        
        if (file_exists($path)) {
            unlink($path);
        }
        // Pastikan folder upload ada atau buat jika tidak ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if(move_uploaded_file($file_tmp, $path)){
                $gambar = $new_filename;
                return $gambar;
            } else {
                return 'Terjadi kesalahan. Gambar gagal disimpan.';           
            }
        }else{
            return 'Terjadi kesalahan. Ekstensi file tidak valid.';
        }
    }


    function storeFile($file, $slug, $dir, $rootDir = '../../../file/')
    {
        $allowedExtensions = ['vcf'];
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = $slug . '.' . $fileExt;
        $targetDir = $rootDir.$dir.'/';
        $filePath = $targetDir . $newFileName;

        if (!in_array($fileExt, $allowedExtensions)) {
            return null;
        }

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if (move_uploaded_file($fileTmp, $filePath)) {
            return $newFileName;
        }

        return null;
    }

    function encrypt($data) {
        $key = hash('sha256', 'lakuindonesia', true);
        $iv = substr($key, 0, 16);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
        return base64_encode($encrypted);
    }

    function decrypt($data) {
        $key = hash('sha256', 'lakuindonesia', true);
        $iv = substr($key, 0, 16);
        $data = base64_decode($data);
        return openssl_decrypt($data, 'AES-256-CBC', $key, 0, $iv);
    }

    function formatWA($hp_member) {
        $regexWA = '/^(?:\+62|62|08)[0-9]{9,13}$/';
        // $regexWA = '/^(?:\+62)[0-9]{9,13}$/';

        if (!preg_match($regexWA, $hp_member)) {
            return false;
        }
        return true;
    }

    function filterWA($hp_member) {
        $hp_member = preg_replace('/\D+/', '', $hp_member); // Hanya biarkan angka
        if (strpos($hp_member, '62') === 0) {
            $hp_member = '+' . $hp_member; // Format +62xxxx jika dimulai dengan 62
        } elseif (strpos($hp_member, '0') === 0) {
            $hp_member = '+62' . substr($hp_member, 1); // Format +62 jika dimulai dengan 0
        } elseif (strpos($hp_member, '+62') !== 0) {
            $hp_member = '+62' . $hp_member; // Tambahkan +62 jika belum ada
        }
        return $hp_member;
    }

    function formatUsername($username) {
        $regexUsername = '/^[a-zA-Z0-9_]+$/';

        if (!preg_match($regexUsername, $username)) {
            return false;
        }
        return true;
    }

    function parseVCard($filename)
    {
        $contacts = [];
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $contact = [];
        foreach ($lines as $line) {
            if (strpos($line, "BEGIN:VCARD") !== false) {
                $contact = ['phones' => []]; // Array untuk menyimpan multiple nomor telepon
            } elseif (strpos($line, "FN:") === 0) {
                $contact['full_name'] = trim(substr($line, 3));
            } elseif (strpos($line, "TEL") === 0) {
                preg_match('/:(.+)$/', $line, $matches);
                if (isset($matches[1])) {
                    $contact['phones'][] = trim($matches[1]); // Tambahkan ke array nomor telepon
                }
            } elseif (strpos($line, "EMAIL:") === 0) {
                $contact['email'] = trim(substr($line, 6));
            } elseif (strpos($line, "END:VCARD") !== false) {
                if (!empty($contact)) {
                    $contacts[] = $contact;
                }
            }
        }
        return $contacts;
    }

    function writeLog($log_file, $message) {
        $log_message = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;
        file_put_contents($log_file, $log_message, FILE_APPEND);
    }

    function imgBase64($filepath) {
        if (file_exists($filepath)) {
            $type = pathinfo($filepath, PATHINFO_EXTENSION);
            $data = file_get_contents($filepath);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        }
        return '';
    }

    function generateKodeOrder($id_order, $date) {
        $date = date('Ymd', strtotime($date));
        $kode_order = "INV" . $date . str_pad($id_order, 4, "0", STR_PAD_LEFT);
        return $kode_order;
    }

    function idWD($id, $date) {
        $date = date('Ymd', strtotime($date));
        $kode = "TRX" . $date . str_pad($id, 4, "0", STR_PAD_LEFT);
        return $kode;
    }

    function idOrder($id, $date) {
        $date = date('Ymd', strtotime($date));
        $kode = "OR" . $date . str_pad($id, 4, "0", STR_PAD_LEFT);
        return $kode;
    }

    function extractIdFromOrderCode($orderCode) {
        // Ambil 4 digit terakhir sebagai ID
        return (int)substr($orderCode, -4);
    }


    function clean_input($str) {
        return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
    }
?>