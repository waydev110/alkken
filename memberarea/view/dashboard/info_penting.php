<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <div class="avatar avatar-40 alert-danger text-danger rounded-circle">
                            <i class="bi bi-info size-20"></i>
                        </div>
                    </div>
                    <div class="col align-self-center ps-0">
                        <?php if($total_penarikan >= $limit_penarikan) { ?>
                        <p class="size-12 mb-0 text-muted">Limit WD bonus harian kamu saat ini sebesar <span class="size-18 text-color-theme fw-bold"><?=rp(0)?></span></p>
                        <p class="size-12 text-danger">Limit WD bonus harian kamu sudah tercapai.</p>
                        <?php } else { ?>
                        <p class="size-12 mb-0 text-muted">Limit WD bonus kamu saat ini sebesar <span class="size-18 text-color-theme fw-bold"><?=rp($limit_penarikan-$total_penarikan)?></span></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>