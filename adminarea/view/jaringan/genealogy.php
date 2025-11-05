<?php
    require_once("../model/classSetBonusPeringkat.php");
    require_once("../model/classMember.php");
    require_once("../model/function.php");

    $csp = new classSetBonusPeringkat();
    $cm = new classMember();

    // $member = $cm->show(1);
    // $downline = $cm->getDownline(1);
?>
<link rel="stylesheet" href="../assets/vendor/listree/listree.min.css">
<style>
    h4,
    p {
        margin-top: 0;
        margin-bottom: 0;
    }

    ul.listree {
        margin-left: -40px;
    }

    ul.listree-submenu-items {
        height: auto;
    }
    .listree-submenu-heading {
        cursor: pointer;
    }

    .avatar {
        position: relative;
        display: inline-block;
        overflow: hidden;
        margin: 0;
        text-align: center;
        vertical-align: middle;
    }

    .avatar>i {
        display: inline-block;
        vertical-align: middle;
        margin-top: -3px;
    }

    .avatar>img {
        width: 100%;
        vertical-align: top;
    }

    .avatar.avatar-50 {
        line-height: 50px;
        height: 50px;
        width: 50px;
    }

    .mt-4 {
        margin-top: 10px;
    }

    .bg-primary {
        background-color: #149700;
    }

    .bg-warning {
        background-color: #e78c01;
    }
    .content-wrapper{
        overflow-x:auto!important;
    }
</style>
<div class="container p-2">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="get" accept-charset="utf-8">
        <!-- Search -->
        <div class="row">
            <div class="form-group">
                <div class="col-sm-12 mb-2">
                    <input type="hidden" name="go" value="genealogy">
                    <!-- <input type="text" class="form-control " id="id_member" name="id_member" placeholder="Cari Member"> -->
                    <label for="">Gunakan CTRL+F pada keyboard untuk melakukan pencarian!</label>
                </div>
                <div class="col-sm-12 mb-2">
                    <button class="btn btn-primary" type="button" onclick="actionToggle(this)"> <i class="fa fa-solid fa-minus mr-2"></i> Collapse All</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="genealogy" class="container pt-0" style="margin-top:20px;margin-left: -35px;">
                <?php
    $inc = 0;
    $downline = array();
    function downline($upline, $level, $no){
        $cm = new classMember();
        $csp = new classSetBonusPeringkat();
        $inc++;
        $downline[$level][$inc] = $cm->getDownline($upline);
        if($downline[$level][$inc]->num_rows > 0){
            ?>
            <ul class="listree-submenu-items" style="display: block">
            <?php
            $loop[$level][$inc] = 0;
            while($member = $downline[$level][$inc]->fetch_object()) {
                $loop[$level][$inc]++;
                ?>
                <li>
                    <div class="listree-submenu-heading expanded">
                        <!-- <div class="box bg-white" style="width:480px"> -->
                        <div class="box bg-white px-4" style="width:480px" onclick="getDownline('<?=base64_encode(1)?>', this)">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div style="display:flex; gap:20px; justify-content:space-around">
                                            <div style="display:flex; gap:10px;">
                                                <div style="display:flex; gap:10px; justify-content:center">
                                                    <div class="text-center px-4">
                                                        <p>Level</p>
                                                        <h4><?=$member->level?></h4>
                                                    </div> 
                                                    <!-- <div class="text-center px-4">
                                                        <p>No</p>
                                                        <h4><?=base64_decode($member->id)?></h2>
                                                    </div>                                                    -->
                                                </div>
                                                <div>
                                                    <div class="avatar avatar-50 shadow rounded-circle">
                                                        <img src="../assets/images/<?=$member->peringkat?>.png"
                                                            class="img-circle">
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="size-12">
                                                        <?=$csp->peringkat($member->peringkat)?>
                                                        <?=reposisi($member->reposisi)?>
                                                    </p>
                                                    <span class="text-dark">
                                                    <?=$member->id_member.' - '.$member->nama_member?> (<?=base64_decode($member->id)?>)</span>
                                                    <p class="size-12">Tanggal Daftar :
                                                        <?=tgl_indo_jam($member->created_at)?>
                                                    </p>

                                                </div>
                                            </div>
                                            <div style="display:flex; gap:10px; justify-content:flex-end">
                                                <div class="text-center">
                                                    <p>Referall</p>
                                                    <p><?=$cm->sponsori(base64_decode($member->id))?></p>
                                                </div>
                                                <div class="text-center">
                                                    <p>Omset</p>
                                                    <p><?=$cm->total_omset(base64_decode($member->id))?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $no++;
                            downline(base64_decode($member->id), $member->level, $no);
                        ?>
                    </div>
                </li>
                <?php
            }
        }
    }
    downline('master', 0, 1);
?>
            </ul>
</div>
<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
    $(document).ready(function () {
        // $('.listree-submenu-heading').trigger('click');
    });
    function replaceText() {

        $("#genealogy").find(".highlight").removeClass("highlight");

        var searchword = $("#searchtxt").val();

        var custfilter = new RegExp(searchword, "ig");
        var repstr = "<span class='highlight'>" + searchword + "</span>";

        if (searchword != "") {
            $('body').each(function() {
                $(this).html($(this).html().replace(custfilter, repstr));
            })
        }
    }

    function actionToggle(el){
        var element = $(el);
        if(element.hasClass('collapsed')){
            element.removeClass('collapsed');
            element.html(`<i class="fa fa-solid fa-minus mr-2"></i> Collapse All`);
            $('.listree-submenu-heading').addClass('expanded');
            $('.listree-submenu-heading').find('ul').show();
        } else {
            element.addClass('collapsed');
            element.html(`<i class="fa fa-solid fa-plus mr-2"></i> Expand All`);
            $('.listree-submenu-heading').removeClass('expanded');
            $('.listree-submenu-heading').find('ul').hide();
        }
    }

    function getDownline(upline, el) {
        var element = $(el).closest('.listree-submenu-heading');
        if (element.hasClass('expanded')) {
            element.removeClass('expanded');
            element.find('ul').hide();

            // $(el).closest('.listree-submenu-heading').find('ul').remove();
        } else {
            element.addClass('expanded');
            element.find('ul').show();
            // $.ajax({
            //     url: "controller/member/get_downline.php",
            //     data: {
            //         upline: upline
            //     },
            //     type: "POST",
            //     dataType: "html",
            //     cache: false,
            //     success: function (data) {
            //         $(el).closest('.listree-submenu-heading').addClass('expanded').append(data);
            //     }
            // });
        }
    }
</script>