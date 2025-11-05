<?php 
  // get_day
  date_default_timezone_set("Asia/Jakarta");
  if(!isset($_POST['bulan'])){
    $thnbln = date('Y-m', time());
    $bulandipilih = date('m', time());
    $tahundipilih = date('Y', time());
  }else{
    $thnbln = $_POST['tahun']."-".$_POST['bulan'];
    $bulandipilih = $_POST['bulan'];
    $tahundipilih = $_POST['tahun'];
  }
 
  $days = date('t',strtotime($thnbln));
  $month_day = date('m-d',time());
  
  require_once '../model/classPlan.php';
  require_once '../model/classKodeAktivasi.php';
  
  $cp = new classPlan();
  $cka = new classKodeAktivasi();
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <!-- <h3 class="box-title pull-left">Pilih Periode:</h3>     -->
    <!-- <a href="view/bonus/cetak_rekap_bonus.php" target="_blank" class="btn btn-primary btn-sm pull-right"><i class="fa fa-download"></i> Download</a> -->
    <form action="" method="post" accept-charset="utf-8" class="form-inline pull-left" autocomplete="off">
      <div class="form-group">
        <label>Bulan</label>
        
        <select name="bulan" size="1" class="form-control">
          <option value="01" <?=$bulandipilih=='01'?'selected="selected"':'';?>>Januari</option>
          <option value="02" <?=$bulandipilih=='02'?'selected="selected"':'';?>>Februari</option>
          <option value="03" <?=$bulandipilih=='03'?'selected="selected"':'';?>>Maret</option>
          <option value="04" <?=$bulandipilih=='04'?'selected="selected"':'';?>>April</option>
          <option value="05" <?=$bulandipilih=='05'?'selected="selected"':'';?>>Mei</option>
          <option value="06" <?=$bulandipilih=='06'?'selected="selected"':'';?>>Juni</option>
          <option value="07" <?=$bulandipilih=='07'?'selected="selected"':'';?>>Juli</option>
          <option value="08" <?=$bulandipilih=='08'?'selected="selected"':'';?>>Agustus</option>
          <option value="09" <?=$bulandipilih=='09'?'selected="selected"':'';?>>September</option>
          <option value="10" <?=$bulandipilih=='10'?'selected="selected"':'';?>>Oktober</option>
          <option value="11" <?=$bulandipilih=='11'?'selected="selected"':'';?>>Nopember</option>
          <option value="12" <?=$bulandipilih=='12'?'selected="selected"':'';?>>Desember</option>
        </select>
        
        <select name="tahun" size="1" class="form-control">
          <?php 
          for ($thn=date('Y',time()); $thn >= 2018 ; $thn--) { 
            if($tahundipilih == $thn){
              echo '<option value="'.$thn.'" selected="selected">'.$thn.'</option>';
            }else{
              echo '<option value="'.$thn.'">'.$thn.'</option>';
            }
            
          }
          ?>
        </select>

      </div>
      <button type="submit" class="btn btn-sm btn-primary" name="lihat"><i class="fa fa-search"></i> Lihat</button>
    </form>
    
  </div>
  <div class="box-body">
    
  </div>
</div>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Statistik Harian Aktivasi Paket</h3>
  </div>
  <div class="box-body">

    <div class="table-responsive">
      <table id="" class="table table-hover" border="1" bordercolor="#ddd">
        <thead>
          <tr>
            <th>Tanggal</th>
            <?php 
              $plan = $cp->index();
              while ($row = $plan->fetch_object()) {
                echo '<th>'.$row->nama_plan.'</th>';
              }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php 
          for ($day=1; $day <= $days; $day++) { 
            
            if($day < 10){
              $tgl = '0'.$day;
            }else{
              $tgl = $day;
            }  

            if(!isset($_POST['bulan'])){
              $bulane = date('m',time());
              $tahune = date('Y',time());
            }else{
              $bulane = $_POST['bulan'];
              $tahune = $_POST['tahun'];
            }
            
            #$tanggal = date('Y-m-', time()).'-'.$tgl;
            $tanggal = $tahune.'-'.$bulane.'-'.$tgl;
            ?>
              <tr>
                <td align="center"><?=$tgl;?>/<?=!isset($_POST['lihat'])?date('m/Y'):$_POST['bulan'].'/'.$_POST['tahun'];?></td>
                <?php       
                $plan = $cp->index();
                while ($row = $plan->fetch_object()) {
                    $total_aktivasi_harian = $cka->total_aktivasi_harian($row->id, $tanggal);
                    $total_aktivasi[$row->id] += $total_aktivasi_harian;
                    echo '<td align="right">'.$total_aktivasi_harian.'</td>';
                }
                ?>
              </tr>
            <?php
          }
          ?>
          
        </tbody>
        <tfoot>
          <tr>
            <td align="right" style="background-color: #CCCCCC;">Total</td>
            <?php
              $plan = $cp->index();
              while ($row = $plan->fetch_object()) {
                echo '<td align="right" style="background-color: #CCCCCC;">'.$total_aktivasi[$row->id].'</td>';
              }
            ?>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
