<?php
    require_once '../helper/all.php';
    require_once '../model/classKodeAktivasi.php';
    require_once '../model/classPlan.php';
    require_once '../model/classStokisJualPin.php';
    require_once '../model/classStokisJualPinDetail.php';
    require_once '../model/classTransferKodeAktivasi.php';
    require_once '../model/classMember.php';
    require_once '../model/classBonusSponsor.php';
    require_once '../model/classBonusGenerasi.php';
    require_once '../model/classBonusUpline.php';
    require_once '../model/classBonusCashback.php';
    require_once '../model/classBonusPasangan.php';
    require_once '../model/classBonusReward.php';
    require_once '../model/classBonusBalikModal.php';
    require_once '../model/classWallet.php';
    
    $obj = new classKodeAktivasi();
    $cpl = new classPlan();
    $cjp = new classStokisJualPin();
    $cjpd = new classStokisJualPinDetail();
    $ctp = new classTransferKodeAktivasi();
    $cm = new classMember();
    $cks = new classBonusSponsor();
    $ckg = new classBonusGenerasi();
    $cku = new classBonusUpline();
    $cbc = new classBonusCashback();
    $cbp = new classBonusPasangan();
    $cbr = new classBonusReward();
    $cbbm = new classBonusBalikModal();
    $cw = new classWallet();
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    } else {
        echo 'Error';
        return false;
    }
    
    $data = $obj->show($id);
    $nama_plan = $cpl->show($data->jenis_aktivasi)->nama_plan;
    $jual_pin = $cjp->show_id($data->id_jual_pin);
    $jual_pin_detail = $cjpd->index($data->id_jual_pin);
    $history_transfer = $ctp->history($id);
    $history_aktivasi = $obj->history($id);
    $bonus_sponsor = $cks->history($id);
    $bonus_generasi = $ckg->history($id);
    $bonus_upline = $cku->history($id);
    $bonus_cashback = $cbc->history($id);
    $poin_pasangan = $cbp->history_poin($id);
    $poin_reward = $cbr->history_poin($id);
    $rekap_balik_modal = $cbbm->history_rekap($id);
    $bonus_balik_modal = $cbbm->history($id);
?>
<style>
    h5{
        margin-bottom:0px;
    }
</style>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
        <a href="?go=<?=$mod_url?>_list" class="btn btn-primary btn-sm pull-right"><i class="fa fa-arrow-alt-circle-left"></i>
            Kembali</a>
    </div>
    <div class="box-body">
        <h5><strong>Detail PIN</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">Tanggal Kirim</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Nama Paket</th>
                        <th class="text-center">Kode Aktivasi</th>
                        <th class="text-center">Harga PIN</th>
                        <th class="text-center">Jumlah HU</th>
                        <th class="text-center">Poin Reward</th>
                        <th class="text-center">Bonus <?=$lang['sponsor']?></th>
                        <th class="text-center">Bonus Cashback</th>
                        <th class="text-center">Bonus Generasi</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"><?=$data->created_at?></td>
                        <td class="text-center"><?=$data->id?></td>
                        <td class="text-center"><?=$nama_plan?></td>
                        <td class="text-center"><?=$data->kode_aktivasi?></td>
                        <td class="text-right"><?=currency($data->harga)?></td>
                        <td class="text-center"><?=currency($data->jumlah_hu)?></td>
                        <td class="text-right"><?=currency($data->poin_reward)?></td>
                        <td class="text-right"><?=currency($data->bonus_sponsor)?></td>
                        <td class="text-right"><?=currency($data->bonus_cashback)?></td>
                        <td class="text-right"><?=currency($data->bonus_generasi)?></td>
                        <td class="text-center"><?=status_aktivasi($data->status_aktivasi)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5><strong>Detail Jual PIN</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['stokis']?></th>
                        <th class="text-center">Nama <?=$lang['stokis']?></th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Nominal Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($jual_pin) {
                ?>
                    <tr>
                        <td class="text-center"><?=$jual_pin->created_at?></td>
                        <td class="text-center"><?=$jual_pin->id_stokis?></td>
                        <td class="text-left"><?=$jual_pin->nama_stokis?></td>
                        <td class="text-center"><?=$jual_pin->id_member?></td>
                        <td class="text-left"><?=$jual_pin->nama_member?></td>
                        <td class="text-right"><?=currency($data->harga)?></td>
                    </tr>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="6">Tidak ada history Jual PIN</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <h5><strong>Detail Jual Produk</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>HPP</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($jual_pin_detail->num_rows > 0) {
                    ?>
                    <?php
                    $no = 0;
                    while($row = $jual_pin_detail->fetch_object()) {
                        $no++;
                    ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-left"><?=$row->nama_produk  ?></td>
                        <td class="text-right"><?=currency($row->hpp)?></td>
                        <td class="text-right"><?=currency($row->harga)?></td>
                        <td class="text-right"><?=currency($row->qty)?></td>
                        <td class="text-right"><?=currency($row->jumlah)?></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="7">Tidak ada detail produk</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <h5><strong>History Transfer PIN</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transfer</th>
                        <th class="text-center">ID <?=$lang['member']?> Lama</th>
                        <th class="text-center">Nama <?=$lang['member']?> Lama</th>
                        <th class="text-center">ID <?=$lang['member']?> Baru</th>
                        <th class="text-center">Nama <?=$lang['member']?> Baru</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($history_transfer->num_rows > 0) {
                    ?>
                    <?php
                    $no = 0;
                    while($row = $history_transfer->fetch_object()) {
                        $no++;
                    ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-center"><?=$row->created_at?></td>
                        <td class="text-center"><?=$row->id_member_lama?></td>
                        <td class="text-left"><?=$row->nama_member_lama?></td>
                        <td class="text-center"><?=$row->id_member_baru?></td>
                        <td class="text-left"><?=$row->nama_member_baru?></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="7">PIN belum pernah ditransfer.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <h5><strong>History Aktivasi</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">Tanggal Aktivasi</th>
                        <!-- <th class="text-center"><?=$lang['member']?> ID</th> -->
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Generasi <?=$lang['member']?></th>
                        <!-- <th class="text-center"><?=$lang['sponsor']?> ID</th> -->
                        <th class="text-center">ID <?=$lang['sponsor']?></th>
                        <th class="text-center">Nama <?=$lang['sponsor']?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($history_aktivasi) {
                ?>
                    <tr>
                        <td class="text-center"><?=$history_aktivasi->created_at?></td>
                        <!-- <td class="text-center"><?=$history_aktivasi->member_id?></td> -->
                        <td class="text-center"><?=$history_aktivasi->id_member?></td>
                        <td class="text-left"><?=$history_aktivasi->nama_member?></td>
                        <td class="text-center"><?=$history_aktivasi->level?></td>
                        <!-- <td class="text-center"><?=$history_aktivasi->sponsor_id?></td> -->
                        <td class="text-center"><?=$history_aktivasi->id_sponsor?></td>
                        <td class="text-left"><?=$history_aktivasi->nama_sponsor?></td>
                    </tr>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="9">Tidak ada history aktivasi</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
        if($data->status_aktivasi == '1') {
        ?>
        <h5><strong>History Bonus <?=$lang['sponsor']?></strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal Transfer</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($bonus_sponsor) {
                ?>
                    <tr>
                        <td class="text-center"><?=$bonus_sponsor->created_at?></td>
                        <td class="text-center"><?=$bonus_sponsor->id_member?></td>
                        <td class="text-left"><?=$bonus_sponsor->nama_member?></td>
                        <td class="text-right"><?=currency($bonus_sponsor->nominal)?></td>
                        <td class="text-left" width="280"><?=$bonus_sponsor->keterangan?></td>
                        <td class="text-center"><?=status_transfer($bonus_sponsor->status_transfer)?></td>
                        <td class="text-center"><?=$bonus_sponsor->updated_at?></td>
                    </tr>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="6">Tidak ada history bonus</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <h5><strong>History Bonus Generasi</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Dari</th>
                        <th class="text-center">Generasi</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal Transfer</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($bonus_generasi->num_rows > 0) {
                ?>
                <?php
                $no = 0;
                while($row = $bonus_generasi->fetch_object()) {
                    $no++;
                ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-center"><?=$row->created_at?></td>
                        <td class="text-center"><?=$row->id_member?></td>
                        <td class="text-left"><?=$row->nama_member?></td>
                        <td class="text-right"><?=currency($row->nominal)?></td>
                        <td class="text-center"><?=$row->dari_member?></td>
                        <td class="text-center"><?=$row->generasi?></td>
                        <td class="text-center"><?=status_transfer($row->status_transfer)?></td>
                        <td class="text-center"><?=$row->updated_at?></td>
                    </tr>
                <?php 
                }
                ?>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="9">Tidak ada history bonus</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <h5><strong>History Bonus Upline</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Dari</th>
                        <th class="text-center">Generasi</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal Transfer</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($bonus_upline->num_rows > 0) {
                ?>
                <?php
                $no = 0;
                while($row = $bonus_upline->fetch_object()) {
                    $no++;
                ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-center"><?=$row->created_at?></td>
                        <td class="text-center"><?=$row->id_member?></td>
                        <td class="text-left"><?=$row->nama_member?></td>
                        <td class="text-right"><?=currency($row->nominal)?></td>
                        <td class="text-center"><?=$row->dari_member?></td>
                        <td class="text-center"><?=$row->generasi?></td>
                        <td class="text-center"><?=status_transfer($row->status_transfer)?></td>
                        <td class="text-center"><?=$row->updated_at?></td>
                    </tr>
                <?php 
                }
                ?>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="9">Tidak ada history bonus</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <h5><strong>History Bonus Cashback</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center" width="280">Keterangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Transfer</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($bonus_cashback) {
                ?>
                    <tr>
                        <td class="text-center"><?=$bonus_cashback->created_at?></td>
                        <td class="text-center"><?=$bonus_cashback->id_member?></td>
                        <td class="text-left"><?=$bonus_cashback->nama_member?></td>
                        <td class="text-right"><?=currency($bonus_cashback->nominal)?></td>
                        <td class="text-left"><?=$bonus_cashback->keterangan?></td>
                        <td class="text-center"><?=status_transfer($bonus_cashback->status_transfer)?></td>
                        <td class="text-center"><?=$bonus_cashback->updated_at?></td>
                    </tr>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="7">Tidak ada history bonus</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <h5><strong>History Poin Pasangan</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Poin</th>
                        <th class="text-center">Posisi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($poin_pasangan->num_rows > 0) {
                ?>
                <?php
                $no = 0;
                while($row = $poin_pasangan->fetch_object()) {
                    $no++;
                ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-center"><?=$row->created_at?></td>
                        <td class="text-center"><?=$row->id_member?></td>
                        <td class="text-left"><?=$row->nama_member?></td>
                        <td class="text-right"><?=currency($row->poin)?></td>
                        <td class="text-center"><?=$row->posisi?></td>
                    </tr>
                <?php 
                }
                ?>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="6">Tidak ada history poin pasangan</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <h5><strong>History Poin Reward</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Poin</th>
                        <th class="text-center">Posisi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($poin_reward->num_rows > 0) {
                ?>
                <?php
                $no = 0;
                while($row = $poin_reward->fetch_object()) {
                    $no++;
                ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-center"><?=$row->created_at?></td>
                        <td class="text-center"><?=$row->id_member?></td>
                        <td class="text-left"><?=$row->nama_member?></td>
                        <td class="text-right"><?=currency($row->poin)?></td>
                        <td class="text-center"><?=$row->posisi?></td>
                    </tr>
                <?php 
                }
                ?>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="6">Tidak ada poin reward</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
        }
        ?>
        <?php
        if($data->jenis_aktivasi == '16' || $data->jenis_aktivasi == '17') {
        ?>
        <h5><strong>Rekap Sharing Profit</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Sharing</th>
                        <th class="text-center">Persentase</th>
                        <th class="text-center">Total Bonus</th>
                        <th class="text-center">Total Member</th>
                        <th class="text-center">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($rekap_balik_modal->num_rows > 0) {
                ?>
                <?php
                $no = 0;
                while($row = $rekap_balik_modal->fetch_object()) {
                    $no++;
                ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-center"><?=$row->created_at?></td>
                        <td class="text-center"><?=$row->nama_plan?></td>
                        <td class="text-right"><?=currency($row->total_omset)?></td>
                        <td class="text-right"><?=$row->persentase?> %</td>
                        <td class="text-right"><?=currency($row->total_bonus)?></td>
                        <td class="text-center"><?=$row->total_member?></td>        
                        <td class="text-right"><?=currency($row->nominal)?></td>
                    </tr>
                <?php 
                }
                ?>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="8">Tidak ada Rekap</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <h5><strong>History Sharing Profit</strong></h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">ID <?=$lang['member']?></th>
                        <th class="text-center">Nama <?=$lang['member']?></th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Jenis Bonus</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal Transfer</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($bonus_balik_modal->num_rows > 0) {
                ?>
                <?php
                $no = 0;
                while($row = $bonus_balik_modal->fetch_object()) {
                    $no++;
                ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-center"><?=$row->created_at?></td>
                        <td class="text-center"><?=$row->id_member?></td>   
                        <td class="text-left"><?=$row->nama_member?></td>
                        <td class="text-right"><?=currency($row->nominal)?></td>
                        <td class="text-center"><?=$row->nama_plan?></td>
                        <td class="text-left"><?=$row->keterangan?></td>    
                        <td class="text-center"><?=status_transfer($row->status_transfer)?></td>
                        <td class="text-center"><?=$row->updated_at?></td>
                    </tr>
                <?php 
                }
                ?>
                <?php
                } else {
                ?>
                <tr>
                    <td class="text-center" colspan="8">Tidak ada Rekap</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
        }
        ?>
    </div>
</div>