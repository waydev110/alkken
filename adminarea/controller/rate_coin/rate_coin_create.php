<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classWithdraw.php';
$obj = new classWithdraw();

$mod_url = 'transfer_penarikan_coin';
$rupiah = number($_POST['rupiah']);
$created_at = date('Y-m-d H:i:s',time());

$create = $obj->create_rate_coin($rupiah, $created_at);

if($create){
    ?>	
        <script language="javascript">
            document.location="../../?go=<?=$mod_url?>&msg=edit&stat=1";
        </script>
    <?php
    
}else{
    ?>	
        <script language="javascript">
            document.location="../../?go=<?=$mod_url?>&msg=edit&stat=0";
        </script>
    <?php
}
?>