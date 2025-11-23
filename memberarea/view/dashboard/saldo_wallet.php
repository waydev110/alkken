<!-- Custom styles moved to assets/css/custom-memberarea.css -->
<!-- <div class="row"> -->
    <!-- <div class="swiper-container poinswiper mt-1">
        <div class="swiper-wrapper">
            <div class="swiper-slide"> -->
                <div class="custom-order-card card shadow-sm mt-2 mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center align-self-center">
                                <p class="text-custom-primary fw-bold size-12 mb-0">Wallet Cash</p>
                                <p><?=rp($saldo_wallet)?></p>
                            </div>
                            <div class="col text-center align-self-center">
                                <p class="text-custom-primary fw-bold size-12 mb-0">Wallet Autosave</p>
                                <p><?=rp($saldo_poin)?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-order-card card shadow-sm mt-2 mb-4">
                   <div class="card-body">
                       <div class="row">
                           <?php 
                                $total_penarikan = $cwd->total_penarikan($session_member_id, 'cash');
                           ?>
                           <div class="col text-center align-self-center">
                               <p class="text-custom-primary fw-bold size-12 mb-0">Total Penarikan</p>
                               <p><?=rp($total_penarikan)?></p>
                           </div>
                           <?php 
                                $limit_penarikan = $cwd->limit_penarikan($session_member_id, 'cash');
                           ?>
                           <div class="col text-center align-self-center">
                               <p class="text-custom-primary fw-bold size-12 mb-0">Limit Penarikan</p>
                               <p><?=rp($limit_penarikan)?></p>
                           </div>
                       </div>
                   </div>
                </div>
            <!-- </div>
        </div>
    </div> -->
<!-- </div> -->