<?php
if(isset($_POST['nominal']) && isset($_POST['rekening'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classRekening.php';
    $obj = new classRekening();
    
    $id_member = $session_member_id;
    $nominal = number($_POST['nominal']);
    $id_rekening = addslashes(strip_tags($_POST['rekening']));
    $rekening = $obj->show($id_rekening);
    if($nominal < 0){
        echo json_encode(['status' => false, 'html' => 'Nominal Topup minimal Rp'.rp($nominal)]);
        return false;
    }
    $kode_unik = mt_rand(100, 999);
    $total_bayar = $nominal+$kode_unik;
    $html = '
            <h6>Total Pembayaran:</h6>
            <h3 class="text-danger my-2">'.rp($total_bayar).'</h3>
            <div class="alert alert-warning" role="alert">
                <p class="size-12">Bayar sesuai jumlah diatas (termasuk kode unik).</p>
            </div>
            <p class="text-muted size-11">Gunakan ATM/iBanking/setor tunai untuk transfer ke Rekening berikut ini.</p>
            
            <div class="row">
                <div class="col align-self-center">
                    <div class="row">
                        <div class="col-auto align-self-center">
                                <h6>'.$rekening->nama_bank.'</h6>
                        </div>
                        <div class="col align-self-center text-end">
                        <button class="btn btn-sm px-0 size-9" onclick="copyToClipboard('."'#no_rekening'".')"><i class="fa fa-copy"></i> Salin</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <p class="size-14">Nomor Rekening</p>
                        </div>
                        <div class="col align-self-center text-end">
                            <p class="size-14" id="no_rekening">'.$rekening->no_rekening.'</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto align-self-center ">
                            <p class="size-14">Cabang</p>
                        </div>
                        <div class="col align-self-center text-end">
                        <p class="size-14">'.$rekening->cabang_rekening.'</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto align-self-center ">
                            <p class="size-14">Nama Rekening</p>
                        </div>
                        <div class="col align-self-center text-end">
                        <p class="size-14">'.$rekening->atas_nama_rekening.'</p>
                        </div>
                    </div>
                </div>
            </div>';
    echo json_encode(['status' => true, 'nominal' => $nominal, 'kode_unik' => $kode_unik, 'total_bayar' => $total_bayar, 'html' => $html]);
}