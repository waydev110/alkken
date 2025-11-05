<?php
require_once '../model/classCart.php';
$cc = new classCart();
$total_cart = $cc->total_cart($session_member_id);
?>
<div class="col-auto pe-0 text-end align-self-center">
    <a href="?go=cart" target="_self" class="btn btn-44 text-white" id="cartNotification">
        <?php
        if ($total_cart > 0) {
        ?>
            <span class="count-indicator size-11"><?= $total_cart ?></span>
        <?php
        }
        ?>
        <i class="fa-light fa-cart-shopping"></i>
    </a>
    <!-- <a href="" target="_self" class="btn btn-sm btn-44">
        <span class="count-indicator size-11 bg-danger text-white">1</span>
        <i class="fa-solid fa-bell"></i>
        </a> -->
</div>