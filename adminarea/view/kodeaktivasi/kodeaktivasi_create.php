<?php
require_once("../model/classPlan.php");
require_once("../model/classProdukJenis.php");
require_once("../model/classBonusFounder.php");
$cpl = new classPlan();
$cpj = new classProdukJenis();
$cbf = new classBonusFounder();
$plan = $cpl->index(0);
$founder = $cbf->index_founder();
$jenis_produk = $cpj->index();
?>
<style>
    .card-product {
        padding: 8px;
        background-color: #FFFFFF;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    .card-image {
        display: block;
    }
    .card-product .jenis-title{
        text-align: center;
        display: grid;
        padding-left: 10px;
        padding-right: 10px;
    }

    .card-product img {
        border-radius: 4px;
    }

    .price {
        margin-top: 0px;
        margin-bottom: 0px;
        font-size: 20px;
        font-weight: bold;
    }

    .stock {
        margin-top: 0px;
        font-size: 11px !important;
    }

    .card-title {
        font-size: 24px !important;
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .card-detail {
        padding: 15px;
        background-color: #FFFFFF;
        border-radius: 12px;
        color: #094d7c;
    }

    .card-summary {
        padding: 0px 15px 15px 15px;
        background-color: #fff;
        border:2px solid #094d7c;
        margin-top: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .card-summary .subtotal {
        font-size: 14px;
        font-weight: bold;
    }

    .card-summary .total {
        margin-top: 15px;
        font-size: 20px;
        font-weight: bold;
    }

    .card-order {
        min-height: 250px;
        padding-top: 15px;
    }

    .card-customer {
        padding: 15px 15px 5px 15px;
        background-color: #FFFFFF;
        margin-top: 0px;
        margin-bottom: 15px;
        border-radius: 12px;
    }

    .header-title .select2-container--default .select2-selection--single,
    .header-title .select2-selection .select2-selection--single {
        border-radius: 12px;
        font-size: 16px;
    }

    .header-title {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0 10px;
        gap: 15px;
        margin-bottom:10px;
    }
    .product-order {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0;
        gap: 15px;
        margin-bottom:10px;
    }
    .product-order-detail {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 15px
    }
    h5.jenis-title {
        padding:10px 2px;
        margin-top: 5px;
        margin-bottom: 6px;
        font-size: 13px!important;
        font-weight: 700;
    }
    h5.title {
        white-space: nowrap;
        font-weight: bold;
        display:block;
        width: 100%;
        overflow-y: hidden;
        overflow-x: auto;
    }
    .stokis-title {
        font-size: 13px!important;
        font-weight: 500;
    }
    .h2-title {
        margin-top: 0px;
        margin-bottom: 0px;
        font-size: 18px;
    }

    .btn-rounded {
        border-radius: 50px;
        font-size: 14px;
        padding: auto 10px;
    }
    .price-order{
        margin-top: 0px;
        margin-bottom: 0px;
        font-size:12px;
    }
    .my-0{
        margin-top:0;
        margin-bottom:0;
    }
    .px-4{
        padding:4px 10px
    }
    .bg-success {
        background-color: #ffffffc4;
    }
    .bg-danger {
        background-color: #fffb0094;
    }
    .header-content-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap:10px;
    }
    .member-title{
        font-size: 12px;
    }
    label {
        margin-top: 5px;
        text-align:left;
        display: block;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" enctype="multipart/form-data" action="controller/<?=$mod_url?>/<?=$mod_url?>_create.php" method="post" id="formCreate">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create <?=$lang['kode_aktivasi']?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body box-profile">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="control-label"><?=$lang['member']?></label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_member" name="id_member" placeholder="ID <?=$lang['member']?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="control-label">Nama <?=$lang['member']?></label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_member" name="nama_member" placeholder="Nama <?=$lang['member']?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="control-label">Paket</label>
                        </div>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_plan" id="id_plan">
                                <option value='' selected='selected'>-- Pilih Paket --</option>   
                                <?php 
                                  while ($row = $plan->fetch_object()) {
                                    echo '<option value="'.$row->id.'">'.$row->nama_plan.'</option>';
                                  }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="control-label">Jenis Produk</label>
                        </div>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis_produk" id="jenis_produk">
                                <option value='' selected='selected'>-- Pilih Jenis Produk --</option>   
                                <?php 
                                  while ($row = $jenis_produk->fetch_object()) {
                                    echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                  }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="control-label">Qty</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="qty_paket" name="qty_paket" value="1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="control-label">Reposisi</label>
                        </div>
                        <div class="col-sm-10">
                            <select class="form-control" name="reposisi" id="reposisi">                                
                                <option value='' selected='selected'>-- Pilih Reposisi --</option>                                     
                                <option value='1'>Ya</option>                                
                                <option value='0'>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="control-label">Founder</label>
                        </div>
                        <div class="col-sm-10">
                            <select name="founder" id="founder" class="form-control">
                                <option value='0' selected='selected'></option>
                                <?php 
                              while ($row = $founder->fetch_object()) {
                                echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                              }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary pull-right">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="../assets/plugins/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script>
    var modalSuccess = $('#modalSuccess');
    var formCreate = $('#formCreate');
    var btnSubmit = $('#btnSubmit');

    $(document).ready(function () {
        // modalSuccess.modal('show');

        formCreate.validate({
            rules: {
                id_member: {
                    required: true,
                    verifyMember: true
                },
                id_plan: "required",
                qty_paket: {
                    required: true,
                    min: 1
                },
                reposisi: "required",
                founder: "required"
            },
            messages: {
                id_member: {
                    required: "ID Member tidak boleh kosong.",
                    verifyMember: "Member tidak ditemukan."
                },
                qty_paket: {
                    required: "Paket tidak boleh kosong.",
                    min: "Paket minimal 1."
                },
                id_plan: "Paket tidak boleh kosong.",
                reposisi: "Reposisi tidak boleh kosong.",
                founder: "Founder tidak boleh kosong."
            }
        });

        $.validator.addMethod("verifyMember", function(value, element) {
            return $.ajax({
                url: 'controller/member/member_search.php',
                type: 'post',
                data: {id_member:value},
                success: function (result) {
                    const obj = JSON.parse(result);
                    $('#nama_member').val(obj.nama_member);
                    return obj.status;
                }
            });
        }, 'Member tidak ditemukan.');

        formCreate.on("submit", function (e) {
            e.preventDefault();
            var dataString = $(this).serialize();
            $.ajax({
                url: 'controller/kodeaktivasi/kodeaktivasi_create.php',
                type: 'post',
                data: dataString,
                success: function (result) {
                    const obj = JSON.parse(result);
                    alert(obj.message);
                }
            });
        });     
    });
</script>