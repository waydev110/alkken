<?php
    require_once '../model/classMember.php';
    require_once '../model/classMemberAutosave.php';
    require_once '../model/classMemberAutosaveDetail.php';

    $cm = new classMember();
    $obj = new classMemberAutosave();
    $objd = new classMemberAutosaveDetail();

    if(!isset($_GET['id_order'])){
        header("location: index.php?go=riwayat_order");
    }

    $id_order = base64_decode($_GET['id_order']);
    $order = $obj->show($id_order, $session_member_id);
    $order_detail = $objd->index($id_order);
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <div class="col-auto">
                <a href="?go=cart" class="btn btn-light btn-44 back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="col align-self-center text-left">
                <h5><?=$title?></h5>
            </div>
            <?php include 'view/layout/cart.php'; ?>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <div class="row">
            
        <div class="col">
            <?php
            if($order_detail->num_rows > 0) {
            ?>
            <div class="row">
                <div class="col-auto align-self-center">
                    <h3 class="size-14 mb-2 text-theme">Alamat Pengiriman</h3>
                </div>
                <div class="col align-self-center text-end size-9 text-danger">
                </div>
            </div>
            <div class="card mb-0 rounded-0 border-0 border-bottom pb-0">
                <div class="card-body">
                    <div class="row" id="alamat">
                        <div class="col align-self-center size-12">
                            <p>Dikirim ke :</p>
                            <p>Penerima : <?=$order->nama_member?> (<?=$order->hp_member?>)</p>
                            <p><?=$order->nama_provinsi?>, <?=$order->nama_kota?></p>
                            <p><?=$order->nama_kecamatan?>, <?=$order->nama_kelurahan?></p>
                            <p><?=$order->alamat_kirim?></p>
                            <p><?=$order->kodepos?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if($order->status == '2') {
            ?>
                <div class="card mb-0 rounded-0 border-0 border-bottom">
                    <div class="card-body size-13">
                        <table>
                            <tr>
                                <td width="120">Jasa Pengiriman</td>
                                <td width="10">:</td>
                                <td><?=$order->nama_jasa_ekspedisi?></td>
                            </tr>
                            <tr>
                                <td>Ongkos Kirim</td>
                                <td>:</td>
                                <td class="fw-bold"><?=rp($order->biaya_kirim)?></td>
                            </tr>
                            <tr>
                                <td>No Resi</td>
                                <td>:</td>
                                <td><?=$order->no_resi?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
            }
                ?>
                <div class="row">
                    <div class="col-auto align-self-center">
                        <h3 class="size-14 mt-4 mb-2 text-theme">Detail</h3>
                    </div>
                    <div class="col align-self-center text-end size-9 text-danger">
                    </div>
                </div>
                <div class="card mb-0 rounded-0 border-0 border-bottom">
                <?php
                while($row = $order_detail->fetch_object()){
                ?>
                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <input type="hidden" name="id_cart[<?=$row->id?>]" value="<?=$row->id?>">
                            <div class="avatar avatar-50">
                                <img src="../images/produk/<?=$row->gambar?>" alt="" width="100%">
                            </div>
                        </div>
                        <div class="col align-self-center">
                            <h3 class="size-12">Produk <?=$row->nama_plan?></h3>
                            <h3 class="size-18"><?=$row->nama_produk?></h3>
                            <h3 class="size-14  mb-2"><?=currency($row->harga)?> x <?=currency($row->qty)?>
                            </h3>
                        </div>
                        <div class="col-auto align-self-center">
                            <h3 class="size-18"><?=currency($row->harga*$row->qty)?></h3>
                        </div>
                    </div>
                </div>
                    <?php
                }
                ?>
                </div>
                <div class="card mb-0 rounded-0">
                    <div class="card-body pt-4">
                        <div class="row border-0">
                            <div class="col-auto align-self-left">
                                <h3 class="size-14">Total Harga</h3>
                            </div>
                            <div class="col align-self-center">
                                <h3 class="size-18 mb-2 text-end"><?=currency($order->nominal+$order->saldo_poin)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto align-self-center">
                        <h3 class="size-14 mt-4 mb-2 text-theme">Pembayaran</h3>
                    </div>
                    <div class="col align-self-center text-end size-9 text-danger">
                    </div>
                </div>
                <div class="card mb-0 rounded-0">
                    <div class="card-body pt-4">
                        <div class="row border-0">
                            <div class="col-auto align-self-left">
                                <h3 class="size-14">Saldo Autosave</h3>
                            </div>
                            <div class="col align-self-center">
                                <h3 class="size-18 mb-2 text-end"><?=currency($order->saldo_poin)?></h3>
                            </div>
                        </div>
                        <?php if($order->nominal > 0) { ?>
                        <div class="row border-0">
                            <div class="col-auto align-self-center">
                                <h3 class="size-14">Cash</h3>
                            </div>
                            <div class="col align-self-center">
                                <h3 class="size-18 mb-2 text-end"><?=currency($order->nominal)?></h3>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center ps-0">
                                <p class="mb-0"><span class="text-muted size-12">Tidak ada data.</span></p>

                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
    </div>
    <!-- main page content ends -->
</main>

<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<?php include 'view/layout/footer.php'; ?>