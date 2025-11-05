

<?php
require_once '../model/classCart.php';
$cc = new classCart();
$total_cart = $cc->total_cart($session_member_id);
?>
<div class="col-auto">
    <a href="?go=cart" target="_self" class="btn btn-44" id="cartNotification">
        <?php
                    // if($total_cart > 0){
                ?>
        <span class="count-indicator size-11 bg-white"><?=$total_cart?></span>
        <?php        
                    // }
                ?>
                <i class="fa-solid fa-cart-shopping"></i>
    </a>
</div>