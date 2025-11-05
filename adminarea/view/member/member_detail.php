<?php 
  require_once("../model/classMember.php"); 
  require_once("../model/classBank.php"); 
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Detail Member</h3>
     
  </div>
  <!-- /.box-header -->
  <div class="box-body">

    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#biodata" data-toggle="tab">Biodata</a></li>
        <li><a href="#jaringan" data-toggle="tab">Jaringan</a></li>
        <li><a href="#bonus-sponsor" data-toggle="tab">Bonus <?=$lang['sponsor']?></a></li>
        <li><a href="#bonus-pasangan" data-toggle="tab">Bonus Pasangan</a></li>
        <li><a href="#auto-save" data-toggle="tab">Auto Save</a></li>
        <li><a href="#auto-maintain" data-toggle="tab">Auto Maintain</a></li>
        <li><a href="#reset" data-toggle="tab">Reset Password</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="biodata">
         <?php require_once("../detail_part/biodata.php"); ?>
        </div>
        <div class="tab-pane" id="jaringan">
          <?php require_once("../detail_part/jaringan.php"); ?>
        </div>
        <div class="tab-pane" id="bonus-sponsor">
          <?php require_once("../detail_part/bonus_sponsor.php"); ?>
        </div>
        <div class="tab-pane" id="bonus-pasangan">
          <?php require_once("../detail_part/bonus_pasangan.php"); ?>
        </div>
        <div class="tab-pane" id="auto-save">
          <?php require_once("../detail_part/auto_save.php"); ?>
        </div>
        <div class="tab-pane" id="auto-maintain">
          <?php require_once("../detail_part/auto_maintain.php"); ?>
        </div>
        <div class="tab-pane" id="reset">
          <?php require_once("../detail_part/reset_password.php"); ?>
        </div>
      </div>
      <!-- /.tab-content -->
    </div>
  </div>
</div>