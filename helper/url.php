<?php
    if(!function_exists('redirect')){
        function redirect($param){
            switch ($param) {
                case '404':
                    header('Location:'.base_url().'404.php');
                    break;
                case '500':
                    header('Location:'.base_url().'500.php');
                    break;
                default:
                    header('Location:'.site_url($param));                    
                    break;
            }
        }
    }

    if(!function_exists('admin_url')){
        function admin_url($url){
            return base_url().'adminarea/index.php?go='.$url;
        }
    }

    if(!function_exists('base_url')){
        function base_url(){
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $explode1 = explode("controller",$actual_link);
            $explode2 = explode("index.php",$explode1[0]);
            return $explode2[0];
        }
    }

    if(!function_exists('site_url')){
        function site_url($url){
            return base_url().'index.php?go='.$url;
        }
    }