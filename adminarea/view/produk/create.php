<?php
    require_once("../model/classSatuan.php");
    $cs = new classSatuan();
    $satuan = $cs->index();
    require_once("../model/classProdukJenis.php");
    $cpj = new classProdukJenis();
    $produk_jenis = $cpj->index();
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
                    action="controller/<?=$mod_url?>/create.php" method="post" name="frmProduk" id="frmProduk">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Gambar</label>
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
                                    <option value="<?=$row->id?>"><?=$row->name?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_produk" class="col-sm-2 control-label">Nama Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_produk" id="nama_produk" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hpp" class="col-sm-2 control-label">HPP</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric" name="hpp"
                                        required="required" id="hpp">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="harga" class="col-sm-2 control-label">Harga</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="harga" id="harga" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nilai_produk" class="col-sm-2 control-label">Poin Produk</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control autonumeric3" name="nilai_produk" id="nilai_produk" required="required">
                            </div>
                            <label for="poin_pasangan" class="col-sm-2 control-label">Poin Pasangan</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control autonumeric3" name="poin_pasangan" id="poin_pasangan" required="required">
                            </div>
                            <label for="poin_reward" class="col-sm-2 control-label">Poin Reward</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control autonumeric3" name="poin_reward" id="poin_reward" required="required">
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
                                    <input type="text" class="form-control autonumeric3" name="bonus_sponsor" required="required" id="bonus_sponsor">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus_cashback" class="col-sm-2 control-label">Bonus Cashback</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="bonus_cashback" required="required" id="bonus_cashback">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus_generasi" class="col-sm-2 control-label">Bonus Generasi</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="bonus_generasi" required="required" id="bonus_generasi">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus_upline" class="col-sm-2 control-label">Bonus Upline</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="bonus_upline" required="required" id="bonus_upline">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="fee_stokis" class="col-sm-2 control-label">Fee Stokis</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="fee_stokis" required="required" id="fee_stokis">
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="fee_founder" class="col-sm-2 control-label">Fee Founder</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="text" class="form-control autonumeric3" name="fee_founder" required="required" id="fee_founder">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="qty" class="col-sm-2 control-label">Qty</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="qty" placeholder="" required="required" id="qty">
                            </div>
                            <label for="satuan" class="col-sm-1 control-label">Satuan</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="satuan" name="satuan" required="required">
                                    <?php
                                    while($row = $satuan->fetch_object()){
                                    ?>
                                    <option value="<?=$row->satuan?>"><?=$row->satuan?></option>
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
                                    required="required"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tampilkan" class="col-sm-2 control-label">Tampilkan</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="tampilkan" name="tampilkan" required="required">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="?go=<?=$mod_url?>" class="btn btn-default"> <i class="fa fa-arrow-left"></i>
                                Batal</a>
                            <button type="submit" class="btn btn-primary pull-right" id="btnSimpan" name="simpan"><i
                                    class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/plugins/ckeditor4_basic/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        get_produk_plan();
    });
    function get_produk_plan(){       
        $.ajax({
            url: 'controller/produk/get_produk_plan.php',
            type: 'post',
            data: {},
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