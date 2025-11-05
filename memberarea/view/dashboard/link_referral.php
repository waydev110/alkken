
<?php 
    $link_referral = 'https://netlife.id/'.$session_id_member;

?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <div class="avatar avatar-70 rounded-circle size-24">
                            <i class="fad fa-lightbulb-on fa-3x"></i>
                        </div>
                    </div>
                    <div class="col align-self-center ps-0">
                        <p class="small mb-1"><a href="<?=$link_referral?>" class="fw-medium" id="link_referral"><?=$link_referral?></a></p>
                        <p class="size-12">Hi... <span class="text-success fw-bold text-uppercase"><?=$session_nama_member?></span>. Dapatkan Komisi Referral setiap pembelian produk dari link referralmu.</p>
                    </div>
                    <div class="col-auto align-self-center">
                        <button class="btn btn-44 btn-default shadow-sm" onclick="copyToClipboard('#link_referral')">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="col-12">
                    <div class="progress bg-none h-2 hideonprogressbar" data-target="hideonprogress">
                        <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>