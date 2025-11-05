

<?php
require_once '../model/classCartReward.php';
$cc = new classCartReward();
$total_cart = $cc->total_cart($session_member_id);
?>
<div class="col-auto">
    <a href="?go=cart_reward" target="_self" class="btn btn-light btn-44" id="cartNotification">
        <span class="count-indicator size-11 bg-white"><?=$total_cart?></span>
        <i class="fa-solid fa-cart-shopping"></i>
    </a>
</div>