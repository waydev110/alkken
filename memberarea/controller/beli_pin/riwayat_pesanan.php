<?php
if (isset($_POST['start'])) {
    require_once '../../../helper/all_member.php';
    require_once '../../../model/classStokisJualPin.php';
    require_once '../../../model/classStokisJualPinDetail.php';
    $obj = new classStokisJualPin();
    $csjd = new classStokisJualPinDetail();

    $id_member = $_SESSION['session_member_id'];
    $start = $_POST['start'] == NULL ? 0 : $_POST['start'];
    $id_stokis = $_POST['id_stokis'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $keyword = addslashes(strip_tags($_POST['keyword']));
    $result = $obj->riwayat_pesanan($id_member, $start, $keyword, $id_stokis, $start_date, $end_date);
    if ($result) {
        $html = '';
        $count = $result->num_rows;
        if ($count > 0) {
            $start += 10;
            while ($row = $result->fetch_object()) {
                // $tanggal = $row->id_stokis == '1' ? $row->updated_at : $row->created_at;
                $tanggal = $row->created_at;
                $html .= '<div class="card mb-2 pb-2 rounded-2 border-0 border-bottom">
                            <div class="card-header py-2">
                                <div class="row">
                                    <div class="col-auto pe-0 align-self-center">
                                        <span class="size-9 p-1 text-white bg-warning rounded-2">' . $row->nama_paket . '</tag>
                                    </div>
                                    <div class="col ps-1 align-self-center">
                                        <p class="text-dark size-11 p-1">' . strtolower($row->nama_stokis) . '</p>
                                    </div>
                                    <div class="col-auto align-self-center text-end">
                                        <span class="size-11 fw-bold p-1 text-primary rounded-2">'.$row->created_at.'</tag>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="card-body text-dark">
                        ';
                $detail = $csjd->index($row->id);
                $total_produk = 0;
                $total_harga = 0;
                $no = 0;
                while ($produk = $detail->fetch_object()) {
                    $no++;
                    $total_produk += $produk->qty;
                    $total_harga += $produk->harga * $produk->qty;
                    $class_card = $no > 1 ? 'id="listProduk'.$row->id.'" style="display:none"' : '';
                    $html .= '
                                <div class="row" '.$class_card.'>
                                    <div class="col-auto align-self-center">
                                        <div>
                                            <img src="../images/produk/' . $produk->gambar . '" width="80">
                                        </div>
                                    </div>
                                    <div class="col ps-0 align-self-top">
                                        <div class="row justify-content-between">
                                            <div>
                                                <p class="text-muted size-11 mb-0">' . $produk->name . '</p>
                                                <p class="size-14 mb-0">' . $produk->nama_produk . '</p>
                                                <div class="row">
                                                    <div class="col align-self-center">
                                                        <p class="text-muted size-11 mb-0">' . $produk->qty_produk . ' ' . $produk->satuan . '</p>
                                                    </div>
                                                    <div class="col-auto align-self-center text-end">
                                                        <p class="text-muted size-11 mb-0">x' . $produk->qty . '</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="size-14 mb-0 text-end">' . rp($produk->harga) . '</p>
                                        </div>
                                    </div>
                                </div>';
                }
                if($no > 1){
                    $html .= '
                                    <div class="row">
                                        <button type="button" class="btn btn-transparent text-dark small" id="btnShow" onclick="show('."'#listProduk".$row->id."',this".')">Lihat Semua <i class="fa fa-chevron-down"></i></button>
                                    </div>';
                }
                $html .= '
                                <div class="row mt-4">
                                    <div class="col align-self-center text-end">
                                        <p>Total ' . currency($total_produk) . ' produk: <strong>' . rp($total_harga) . '</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        } else {
            $count = 0;
            if ($start == 0) {
                $html = '<div class="card shadow-none rounded-15">
                            <div class="card-body p-5">
                                <div class="row">
                                    <div class="col">
                                        <p class="text-muted text-center"><i class="fa-light fa-analytics fa-8x"></i></p>                            
                                        <h6 class="text-center fw-normal">Tidak ada pesanan.</h6>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        exit(json_encode(['status' => true, 'html' => $html, 'start' => $start, 'count' => $count]));
    } else {
        exit(json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.']));
    }
}
