<?php
    if(!function_exists('save_image')){
        function save_image($files, $dir, $slug = '') {
            if($slug == ''){
                $slug = uniqid();
            }

            $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
            $nama_file = $files['name'];
            $x = explode('.', $nama_file);
            $ekstensi = strtolower(end($x));
            $file_tmp = $files['tmp_name'];
            $new_filename = $slug.'.'.$ekstensi;
            $targetDir = '../../../images/'.$dir.'/';
            $path = $targetDir.$new_filename;
            
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                move_uploaded_file($file_tmp, $path);
                $gambar = $new_filename;
                return $gambar;
            }else{
                return false;   
            }
        }
    }