<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>

<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
    <?php
    if($_SESSION['level_login'] == '5' || $_SESSION['level_login'] == '4' || $_SESSION['level_login'] == '3' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
    <?php
    if($_SESSION['level_login'] == '4' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
        <li class="hidden-xs"><a href="?go=member_list">Daftar <?=$lang['member']?></a></li>
        <li class="hidden-xs"><a href="?go=stokis_member">Daftar <?=$lang['stokis']?></a></li>
    <?php 
    }
    ?>  
    <?php
    if($_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1'){
    ?>
        <li class="hidden-xs"><a href="?go=stokis_deposit">Deposit <?=$lang['stokis']?></a></li>
        <!-- <li class="hidden-xs"><a href="?go=transfer_penarikan">Penarikan</a></li> -->
        <!-- <li class="hidden-xs"><a href="?go=member_order"><?=$lang['member']?> Order</a></li> -->
    <?php 
    }
    ?>  
    <?php
    if($_SESSION['level_login'] == '3' || $_SESSION['level_login'] == '1'){
    ?>
        <!-- <li class="dropdown hidden-xs"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Transfer Bonus</a>
            <ul class="dropdown-menu">
                <li class=""><a href="?go=bonus_sponsor_transfer">Bonus Referral</a></li>
                <li class=""><a href="?go=bonus_generasi_transfer">Bonus Generasi</a></li>
                <li class=""><a href="?go=bonus_cashback_transfer">Bonus Cashback</a></li>
                <li class=""><a href="?go=bonus_reward_transfer">Bonus Reward</a></li>
                <li class=""><a href="?go=bonus_founder_transfer">Bonus Founder</a></li>
            </ul>
        </li> -->
    <?php 
    }
    ?>  
    <?php 
    }
    ?>  
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../assets/dist/img/avatar5.png" class="user-image" alt="User Image">
                <span class="hidden-xs"><?=$_SESSION['nama_login'];?></span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="../assets/dist/img/avatar5.png" class="img-circle" alt="User Image">
                    <p>
                        <?=$_SESSION['nama_login'];?>
                        <small><?=date('Y-m-d H:i:s',time());?></small>
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <a href="#"><i class="fa fa-cogs"></i> <span>Configure</span></a>
                        </div>
                        <div class="col-xs-4 text-center">

                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#"><i class="fa fa-cubes"></i> <span>Modules</span></a>
                        </div>
                    </div>
                </li>

                <li class="user-footer">
                    <div class="pull-left">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="view/logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
    </ul>
</div>