<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(!function_exists('create_token')){
        function create_token(){
            return $_SESSION['token'] = md5(session_id() . time());
        }
    }    

    if(!function_exists('cek_token')){
        function cek_token(){    
            if (isset($_SESSION['token']))
            {
                if (isset($_POST['token']))
                {
                    if ($_POST['token'] == $_SESSION['token'])
                    {
                        unset($_SESSION['token']);
                        return true;
                    }
                }
            }
            return false;
        }
    }    

    if(!function_exists('unset_token')){
        function unset_token(){
            if(isset($_SESSION['token'])){
                unset($_SESSION['token']);
            }
        }
    } 
    
    if(!function_exists('remove_session')){
        function remove_session($session){
            if(isset($_SESSION[$session])){
                unset($_SESSION[$session]);
            }
        }
    }    
