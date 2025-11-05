<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mt-0 mb-0">
            <div class="card-body">
                <div class="swiper-container menuswiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide text-center">
                            <div class="col-12">
                                <div class="avatar avatar-40">
                                    <a href="<?= site_url('genealogy_v1') ?>" class="size-32">
                                        <i class="fa-solid fa-users-class"></i>
                                    </a>
                                </div>
                                <div class="row size-11 text-blue">
                                    <p class="size-12 fw-light">Jumlah <?= $lang['member'] ?></p>
                                    <?php if ($_binary == 'true') { ?>
                                        <div class="col-6 pe-1 align-self-center">
                                            <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= currency($member->jumlah_kiri) ?></p>
                                        </div>
                                        <div class="col-6 ps-1 align-self-center">
                                            <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= currency($member->jumlah_kanan) ?></p>
                                        </div>
                                    <?php } else {

                                    ?>
                                        <div class="col-12 align-self-center">
                                            <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= currency($total_sponsori) ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $poin_pasangan = $cm->total_poin_pasangan($session_member_id, 4);
                        ?>
                        <div class="swiper-slide text-center">
                            <div class="col-12">
                                <div class="avatar avatar-40">
                                    <a href="<?= site_url('riwayat_poin_pasangan') ?>&plan=<?= base64_encode(4) ?>" class="size-32 text-primary">
                                        <i class="fas fa-a"></i>
                                    </a>
                                </div>
                                <div class="row size-11 text-primary">
                                    <p class="size-12 fw-light">Total Poin Pasangan</p>
                                    <div class="col-6 pe-1 align-self-center">
                                        <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= currency($poin_pasangan->jumlah_kiri) ?></p>
                                    </div>
                                    <div class="col-6 ps-1 align-self-center">
                                        <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= currency($poin_pasangan->jumlah_kanan) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($_binary == true) {
                            while ($row = $plan_pasangan->fetch_object()) {
                                $poin_pasangan = $cm->jumlah_poin_pasangan($session_member_id, $row->id);
                        ?>
                                <div class="swiper-slide text-center">
                                    <div class="col-12">
                                        <div class="avatar avatar-40">
                                            <a href="<?= site_url('riwayat_poin_pasangan') ?>&plan=<?= base64_encode($row->id) ?>" class="size-32 text-<?= $row->bg_color ?>">
                                                <i class="fa-solid fa-people-arrows"></i>
                                            </a>
                                        </div>
                                        <div class="row size-11 text-<?= $row->bg_color ?>">
                                            <p class="size-12 fw-light">Poin Pasangan <?= $row->show_name ?></p>
                                            <div class="col-6 pe-1 align-self-center">
                                                <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= currency($poin_pasangan->potensi_kiri) ?></p>
                                            </div>
                                            <div class="col-6 ps-1 align-self-center">
                                                <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= currency($poin_pasangan->potensi_kanan) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                        <?php if ($_binary == true) {
                            while ($row = $plan_reward->fetch_object()) {
                                $syarat_ro = $row->syarat_ro;
                                $kondisi = false;
                                if ($syarat_ro == 1) {
                                    $jumlah_poin_ro = $cm->jumlah_poin_ro($session_member_id, $row->id);
                                    if ($jumlah_poin_ro > 0) {
                                        $kondisi = true;
                                    } else {
                                        $kondisi = false;
                                    }
                                } else {
                                    $kondisi = true;
                                }
                                if ($kondisi == true) {
                                    $poin_reward = $cm->jumlah_poin_reward($session_member_id, $row->id);
                                    $reward_kiri = currency($poin_reward->reward_kiri);
                                    $reward_kanan = currency($poin_reward->reward_kanan);
                                    $icon = 'award';
                                } else {
                                    $reward_kiri = 0;
                                    $reward_kanan = 0;
                                    $icon = 'lock';
                                }
                        ?>
                                <div class="swiper-slide text-center">
                                    <div class="col-12">
                                        <div class="avatar avatar-40">
                                            <a href="<?= site_url('riwayat_poin_reward') ?>&plan_reward=<?= base64_encode($row->id) ?>" class="size-32 text-<?= $row->bg_color ?>">
                                                <i class="fa-solid fa-<?= $icon ?>"></i>
                                            </a>
                                        </div>
                                        <div class="row size-11 text-<?= $row->bg_color ?>">
                                            <p class="size-12 fw-light">Poin Reward <?= $row->show_name ?></p>
                                            <?php if ($_binary == true) { ?>
                                                <div class="col-6 pe-1 align-self-center">
                                                    <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= $reward_kiri ?></p>
                                                </div>
                                                <div class="col-6 ps-1 align-self-center">
                                                    <p class="text-center py-1 border-theme border-1 border-dashed rounded-pill"><?= $reward_kanan ?></p>
                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>