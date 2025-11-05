<?php
if(isset($_GET['username']) || isset($_GET['password'])){
    require_once '../model/classLoginStokis.php';
    
    $obj = new classLoginStokis();
    
    $_username = base64_decode(addslashes(strip_tags($_GET['username'])));
    $_password = base64_decode(addslashes(strip_tags($_GET['password'])));
    $login = $obj->LoginSubmit($_username, $_password);
    if($login){
        ?>	
            <script language="javascript">
                document.location="../stokisarea/";
            </script>
        <?php	
    }else{
    }
}