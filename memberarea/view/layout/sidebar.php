<div class="sidebar-wrap sidebar-pushcontent">
    <!-- <div class="sidebar-wrap"> -->
    <!-- Add overlay or fullmenu instead overlay -->
    <div class="closemenu text-muted">Close Menu</div>
    <div class="sidebar" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
        <!-- user information -->
        <div class="row my-3">
            <div class="col-12 ">
                <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%); border: 1px solid rgba(212, 175, 55, 0.3) !important;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                                <p class="paket-name size-14 mb-2" style="color: #d4af37; font-weight: 600;">Member <?= $member->nama_plan ?></p>
                                <p class="size-14 mb-0 text-white"><?= $session_id_member ?></p>
                                <p class="size-12" style="color: #d4af37;"><?= strtoupper($session_nama_samaran) ?></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 align-self-center">
                                <p class="mb-1 size-13" style="color: #d4af37;">Ganti Akun</p>
                                <select class="form-control size-13 select2 rounded-2" name="daftar_akun" id="daftar_akun" style="background-color: #1a1a1a; color: #d4af37; border: 1px solid #d4af37;">
                                    <?php
                                    if(isset($_group_akun)){
                                        foreach ($_group_akun as $key => $akun) {
                                        ?>
                                            <option value="<?= $akun['id_member'] ?>" <?= $akun['id_member'] == $session_id_member ? 'selected="selected"' : '' ?>><?= $akun['id_member'] ?> <?= $akun['nama_samaran'] ?></option>
                                        <?php
                                        }
                                    }                                        
                                    ?>
                                </select>
                                <!-- <p class="text-muted size-12"><?= $session_id_member ?></p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- user menu navigation -->
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php" style="background: linear-gradient(90deg, #d4af37 0%, #f4e5a1 100%); color: #1a1a1a !important; font-weight: 600;">
                            <div class="avatar avatar-35 rounded icon"><i class="fa-solid fa-home"></i></div>
                            <div class="col">Dashboard</div>
                        </a>
                    </li>
                    <?php
                    require_once '../model/classMenu.php';
                    $cmenu = new classMenu();
                    $kategori_menu = $cmenu->kategori_menu();
                    if ($kategori_menu->num_rows > 0) {
                        while ($_menu_kategori = $kategori_menu->fetch_object()) {
                            $menus = $cmenu->menu_by_kategori($_menu_kategori->id, $show_modul);
                            if ($menus->num_rows > 0) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: #d4af37;">
                            <div class="avatar avatar-35 rounded icon" style="background-color: rgba(212, 175, 55, 0.2);"><i class="fa-solid fa-<?=$_menu_kategori->icon?>" style="color: #d4af37;"></i></div>
                            <div class="col"><?=$_menu_kategori->kategori?></div>
                            <div class="col-auto align-self-center arrow"><i class="fa-solid fa-plus plus"></i> <i class="fa-solid fa-dash minus"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu" style="background-color: #2d2d2d; border: 1px solid #d4af37;">
                            <?php
                            while ($_menu_sub = $menus->fetch_object()) {
                                require_once '../model/classMember.php';
                                $cm = new classMember();
                                $member_akun = $cm->detail($session_member_id);
                            ?>
                            <li><a class="dropdown-item nav-link" href="<?= site_url($_menu_sub->url) ?>" style="color: #d4af37;">
                                   <div class="avatar avatar-35 rounded icon size-12" style="background-color: rgba(212, 175, 55, 0.2);"><i class="fas fa-dot-circle" style="color: #d4af37;"></i></div>
                                   <div class="col"><?=$_menu_sub->name?></div>
                               </a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                            }
                        }
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php" tabindex="-1" style="color: #d4af37;">
                            <div class="avatar avatar-35 rounded icon" style="background-color: rgba(212, 175, 55, 0.2);"><i class="fa-solid fa-sign-out" style="color: #d4af37;"></i></div>
                            <div class="col">Logout</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
