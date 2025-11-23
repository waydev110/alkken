<?php
require_once("../model/classProduk.php");
$cp = new classProduk();
require_once("../model/classSatuan.php");
$cs = new classSatuan();
$satuan = $cs->index();
require_once("../model/classProdukJenis.php");
$cpj = new classProdukJenis();
$produk_jenis = $cpj->index();
require_once("../model/classBonusFounder.php");
$cbf = new classBonusFounder();
$persentase_bonus_founder = $cbf->persentase_index();

$id = $_GET['id'];

$data= $cp->show($id);

?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$title?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body box-profile">
                <form class="form-horizontal" enctype="multipart/form-data"
                    action="controller/<?=$mod_url?>/edit.php" method="post" name="frmProduk" id="frmProduk">
                    <input type="hidden" name="id" id="id" value="<?=$data->id?>">
                    <div class="box-body">
                        <div class="form-group">
                            <input type="hidden" name="gambar_sebelumnya" value="<?=$data->gambar;?>">

                            <?php if($data->gambar<>''){ ?>
                            <label for="" class="col-sm-2 control-label">Gambar Sebelumnya</label>
                            <div class="col-sm-10">
                                <img src="../images/produk/<?=$data->gambar?>" width="100">
                            </div>
                            <?php }?>
                        </div>
                        <div class="form-group">
                            <label for="gambar" class="col-sm-2 control-label">Ganti Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="gambar" placeholder="" id="gambar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_produk_jenis" class="col-sm-2 control-label">Jenis Produk</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="id_produk_jenis" name="id_produk_jenis" required="required">
                                    <?php
                                    while($row = $produk_jenis->fetch_object()){
                                    ?>
                                    <option value="<?=$row->id?>" <?=$data->id_produk_jenis == $row->id ? 'selected="selected"' : '' ?>><?=$row->name?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_produk" class="col-sm-2 control-label">Nama Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_produk" id="nama_produk" required="required" value="<?=$data->nama_produk?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hpp" class="col-sm-2 control-label">HPP</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric" name="hpp" value="<?=$data->hpp;?>"
                                        required="required" id="hpp">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="harga" class="col-sm-2 control-label">Harga</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="harga" id="harga" required="required" value="<?=$data->harga?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nilai_produk" class="col-sm-2 control-label">Poin Produk</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control autonumeric3" name="nilai_produk" id="nilai_produk" required="required"  value="<?=$data->nilai_produk?>">
                            </div>
                            <label for="poin_pasangan" class="col-sm-2 control-label">Poin Pasangan</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control autonumeric3" name="poin_pasangan" id="poin_pasangan" required="required"  value="<?=$data->poin_pasangan?>">
                            </div>
                            <label for="poin_reward" class="col-sm-2 control-label">Poin Reward</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control autonumeric4" name="poin_reward" id="poin_reward" required="required" value="<?= str_replace('.', ',', $data->poin_reward) ?>" pattern="^\d{1,9}([\.,]\d{1,4})?$" inputmode="decimal" placeholder="0,00">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Pilih Paket</label>
                            <div class="col-sm-10">
                                <div class="row" id="produkPlan">      
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus_sponsor" class="col-sm-2 control-label">Bonus Sponsor</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="bonus_sponsor" required="required"  value="<?=$data->bonus_sponsor?>"
                                        id="bonus_sponsor">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus_cashback" class="col-sm-2 control-label">Bonus Cashback</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="bonus_cashback" required="required"  value="<?=$data->bonus_cashback?>"
                                        id="bonus_cashback">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus_generasi" class="col-sm-2 control-label">Bonus Generasi</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="bonus_generasi" required="required"  value="<?=$data->bonus_generasi?>"
                                        id="bonus_generasi">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus_upline" class="col-sm-2 control-label">Bonus Upline</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="bonus_upline" required="required"  value="<?=$data->bonus_upline?>"
                                        id="bonus_upline">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fee_stokis" class="col-sm-2 control-label">Fee Stokis</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="fee_stokis" required="required"  value="<?=$data->fee_stokis?>"
                                        id="fee_stokis">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fee_founder" class="col-sm-2 control-label">Fee Founder</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="fee_founder" required="required" id="fee_founder" value="<?=$data->fee_founder?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fee_founder" class="col-sm-2 control-label">Keterangan Bonus</label>
                            <?php while($row = $persentase_bonus_founder->fetch_object()){ ?>
                                <label for="fee_founder_<?=$row->id?>" data-persentase="<?=$row->persentase_bonus?>" class="col-sm-4 control-label fee-founder-label text-danger" style="text-align:left"><?=$row->name?> <?=$row->persentase_bonus?>% = Rp. <span id="fee_founder_<?=$row->id?>">0</span></label>
                            <?php } ?>
                        </div>
                        <script>
                            $(document).ready(function() {
                                // Trigger calculation on page load
                                setTimeout(function() {
                                    calculateFeeFounder();
                                }, 100);
                                
                                $('#fee_founder').on('keyup change', function() {
                                    calculateFeeFounder();
                                });
                                
                                function calculateFeeFounder() {
                                    var feeFounder = $('#fee_founder').autoNumeric('get');
                                    $('.fee-founder-label').each(function() {
                                        var persentase = parseFloat($(this).data('persentase'));
                                        var calculatedFee = (feeFounder * persentase) / 100;
                                        var spanId = $(this).attr('for');
                                        var formattedValue = calculatedFee.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
                                        $('#' + spanId).text(formattedValue);
                                    });
                                }
                                // Allow only numbers, comma, and dot for poin_reward
                                $('#poin_reward').on('input', function() {
                                    let val = $(this).val().replace(/[^\d.,]/g, '');
                                    // Replace multiple commas/dots with single
                                    val = val.replace(/([.,]){2,}/g, '$1');
                                    $(this).val(val);
                                });
                            });
                        </script>
                        <div class="form-group">
                            <label for="qty" class="col-sm-2 control-label">Qty</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="qty" value="<?=$data->qty?>"
                                    placeholder="masukkan netto produk" required="required" id="qty">
                            </div>
                            <label for="satuan" class="col-sm-1 control-label">Satuan</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="satuan" name="satuan" required="required">
                                    <?php
                                    while($row = $satuan->fetch_object()){
                                    ?>
                                    <option value="<?=$row->satuan?>" <?=$data->satuan == $row->satuan ? 'selected' : '' ?>><?=$row->satuan?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Deskripsi Produk</label>
                            <div class="col-sm-10">
                                <textarea class="form-control ckeditor" id="ckeditor" name="keterangan" placeholder=""
                                    required="required"><?=$data->keterangan?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tampilkan" class="col-sm-2 control-label">Tampilkan</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="tampilkan" name="tampilkan" required="required">
                                    <option value="1" <?=$data->tampilkan == '1' ? 'selected' : '' ?>>Ya</option>
                                    <option value="0" <?=$data->tampilkan == '0' ? 'selected' : '' ?>>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>Batal</a>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/plugins/ckeditor4_basic/ckeditor.js"></script>
<script>
    var id_produk = $('#id').val();
    $(document).ready(function () {
        $('#id_produk').on('change', function (e) { 
            id_produk = $('#id_produk').val();
            get_produk_plan(id_produk);
        });

        get_produk_plan(id_produk);
    });
    function get_produk_plan(id_produk){       
        $.ajax({
            url: 'controller/produk/get_produk_plan.php',
            type: 'post',
            data: {
                    id_produk:id_produk,
                    },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#produkPlan').html(obj.html);
                } else {
                    $('#produkPlan').html('');
                }
            }
        });
    }
</script>