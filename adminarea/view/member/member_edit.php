<?php
require_once("../model/classBank.php");
require_once("../model/classKodeAktivasi.php");
require_once("../model/classMember.php");
$id = base64_decode($_GET['id']);

$cb = new classBank();
$cka= new classKodeAktivasi();
$cm = new classMember();
$data= $cm->detail($id);
$generasi_upline = $cm->generasi_upline($id);
require_once('../model/classProvinsi.php');
$cpr = new classProvinsi();
$provinsi = $cpr->index();

require_once('../model/classKota.php');
$ck = new classKota();
$kota = $ck->get_kota($data->id_provinsi);

require_once('../model/classKecamatan.php');
$ckec = new classKecamatan();
$kecamatan = $ckec->get_kecamatan($data->id_kota);

require_once('../model/classKelurahan.php');
$ckel = new classKelurahan();
$kelurahan = $ckel->get_kelurahan($data->id_kecamatan);

$query_bank = $cb->index();
require_once('../model/classPlan.php');
$cp = new classPlan();
$plan = $cp->index(0);


require_once('../model/classProdukJenis.php');
$cpj = new classProdukJenis();
$produk_jenis = $cpj->index(0);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data Member</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body box-profile">
                <form class="form-horizontal" action="controller/member/member_edit.php" method="post"
                    name="formPendaftaran" id="formPendaftaran">
                    <input type="hidden" name="id" value="<?=base64_encode($data->id)?>">
                    <div class="box-body">
                        <div class="alert alert-primary">
                            <strong>DATA MEMBER</strong>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="id_plan">Paket <?=$lang['member']?></label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" id="id_plan" name="id_plan">
                                    <option value="">Pilih Paket</option>
                                    <?php while ($row = $plan->fetch_object()) {?>
                                    <option value="<?=$row->id?>"
                                        <?=$data->id_plan == $row->id ? 'selected="selected"' : ''?>>
                                        <?=$row->nama_plan?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="id_produk_jenis">Jenis Paket</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" id="id_produk_jenis" name="id_produk_jenis">
                                    <option value="">Pilih Jenis Paket</option>
                                    <?php while ($row = $produk_jenis->fetch_object()) {?>
                                    <option value="<?=$row->id?>"
                                        <?=$data->id_produk_jenis == $row->id ? 'selected="selected"' : ''?>>
                                        <?=$row->short_name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nama Member</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_member" name="nama_member"
                                    placeholder="masukkan nama member" required="required" id="nama-member"
                                    value="<?=$data->nama_member;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nama Samaran</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_samaran" required="required" id="nama_samaran"
                                    value="<?=$data->nama_samaran;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user_member" required="required" id="user_member"
                                    value="<?=$data->user_member;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">No. Handphone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="hp_member"
                                    placeholder="masukkan no handphone" value="<?=$data->hp_member;?>"
                                    id="hp_member">
                                <p class="text-red" id="pesan-hp"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Group Akun</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="group_akun" required="required" id="group_akun"
                                    value="<?=$data->group_akun;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="sponsor">Sponsor</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="sponsor" name="sponsor">
                                    <option value="<?=$data->sponsor?>"><?=$data->sponsor?> | <?=$data->id_sponsor?> | <?=$data->username_sponsor?> | <?=$data->nama_sponsor?></option>
                                    <?php 
                                    while ($row = $generasi_upline->fetch_object()) {
                                    $upline = $cm->show($row->upline);
                                    ?>
                                    <option value="<?=$row->upline?>"
                                        <?=$upline->id == $data->sponsor ? 'selected="selected"' : ''?>>
                                        <?=$upline->id?> | <?=$upline->id_member?> | <?=$upline->user_member?> | <?=$upline->nama_member?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="alert alert-primary">
                            <strong>ALAMAT LENGKAP</strong>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="kota">Provinsi</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" id="provinsi" name="provinsi">
                                    <option value="">Pilih Provinsi</option>
                                    <?php while ($row = $provinsi->fetch_object()) {?>
                                    <option value="<?=$row->id?>"
                                        <?=$data->id_provinsi == $row->id ? 'selected="selected"' : ''?>>
                                        <?=$row->nama_provinsi?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="kota">Kabupaten/Kota</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" id="kota" name="kota">
                                    <option value="">Pilih Kab/Kota</option>
                                    <?php while ($row = $kota->fetch_object()) {?>
                                    <option value="<?=$row->id?>"
                                        <?=$data->id_kota == $row->id ? 'selected="selected"' : ''?>>
                                        <?=$row->nama_kota?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="kecamatan">Kecamatan</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" id="kecamatan" name="kecamatan">
                                    <option value="">Pilih Kecamatan</option>
                                    <?php while ($row = $kecamatan->fetch_object()) {?>
                                    <option value="<?=$row->id?>"
                                        <?=$data->id_kecamatan == $row->id ? 'selected="selected"' : ''?>>
                                        <?=$row->nama_kecamatan?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="kelurahan">Kelurahan</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" id="kelurahan" name="kelurahan">
                                    <option value="">Pilih Kelurahan</option>
                                    <?php while ($row = $kelurahan->fetch_object()) {?>
                                    <option value="<?=$row->id?>"
                                        <?=$data->id_kelurahan == $row->id ? 'selected="selected"' : ''?>>
                                        <?=$row->nama_kelurahan?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="alamat">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="alamat"
                                    name="alamat"><?=$data->alamat_member?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="kodepos">Kodepos</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kodepos" name="kodepos"
                                    value="<?=$data->kodepos_member?>" maxlength="5">
                            </div>
                        </div>
                        <div class="alert alert-primary">
                            <strong>DATA REKENING</strong>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Pilih Bank</label>
                            <div class="col-sm-10">
                                <select name="id_bank" size="1" class="form-control">
                                    <?php 
                                    while($data_bank = $query_bank->fetch_object()){
                                      if($data->id_bank == $data_bank->id){
                                        echo "<option value='".$data_bank->id."' selected='selected'>".$data_bank->nama_bank."</option>";
                                      }else{
                                        echo "<option value='".$data_bank->id."'>".$data_bank->nama_bank."</option>";  
                                      }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">No. Rekening</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="no_rekening"
                                    placeholder="masukkan no rekening" required="required" min="0" id="no-rekening"
                                    autocomplete="off" value="<?=$data->no_rekening;?>">
                                <p class="text-red" id="pesan-rekening"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Atas Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="atas_nama_rekening" name="atas_nama_rekening"
                                    placeholder="masukkan nama rekening"
                                    value="<?=$data->atas_nama_rekening?>" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Cabang</label>
                            <div class="col-sm-10">
                                <input type="text" name="cabang_rekening" class="form-control"
                                    value="<?=$data->cabang_rekening;?>" placeholder="">
                            </div>
                        </div>

                        <div class="bottom">
                            <button type="button" class="btn btn-default" onclick="history.back()"> <i class="fa fa-arrow-left"></i>
                                Kembali</button>
                            <button type="button" class="btn btn-primary pull-right" id="btnSubmit"
                                name="ubah_member"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'view/wilayah/wilayah.php' ?>
<script src="../assets/plugins/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script>    
    $('#nama_member').on("keyup", function (e) {
        $('#atas_nama_rekening').val(e.target.value);
    });
    $(document).ready(function () {
        var formPendaftaran = $('#formPendaftaran');
        var btnSubmit = $('#btnSubmit');
        var current_user_member = '<?=$data->user_member?>';
        formPendaftaran.validate({
            rules: {
                nama_member: {
                    required: true
                },
                hp_member: {
                    required: true
                },
                sponsor: {
                    required: true
                },
                
                bank:"required",
                no_rekening:{
                    required:true
                },
                user_member:{
                    required:true,
                    verifyUsername:true
                },
                atas_nama_rekening:"required",
                cabang_rekening:"required"
            },
            messages: {
                nama_member: {
                    required: "Nama tidak boleh kosong."
                },
                hp_member: {
                    required: "Nomor Whatsapp tidak boleh kosong."
                },
                sponsor: {
                    required: "Sponsor tidak boleh kosong."
                },
                no_rekening:{
                    required:"Nomor rekening tidak boleh kosong."
                },
                atas_nama_rekening:"Atas nama rekening tidak boleh kosong.",
                cabang_rekening:"Cabang/Unit rekening tidak boleh kosong.",
            }
        });
        
        $.validator.addMethod("verifyUsername", function(value) {
            var response = 'false';
            $.ajax({
                type: 'post',
                url: 'controller/member/cek_username.php',
                data: {user_member: value, current_user_member:current_user_member},
                async:false,
                success: function (result) {
                    const obj = JSON.parse(result);
                    response = obj.status;
                },
            });
            if(response == true){
                console.log(response);
                return true;
            } else {
                console.log(response);
                return false;
            }
        }, 'Username tidak tersedia.');

        btnSubmit.on("click", function (e) {
            if (formPendaftaran.valid()) {
                formPendaftaran.submit();
            }
            e.preventDefault();
        });
        
        formPendaftaran.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        alert('Edit data berhasil.');
                    } else {
                        alert('Edit data gagal.');
                    }
                }
            });
            e.preventDefault();
        });
    });
        
</script>