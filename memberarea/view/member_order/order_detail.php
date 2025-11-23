<?php
    require_once '../model/classMember.php';
    require_once '../model/classMemberOrder.php';
    require_once '../model/classMemberOrderDetail.php';

    $cm = new classMember();
    $obj = new classMemberOrder();
    $objd = new classMemberOrderDetail();

    if(!isset($_GET['id_order'])){
        header("location: index.php?go=riwayat_order");
    }

    $id_order = base64_decode($_GET['id_order']);
    $order = $obj->show($id_order, $session_member_id);
    $order_detail = $objd->index($id_order);
?>
<?php include 'view/layout/header.php'; ?>

<link rel="stylesheet" href="assets/css/style-product.css">
<link rel="stylesheet" href="assets/css/custom-memberarea.css">

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
                    <h3 class="size-14 mb-2 text-dark">Alamat Pengiriman</h3>
                </div>
                <div class="col align-self-center text-end size-9 text-danger">
                </div>
            </div>
            <div class="card mb-0 rounded-0 border-0 border-bottom pb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col align-self-center size-12 text-dark">
                            <p>Dikirim ke :</p>
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
                    <div class="card-body bg-light size-13">
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
                    <h3 class="size-14 mt-4 mb-2 text-dark">Detail Pesanan</h3>

                <div class="card mb-0 border-0 rounded-0 border-bottom">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h3 class="size-14 text-dark">Stokis : <?=$order->nama_stokis?></h3>
                                        <p class="size-12 mb-0 text-dark">Alamat : <?=$order->kota_stokis?></p>
                                        <p class="size-12 mb-2 text-dark">No. Telp : <?=$order->hp_stokis?></p>
                                    </div>
                                    <div class="col-auto ps-0 text-end">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $jumlah = 0;
                while($row = $order_detail->fetch_object()){
                $jumlah += $row->jumlah;
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <div class="">
                                        <img src="../images/produk/<?=$row->gambar?>" alt="" width="60">
                                    </div>
                                </div>
                                <div class="col align-self-center">
                                    <h3 class="size-14 text-dark"><?=$row->nama_produk?></h3>
                                    <h3 class="size-14 text-price mb-2"><?=rp($row->harga)?> x <?=currency($row->qty)?></h3>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h3 class="size-14 text-price mb-2 text-end"><?=rp($row->jumlah)?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto align-self-left">
                                    <h3 class="size-14 text-dark">SubTotal</h3>
                                </div>
                                <div class="col align-self-center">
                                    <h3 class="size-14 mb-2 text-end text-dark"><?=rp($jumlah)?></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto align-self-left">
                                    <h3 class="size-14 text-dark">Kode Unik</h3>
                                </div>
                                <div class="col align-self-center">
                                    <h3 class="size-14 mb-2 text-end text-dark"><?=rp($order->nominal-$jumlah)?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0 rounded-0 border-0 border-bottom">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto align-self-left">
                                    <h3 class="size-14 text-dark">Total</h3>
                                </div>
                                <div class="col align-self-center">
                                    <h3 class="size-14 mb-2 text-end text-dark"><?=rp($order->nominal)?></h3>
                                </div>
                            </div>
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