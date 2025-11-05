<?php
    if(!function_exists('vstatus_bonus')){
        function vstatus_bonus($status_transfer){
            switch ($status_transfer) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Pending';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Ditransfer';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold" style="position:absolute;right:15px;bottom:15px;">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
            // echo '<div class="tag bg-'.$class_name.' border-'.$class_name.' text-white text-center mt-1 py-2 px-4">
            //         '.$keterangan.'
            //     </div>';
        }
    }
    if(!function_exists('vstatus_normal')){
        function vstatus_normal($status){
            switch ($status) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Diproses';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Berhasil';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-0 mb-0 size-12 text-'.$class_name.' fw-bold">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
        }
    }

    if(!function_exists('vstatus_penukaran')){
        function vstatus_penukaran($status){
            switch ($status) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Diproses';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Dikirim';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                case '3':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Dibatalkan';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
            // echo '<div class="tag bg-'.$class_name.' border-'.$class_name.' text-white text-center mt-1 py-2 px-4">
            //         '.$keterangan.'
            //     </div>';
        }
    }

    if(!function_exists('vtgl_bonus')){
        function vtgl_bonus($tanggal, $jam=''){
            if($jam <> ''){
                echo '<p class="text-end mt-2 mb-0 size-11 text-muted">'.$tanggal.',</p>';
                echo '<p class="text-end mb-0 size-11 text-muted">'.$jam.'</p>';
            } else {
                echo '<p class="text-end mt-2 mb-0 size-11 text-muted">'.$tanggal.'</p>';
            }
        }
    }

    if(!function_exists('vicon_bonus')){
        function vicon_bonus($jenis_bonus){
            switch ($jenis_bonus) {
                case 'sponsor':
                        $icon = 'chalkboard-teacher';
                    break;
                
                default:
                    $icon = 'money';
                    break;
            }
            echo '<div class="avatar avatar-30 rounded-circle bg-secondary text-white">
                        <i class="fas fa-'.$icon.'"></i>
                  </div>';
        }
    }
    

    if(!function_exists('vstatus_aktivasi')){
        function vstatus_aktivasi($status_aktivasi){
            switch ($status_aktivasi) {
                case '0':
                        $class = 'active';
                        $status_aktivasi = 'Tersedia';
                    break;
                case '1':
                        $class = '';
                        $status_aktivasi = 'Terpakai';
                    break;
                case '2':
                        $class = 'bg-success text-white';
                        $status_aktivasi = 'Terkirim';
                    break;
                default :
                        $class = 'bg-warning';
                        $status_aktivasi = 'Undefined';
                    break;
            }
            return '<div class="tag '.$class.' py-1">
                        '.$status_aktivasi.'
                  </div>';
        }
    }
    

    if(!function_exists('vicon_pengirim')){
        function vicon_pengirim($icon_pengirim){
            switch ($icon_pengirim) {
                case 'member':
                        $class = 'theme';
                        $icon = '<i class="fa-solid fa-user-tag"></i>';
                    break;
                case 'stokis':
                        $class = 'dark';
                        $icon = '<i class="fa-solid fa-bags-shopping"></i>';
                    break;
                default :
                        $class = 'skyblue';
                        $icon = '<i class="fa-solid fa-paper-plane"></i>';
                    break;
            }
            $icon_pengirim = '<div class="avatar avatar-30 border-'.$class.' text-'.$class.' shadow-sm rounded-circle">
                                '.$icon.'
                            </div>';
            return $icon_pengirim;
        }
    }
    

    if(!function_exists('vjenis_paket')){
        function vjenis_paket($jenis_paket){
            switch ($jenis_paket) {
                case '0':
                        $jenis_paket = 'Paket Pendaftaran';
                    break;
                case '1':
                        $jenis_paket = 'Paket Repeat Order';
                    break;
            }
            return $jenis_paket;
        }
    }

    if(!function_exists('reposisi')){
        function reposisi($string){
            switch ($string) {
                case '1':
                    $string = '<span class="badge bg-warning fw-light">Free</span>';
                    break;
                default :
                    $string = '';
                    break;
            }
            return $string;
        }
    }

    if(!function_exists('vstatus_order')){
        function vstatus_order($status_order){
            switch ($status_order) {
                case '-1':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Menunggu Pembayaran';
                    break;
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Pending';
                    break;
                case '1':
                    $icon = 'fa-box';
                    $class_name = 'success';
                    $keterangan = 'Perlu Dikirim';
                    break;
                case '2':
                    $icon = 'fa-truck-fast';
                    $class_name = 'success';
                    $keterangan = 'Dikirim';
                    break;
                case '3':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Selesai';
                    break;
                case '4':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                case '5':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Dibatalkan';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold" >
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
            // echo '<div class="tag bg-'.$class_name.' border-'.$class_name.' text-white text-center mt-1 py-2 px-4">
            //         '.$keterangan.'
            //     </div>';
        }
    }
    
    if(!function_exists('vrekap_bonus')){
        function vrekap_bonus(){
            echo '<div class="row">
                        <div class="col-sm-4">
                            <div class="small-box bg-blue">
                                <div class="inner text-right">
                                    <h4 id="total_bonus">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Bonus</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box bg-green">
                                <div class="inner text-right">
                                    <h4 id="total_admin">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Admin</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box bg-red">
                                <div class="inner text-right">
                                    <h4 id="total_transfer">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Transfer</a>
                            </div>
                        </div>
                    </div>';
        }
    }
    if(!function_exists('vrekap_bonus_pending')){
        function vrekap_bonus_pending(){
            echo '<div class="row">
                        <div class="col-sm-4">
                            <div class="small-box bg-blue">
                                <div class="inner text-right">
                                    <h4 id="total_bonus">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Bonus</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box bg-green">
                                <div class="inner text-right">
                                    <h4 id="total_autosave">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Autosave</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box bg-green">
                                <div class="inner text-right">
                                    <h4 id="total_admin">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Admin</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box bg-green">
                                <div class="inner text-right">
                                    <h4 id="total_cash">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Cash</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box bg-green">
                                <div class="inner text-right">
                                    <h4 id="total_transfer">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Transfer</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box bg-red">
                                <div class="inner text-right">
                                    <h4 id="total_pending">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Pending</a>
                            </div>
                        </div>
                    </div>';
        }
    }
    
    if(!function_exists('vrekap_bonus_single')){
        function vrekap_bonus_single(){
            echo '<div class="row">
                        <div class="col-sm-12">
                            <div class="small-box bg-blue">
                                <div class="inner text-right">
                                    <h4 id="total_bonus">Rp0,-</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Bonus</a>
                            </div>
                        </div>
                    </div>';
        }
    }
    
    if(!function_exists('vwidget')){
        function vwidget($nominal1, $nominal2, $nominal3){
            echo '
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">STATISTIK DEPOSIT STOKIS</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-xs-6">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h4>'.$nominal1.'</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Nominal</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h4>'.$nominal2.'</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Diskon</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h4>'.$nominal3.'</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">Total Deposit</a>
                            </div>
                        </div>
                    </div>';
        }
    }
    if(!function_exists('vstatus_bonus')){
        function vstatus_bonus($status_transfer){
            switch ($status_transfer) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Pending';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Ditransfer';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold" style="position:absolute;right:15px;bottom:15px;">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
            // echo '<div class="tag bg-'.$class_name.' border-'.$class_name.' text-white text-center mt-1 py-2 px-4">
            //         '.$keterangan.'
            //     </div>';
        }
    }
    if(!function_exists('vstatus_normal')){
        function vstatus_normal($status){
            switch ($status) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Diproses';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Berhasil';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
            // echo '<div class="tag bg-'.$class_name.' border-'.$class_name.' text-white text-center mt-1 py-2 px-4">
            //         '.$keterangan.'
            //     </div>';
        }
    }

    if(!function_exists('vstatus_penukaran')){
        function vstatus_penukaran($status){
            switch ($status) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Diproses';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Dikirim';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                case '3':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Dibatalkan';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
            // echo '<div class="tag bg-'.$class_name.' border-'.$class_name.' text-white text-center mt-1 py-2 px-4">
            //         '.$keterangan.'
            //     </div>';
        }
    }

    if(!function_exists('vtgl_bonus')){
        function vtgl_bonus($tanggal, $jam=''){
            if($jam <> ''){
                echo '<p class="text-end mt-2 mb-0 size-11 text-muted">'.$tanggal.',</p>';
                echo '<p class="text-end mb-0 size-11 text-muted">'.$jam.'</p>';
            } else {
                echo '<p class="text-end mt-2 mb-0 size-11 text-muted">'.$tanggal.'</p>';
            }
        }
    }

    if(!function_exists('vicon_bonus')){
        function vicon_bonus($jenis_bonus){
            switch ($jenis_bonus) {
                case 'sponsor':
                        $icon = 'chalkboard-teacher';
                    break;
                
                default:
                    $icon = 'money';
                    break;
            }
            echo '<div class="avatar avatar-30 rounded-circle bg-secondary text-white">
                        <i class="fas fa-'.$icon.'"></i>
                  </div>';
        }
    }
    

    if(!function_exists('vstatus_aktivasi')){
        function vstatus_aktivasi($status_aktivasi){
            switch ($status_aktivasi) {
                case '0':
                        $class = 'active';
                        $status_aktivasi = 'Tersedia';
                    break;
                case '1':
                        $class = '';
                        $status_aktivasi = 'Terpakai';
                    break;
                case '2':
                        $class = 'bg-success text-white';
                        $status_aktivasi = 'Terkirim';
                    break;
                default :
                        $class = 'bg-warning';
                        $status_aktivasi = 'Undefined';
                    break;
            }
            return '<div class="tag '.$class.' py-1">
                        '.$status_aktivasi.'
                  </div>';
        }
    }
    

    if(!function_exists('vicon_pengirim')){
        function vicon_pengirim($icon_pengirim){
            switch ($icon_pengirim) {
                case 'member':
                        $class = 'theme';
                        $icon = '<i class="fa-solid fa-user-tag"></i>';
                    break;
                case 'stokis':
                        $class = 'dark';
                        $icon = '<i class="fa-solid fa-shop"></i>';
                    break;
                default :
                        $class = 'skyblue';
                        $icon = '<i class="fa-solid fa-paper-plane"></i>';
                    break;
            }
            $icon_pengirim = '<div class="avatar avatar-30 border-'.$class.' text-'.$class.' shadow-sm rounded-circle">
                                '.$icon.'
                            </div>';
            return $icon_pengirim;
        }
    }
    

    if(!function_exists('vjenis_peringkat')){
        function vjenis_peringkat($jenis_peringkat){
            switch ($jenis_peringkat) {
                case '0':
                        $jenis_peringkat = 'Paket Pendaftaran';
                    break;
                case '1':
                        $jenis_peringkat = 'Paket Repeat Order';
                    break;
            }
            return $jenis_peringkat;
        }
    }

    if(!function_exists('reposisi')){
        function reposisi($string){
            switch ($string) {
                case '1':
                    $string = '<span class="badge bg-warning fw-light">Free</span>';
                    break;
                default :
                    $string = '';
                    break;
            }
            return $string;
        }
    }

    if(!function_exists('vstatus_order')){
        function vstatus_order($status_order){
            switch ($status_order) {
                case '-1':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Menunggu Pembayaran';
                    break;
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Pending';
                    break;
                case '1':
                    $icon = 'fa-box';
                    $class_name = 'success';
                    $keterangan = 'Diproses';
                    break;
                case '2':
                    $icon = 'fa-truck-fast';
                    $class_name = 'success';
                    $keterangan = 'Dikirim';
                    break;
                case '3':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Selesai';
                    break;
                case '4':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Ditolak';
                    break;
                case '5':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Dibatalkan';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold" style="position:absolute;right:15px;bottom:15px;">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
            // echo '<div class="tag bg-'.$class_name.' border-'.$class_name.' text-white text-center mt-1 py-2 px-4">
            //         '.$keterangan.'
            //     </div>';
        }
    }
    
    
    if(!function_exists('vinfo_bonus')){
        function vinfo_bonus($title, $total_transfer, $total_pending, $bg_color){
            echo '<div class="swiper-slide">
                <div class="card mb-3 bg-white">
                    <div class="card-body p-2">
                        <div class="row mb-2">
                            <div class="col align-self-center">
                                <h4 class="size-14 mb-0 text-theme">'.$title.'</h4>
                            </div>
                        </div>
                        <div class="row mb-2 position-relative">
                            <div class="col pe-0">
                                <div class="form-group form-floating">
                                    <input type="text" class="form-control pt-3 pb-2 text-start size-12"
                                        value="'.currency($total_transfer).'" disabled="disabled">
                                    <label class="form-control-label">Ditransfer</label>
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <div class="form-group form-floating">
                                    <input type="text" class="form-control pt-3 pb-2 text-end size-12"
                                        value="'.currency($total_pending).'" disabled="disabled">
                                    <label class="form-control-label text-end pe-1 end-0 start-auto">Pending</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    if(!function_exists('vinfo_kodeaktivasi')){
        function vinfo_kodeaktivasi($title, $terpakai, $tersedia){
            echo '<div class="swiper-slide">
                <div class="card mb-3 bg-white">
                    <div class="card-body p-2">
                        <div class="row mb-2">
                            <div class="col-auto">
                                <div class="avatar avatar-36 bg-theme text-white shadow-sm rounded-2">
                                    <i class="fa-solid fa-analytics"></i>
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <a href="'.site_url('stok_pin').'" class="mb-0 text-theme">'.$title.'</a>
                            </div>
                        </div>
                        <div class="row mb-2 position-relative">
                            <div class="col pe-0">
                                <div class="form-group form-floating">
                                    <input type="text" class="form-control pt-3 pb-2 text-start size-12"
                                        value="'.currency($tersedia).'" disabled="disabled">
                                    <label class="form-control-label">Tersedia</label>
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <div class="form-group form-floating">
                                    <input type="text" class="form-control pt-3 pb-2 pe-2 text-end size-12"
                                        value="'.currency($terpakai).'" disabled="disabled">
                                    <label class="form-control-label text-end pe-1 end-0 start-auto">Terpakai</label>
                                </div>
                            </div>
                            <a href="'.site_url('stok_pin').'" class="btn btn-34 bg-theme text-white shadow-sm position-absolute start-50 top-50 translate-middle">
                                <i class="fa-solid fa-ellipsis-v"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    if(!function_exists('vinfo')){
        function vinfo($title, $info){
            echo '<div class="swiper-slide">
                    <div class="card mb-3 bg-white">
                        <div class="card-body p-2">
                            <div class="row mb-2">
                                <div class="col-auto">
                                    <div class="avatar avatar-36 bg-theme text-white shadow-sm rounded-2">
                                        <i class="fa-solid fa-box-open-full"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="mb-0 text-theme">'.$title.'</p>
                                </div>
                            </div>
                            <div class="row mb-2 position-relative">
                                <div class="col">
                                    <div class="form-group form-floating">
                                        <input type="text" class="form-control pt-3 pb-2 text-left"
                                            value="'.$info.'" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
    }

    if(!function_exists('vrekap_bonus_slide')){
        function vrekap_bonus_slide($title, $nominal, $bg_color){
            $html = '<div class="swiper-slide">
                        <div class="card shadow-sm mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto px-0">
                                        <div class="avatar avatar-40 bg-'.$bg_color.' text-white shadow-sm rounded-10-end">
                                            <i class="fa-solid fa-money-bill-wave"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="text-theme fw-bold size-12 mb-0">'.$title.'</p>
                                        <p>'.rps($nominal).'</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
            return $html;
        }
    }
    

    if(!function_exists('vrekap_bonus')){
        function vrekap_bonus($title, $nominal, $bg_color){
            $html = '<li class="list-group-item py-2">
                        <div class="row">
                            <div class="col align-self-center">
                                <p class="text-dark size-14">'.$title.'</p>
                            </div>
                            <div class="col align-self-center text-end">
                                <p class="text-color-theme size-14 mb-0">
                                '.rp($nominal).'</p>
                            </div>
                        </div>
                    </li>';
            return $html;
        }
    }
    if(!function_exists('vstatus_rekap')){
        function vstatus_rekap($status_rekap){
            switch ($status_rekap) {
                case '0':
                    $icon = 'fa-clock-rotate-left';
                    $class_name = 'secondary';
                    $keterangan = 'Pending';
                    break;
                case '1':
                    $icon = 'fa-circle-check';
                    $class_name = 'success';
                    $keterangan = 'Direkap';
                    break;
                case '2':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Skip (tidak RO)';
                    break;
                case '3':
                    $icon = 'fa-circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Upgrade Server';
                    break;
                
                default:
                    $icon = 'circle-xmark';
                    $class_name = 'danger';
                    $keterangan = 'Not Define';
                    break;
            }
            
            echo '<p class="text-end mt-2 mb-0 size-12 text-'.$class_name.' fw-bold" style="position:absolute;right:15px;bottom:15px;">
            <span class="text-'.$class_name.' size-11"><i class="fa-light '.$icon.'"></i></span> '.$keterangan.'</p>';
            // echo '<div class="tag bg-'.$class_name.' border-'.$class_name.' text-white text-center mt-1 py-2 px-4">
            //         '.$keterangan.'
            //     </div>';
        }
    }
    
    
                                    
