<?php
    $node = array();
    $action = array();
    $upline = array();
    require_once 'part/function_titik_pohon_jaringan.php';

    $upline_root = null;
    $id_member = $_SESSION['session_member_id'];
    if(isset($_GET['id_member'])){
        $id = $_GET['id_member'];
        $cm = new classMember();
        $member = $cm->genealogy($id, $_SESSION['session_member_id']);
        if (!empty($member)) {
            $id_member = $member->id;
            if($member->id <> $_SESSION['session_member_id']){
                $upline_root = $member->upline;
            }
    
            if(!$cm->cek_upline($id_member, $_SESSION['session_member_id'])){
                $id_member = $_SESSION['session_member_id'];
            } 
        }
    }    
?>
<div class="table-responsive text-center">
    <?php
    echo $upline_root===null ? '' : '<a href="?go=genealogy&id_member='.$upline_root.'" class="to-upline"><i class="fa fa-angle-up"></i><h4>To Upline</h4></a>';
    ?>
    <ul class="tree mt-2">
        <li>
            <?php
    
                titik($id_member, $upline_root, true,1);
            ?>
            <ul>
                <li>
                    <?php
                        titik($node[1][1],$upline[1][1],$action[1][1],2);
                    ?>
                    <ul class="hidden-xs">
                        <li>
                            <?php
                                titik($node[2][1],$upline[2][1],$action[2][1],3);
                            ?>
                            <ul class="hidden-md hidden-sm">
                                <li>
                                    <?php
                                        titik($node[3][1],$upline[3][1],$action[3][1]);
                                    ?>
                                </li>
                                <li>
                                    <?php
                                        titik($node[3][2],$upline[3][2],$action[3][2]);
                                    ?>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php
                                titik($node[2][2],$upline[2][2],$action[2][2],3);
                            ?>
                            <ul class="hidden-md hidden-sm">
                                <li>
                                    <?php
                                        titik($node[3][1],$upline[3][1],$action[3][1]);
                                    ?>
                                </li>
                                <li>
                                    <?php
                                        titik($node[3][2],$upline[3][2],$action[3][2]);
                                    ?>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <?php
                        titik($node[1][2],$upline[1][2],$action[1][2],2);
                    ?>
                    <ul class="hidden-xs">
                        <li>
                            <?php
                                titik($node[2][1],$upline[2][1],$action[2][1],3);
                            ?>
                            <ul class="hidden-md hidden-sm">
                                <li>
                                    <?php
                                        titik($node[3][1],$upline[3][1],$action[3][1]);
                                    ?>
                                </li>
                                <li>
                                    <?php
                                        titik($node[3][2],$upline[3][2],$action[3][2]);
                                    ?>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php
                                titik($node[2][2],$upline[2][2],$action[2][2],3);
                            ?>
                            <ul class="hidden-md hidden-sm">
                                <li>
                                    <?php
                                        titik($node[3][1],$upline[3][1],$action[3][1]);
                                    ?>
                                </li>
                                <li>
                                    <?php
                                        titik($node[3][2],$upline[3][2],$action[3][2]);
                                    ?>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>