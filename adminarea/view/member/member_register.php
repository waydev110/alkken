<?php 
require_once '../model/classMember.php';
require_once '../model/classKodeAktivasi.php';
require_once '../model/classProvinsi.php';    
require_once '../model/classBank.php';

$cm = new classMember();
$cka = new classKodeAktivasi();
$cprov = new classProvinsi();
$cb = new classBank();

// Get upline and posisi from URL
$id_upline = isset($_GET['upline']) ? base64_decode($_GET['upline']) : null;
$posisi = isset($_GET['posisi']) ? $_GET['posisi'] : null;

if(!$id_upline || !$posisi) {
    echo "<script>alert('Data upline atau posisi tidak valid'); window.location='?go=member_pohon_jaringan';</script>";
    exit;
}

// Get upline data
$data_upline = $cm->detail($id_upline);
if(!$data_upline) {
    echo "<script>alert('Data upline tidak ditemukan'); window.location='?go=member_pohon_jaringan';</script>";
    exit;
}

// Default sponsor adalah upline, tapi bisa diubah
$sponsor_input = isset($_GET['sponsor']) ? $_GET['sponsor'] : null;

// Jika sponsor diinput, cari berdasarkan id_member
if($sponsor_input) {
    $c = new classConnection();
    $sql_find_sponsor = "SELECT id FROM mlm_member WHERE id_member = '$sponsor_input' AND deleted_at IS NULL";
    $find_sponsor = $c->_query($sql_find_sponsor);
    if($find_sponsor && $find_sponsor->num_rows > 0) {
        $sponsor_data = $find_sponsor->fetch_object();
        $sponsor_id = $sponsor_data->id;
    } else {
        echo "<script>alert('ID Member Sponsor tidak ditemukan'); window.location='?go=member_register&upline=".base64_encode($id_upline)."&posisi=$posisi';</script>";
        exit;
    }
} else {
    $sponsor_id = $id_upline;
}

$sponsor = $cm->detail($sponsor_id);

// Validasi: Sponsor harus di upline tree (tidak boleh crossline)
// Cek apakah sponsor ada di path upline
$sql_check_upline = "
    WITH RECURSIVE upline_path AS (
        SELECT id, user_member, upline, 1 as level
        FROM mlm_member 
        WHERE id = '$id_upline'
        
        UNION ALL
        
        SELECT m.id, m.user_member, m.upline, up.level + 1
        FROM mlm_member m
        INNER JOIN upline_path up ON m.id = up.upline
        WHERE m.upline != 'master' AND up.level < 50
    )
    SELECT * FROM upline_path WHERE id = '$sponsor_id'
";
$c = new classConnection();
$check_upline = $c->_query($sql_check_upline);
$is_valid_sponsor = ($sponsor_id == $id_upline) || ($check_upline && $check_upline->num_rows > 0);

if(!$is_valid_sponsor && isset($_GET['sponsor'])) {
    echo "<script>alert('Sponsor tidak valid! Sponsor harus berada di upline tree (tidak boleh crossline)'); window.location='?go=member_register&upline=".base64_encode($id_upline)."&posisi=$posisi';</script>";
    exit;
}

// Get kode aktivasi milik sponsor
$kode_aktivasi = $cka->index_member_new($sponsor_id, 0);
$kode_aktivasi_count = $kode_aktivasi->num_rows;

// Store kode aktivasi to array so we can use it multiple times
$kode_aktivasi_array = [];
if($kode_aktivasi_count > 0) {
    while($row = $kode_aktivasi->fetch_object()) {
        $kode_aktivasi_array[] = $row;
    }
}

$bank = $cb->semua_bank();
$provinsi = $cprov->index();

?>

<style>
    .sponsor-info-box {
        background: #3c8dbc;
        color: white;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 3px;
    }
    .sponsor-info-box h4 {
        margin: 0 0 5px 0;
        font-size: 16px;
    }
    .sponsor-info-box .info-text {
        margin: 0;
        font-size: 13px;
        opacity: 0.9;
    }
    .posisi-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 3px;
        font-weight: 600;
        font-size: 11px;
        background: rgba(255,255,255,0.3);
    }
    .section-header {
        background: #f4f4f4;
        padding: 10px 15px;
        margin: -10px -15px 15px -10px;
        border-bottom: 1px solid #ddd;
        font-weight: 600;
        font-size: 14px;
    }
</style>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-plus"></i> Pendaftaran Member Baru</h3>
        <div class="box-tools pull-right">
            <a href="?go=member_pohon_jaringan&id_member=<?= $data_upline->id_member ?>" class="btn btn-sm btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="box-body">

        <!-- Form Pilih Sponsor -->
        <div class="alert alert-info">
            <h4><i class="fa fa-info-circle"></i> Pilih Sponsor</h4>
            <p style="margin-bottom: 10px;">Sponsor dapat berbeda dengan upline. Sponsor harus berada di jalur upline (tidak boleh crossline).</p>
            <form method="GET" action="" id="formSponsor" style="margin-bottom: 0;">
                <input type="hidden" name="go" value="member_register">
                <input type="hidden" name="upline" value="<?= base64_encode($id_upline) ?>">
                <input type="hidden" name="posisi" value="<?= $posisi ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <label>ID Member Sponsor <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="sponsor" class="form-control" 
                                   value="<?= $sponsor->id_member ?>" 
                                   placeholder="Masukkan ID Member Sponsor" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Cek Sponsor
                                </button>
                            </span>
                        </div>
                        <small class="text-muted">Default: Sponsor sama dengan Upline</small>
                    </div>
                    <div class="col-md-6">
                        <?php if($sponsor_id != $id_upline): ?>
                        <label>&nbsp;</label>
                        <div>
                            <span class="label label-success"><i class="fa fa-check"></i> Sponsor Valid</span>
                            <a href="?go=member_register&upline=<?= base64_encode($id_upline) ?>&posisi=<?= $posisi ?>" 
                               class="btn btn-xs btn-default">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <?php if($kode_aktivasi_count == 0): ?>
        <div class="alert alert-warning">
            <h4><i class="fa fa-warning"></i> Sponsor Tidak Memiliki PIN</h4>
            Sponsor <strong><?= $sponsor->id_member ?> - <?= $sponsor->user_member ?></strong> tidak memiliki kode aktivasi tersedia.
            <br><br>
            <strong>Solusi:</strong>
            <ul style="margin: 10px 0 0 0;">
                <li>Pilih sponsor lain yang memiliki PIN (di jalur upline)</li>
                <li>Atau buat PIN baru untuk sponsor ini: 
                    <a href="?go=kodeaktivasi_create" class="btn btn-xs btn-warning">
                        <i class="fa fa-plus"></i> Buat Kode Aktivasi
                    </a>
                </li>
            </ul>
        </div>
        <?php else: ?>

        <!-- Sponsor & Upline Info -->
        <div class="row">
            <div class="col-md-4">
                <div class="sponsor-info-box">
                    <h4><i class="fa fa-user"></i> Informasi Sponsor</h4>
                    <p class="info-text">
                        <strong><?= $sponsor->id_member ?></strong> - <?= $sponsor->user_member ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sponsor-info-box" style="background: #3c8dbc;">
                    <h4><i class="fa fa-arrow-up"></i> Informasi Upline</h4>
                    <p class="info-text">
                        <strong><?= $data_upline->id_member ?></strong> - <?= $data_upline->user_member ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sponsor-info-box" style="background: #3c8dbc;">
                    <h4><i class="fa fa-map-marker"></i> Posisi Jaringan</h4>
                    <p class="info-text">
                        <span class="posisi-badge">
                            <?= strtoupper($posisi) ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <form action="controller/posting/member_register.php" method="POST" id="formRegister">
            <input type="hidden" name="upline" value="<?= $id_upline ?>">
            <input type="hidden" name="posisi" value="<?= $posisi ?>">
            <input type="hidden" name="sponsor" value="<?= $sponsor_id ?>">

            <!-- Paket Join -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Paket Pendaftaran</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="paket_join">Pilih Paket <span class="text-danger">*</span></label>
                        <select class="form-control" id="paket_join" name="paket_join" required>
                            <option value="">-- Pilih Paket --</option>
                            <?php foreach($kode_aktivasi_array as $row): ?>
                            <option value="<?= $row->jenis_aktivasi ?>">
                                <?= $row->nama_plan ?> (Stok: <?= $row->total ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_kodeaktivasi">Kode Aktivasi <span class="text-danger">*</span></label>
                        <select class="form-control" id="id_kodeaktivasi" name="id_kodeaktivasi" required disabled>
                            <option value="">Pilih paket terlebih dahulu</option>
                        </select>
                        <small class="text-muted">Pilih paket untuk melihat kode aktivasi yang tersedia</small>
                    </div>

                    <div class="form-group">
                        <label for="tipe_akun">Tipe Pendaftaran <span class="text-danger">*</span></label>
                        <select class="form-control" id="tipe_akun" name="tipe_akun" required>
                            <option value="0">Member Baru</option>
                            <option value="1">Tambah Titik (Cloning Data Sponsor)</option>
                        </select>
                        <small class="text-muted">
                            <strong>Member Baru:</strong> Buat member dengan data baru<br>
                            <strong>Tambah Titik:</strong> Duplikasi data dari sponsor (username, password, rekening, dll)
                        </small>
                    </div>
                </div>
            </div>

            <!-- Data Member -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Member</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" required 
                                       placeholder="Username untuk login" pattern="[a-zA-Z0-9_]+"
                                       title="Hanya huruf, angka, dan underscore">
                                <small class="text-muted">Hanya huruf, angka, dan underscore (_)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_member">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_member" name="nama_member" required
                                       placeholder="Nama lengkap sesuai KTP">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hp_member">No. WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="hp_member" name="hp_member" required
                                       placeholder="08xxxxxxxxxx" pattern="[0-9]{10,15}">
                                <small class="text-muted">Contoh: 081234567890</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email_member">Email</label>
                                <input type="email" class="form-control" id="email_member" name="email_member"
                                       placeholder="email@example.com">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                       placeholder="Kota/Kabupaten">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Alamat -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Alamat</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provinsi">Provinsi</label>
                                <select class="form-control select2" id="provinsi" name="provinsi">
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php while($row = $provinsi->fetch_object()): ?>
                                    <option value="<?= $row->id ?>"><?= $row->nama_provinsi ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kota">Kabupaten/Kota</label>
                                <select class="form-control select2" id="kota" name="kota">
                                    <option value="">-- Pilih Kota --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <select class="form-control select2" id="kecamatan" name="kecamatan">
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kelurahan">Kelurahan/Desa</label>
                                <select class="form-control select2" id="kelurahan" name="kelurahan">
                                    <option value="">-- Pilih Kelurahan --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Rekening -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Rekening (Untuk Pencairan Bonus)</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="id_bank">Bank</label>
                                <select class="form-control select2" id="id_bank" name="id_bank">
                                    <option value="">-- Pilih Bank --</option>
                                    <?php while($row = $bank->fetch_object()): ?>
                                    <option value="<?= $row->id ?>"><?= $row->nama_bank ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_rekening">Nomor Rekening</label>
                                <input type="text" class="form-control" id="no_rekening" name="no_rekening"
                                       placeholder="1234567890" pattern="[0-9]+">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="atas_nama_rekening">Atas Nama</label>
                                <input type="text" class="form-control" id="atas_nama_rekening" name="atas_nama_rekening"
                                       placeholder="Nama pemilik rekening">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-md-6">
                    <a href="?go=member_pohon_jaringan&id_member=<?= $data_upline->id_member ?>" class="btn btn-default btn-block btn-md">
                        Batal
                    </a>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-block btn-md" id="btnSubmit">
                        Daftarkan Member
                    </button>
                </div>
            </div>
        </form>

        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2();

    // Handle Tipe Pendaftaran change
    $('#tipe_akun').change(function() {
        var tipe = $(this).val();
        var sponsor_id = <?= $sponsor_id ?>;
        
        if(tipe == '1') {
            // Tambah Titik - load dan populate data sponsor
            $.ajax({
                url: 'controller/posting/get_sponsor_data.php',
                method: 'POST',
                data: { sponsor_id: sponsor_id },
                dataType: 'json',
                success: function(response) {
                    if(response.status) {
                        var data = response.data;
                        
                        // Populate form fields dengan data sponsor
                        $('#username').val(data.new_username).prop('readonly', false).css('background-color', ''); // Username editable
                        $('#nama_member').val(data.nama_member).prop('readonly', true).css('background-color', '#f4f4f4');
                        $('#hp_member').val(data.hp_member).prop('readonly', true).css('background-color', '#f4f4f4');
                        $('#email_member').val(data.email_member).prop('readonly', true).css('background-color', '#f4f4f4');
                        $('#tempat_lahir').val(data.tempat_lahir).prop('readonly', true).css('background-color', '#f4f4f4');
                        $('#tanggal_lahir').val(data.tanggal_lahir).prop('readonly', true).css('background-color', '#f4f4f4');
                        
                        // Rekening
                        $('#no_rekening').val(data.no_rekening).prop('readonly', true).css('background-color', '#f4f4f4');
                        $('#atas_nama_rekening').val(data.atas_nama_rekening).prop('readonly', true).css('background-color', '#f4f4f4');
                        
                        // Bank - set value untuk Select2
                        if(data.id_bank) {
                            $('#id_bank').val(data.id_bank).trigger('change');
                            // Disable setelah value set
                            setTimeout(function() {
                                $('#id_bank').prop('disabled', true);
                            }, 100);
                        }
                        
                        // Load cascade wilayah
                        if(data.id_provinsi) {
                            // Load Kota
                            $.ajax({
                                url: 'controller/wilayah/get_kota.php',
                                method: 'POST',
                                data: { id_provinsi: data.id_provinsi },
                                success: function(kotaHtml) {
                                    $('#kota').html(kotaHtml);
                                    
                                    if(data.id_kota) {
                                        $('#kota').val(data.id_kota);
                                        
                                        // Load Kecamatan
                                        $.ajax({
                                            url: 'controller/wilayah/get_kecamatan.php',
                                            method: 'POST',
                                            data: { id_kota: data.id_kota },
                                            success: function(kecHtml) {
                                                $('#kecamatan').html(kecHtml);
                                                
                                                if(data.id_kecamatan) {
                                                    $('#kecamatan').val(data.id_kecamatan);
                                                    
                                                    // Load Kelurahan
                                                    $.ajax({
                                                        url: 'controller/wilayah/get_kelurahan.php',
                                                        method: 'POST',
                                                        data: { id_kecamatan: data.id_kecamatan },
                                                        success: function(kelHtml) {
                                                            $('#kelurahan').html(kelHtml);
                                                            
                                                            if(data.id_kelurahan) {
                                                                $('#kelurahan').val(data.id_kelurahan);
                                                            }
                                                            
                                                            // Disable semua setelah selesai load
                                                            $('#provinsi, #kota, #kecamatan, #kelurahan').prop('disabled', true);
                                                        }
                                                    });
                                                } else {
                                                    $('#provinsi, #kota, #kecamatan').prop('disabled', true);
                                                }
                                            }
                                        });
                                    } else {
                                        $('#provinsi, #kota').prop('disabled', true);
                                    }
                                }
                            });
                            
                            // Set provinsi value
                            $('#provinsi').val(data.id_provinsi);
                        }
                        
                        // Show info dengan username baru
                        if(!$('#infoCloning').length) {
                            $('<div id="infoCloning" class="alert alert-info" style="margin-top: 15px;">' +
                              '<i class="fa fa-info-circle"></i> <strong>Mode Tambah Titik:</strong> Data akan di-clone dari sponsor. ' +
                              'Username baru: <strong>' + data.new_username + '</strong> (bisa diubah)<br>' +
                              '<small>Username asli sponsor: ' + data.username + ' + nomor urut ' + data.jumlah_akun + '</small>' +
                              '</div>').insertAfter($('#tipe_akun').parent());
                        }
                    } else {
                        alert('Gagal memuat data sponsor: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error: Gagal memuat data sponsor. Silakan coba lagi.');
                }
            });
            
            // Remove required dari field yang akan di-clone
            $('#nama_member, #hp_member').prop('required', false);
        } else {
            // Member Baru - reset semua field
            $('#username, #nama_member, #hp_member, #email_member, #tempat_lahir, #tanggal_lahir').val('').prop('readonly', false).prop('required', true).css('background-color', '');
            $('#no_rekening, #atas_nama_rekening').val('').prop('readonly', false).css('background-color', '');
            $('#id_bank, #provinsi, #kota, #kecamatan, #kelurahan').val('').trigger('change').prop('disabled', false);
            
            // Reset dropdown ke default
            $('#kota').html('<option value="">-- Pilih Kota --</option>');
            $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
            $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
            
            // Remove info
            $('#infoCloning').remove();
        }
    });

    // Load Kode Aktivasi based on Paket
    $('#paket_join').change(function() {
        var paket_id = $(this).val();
        var sponsor_id = <?= $sponsor_id ?>;
        
        $('#id_kodeaktivasi').html('<option value="">-- Loading... --</option>').prop('disabled', true);
        
        if(paket_id) {
            $.ajax({
                url: 'controller/posting/get_kode_aktivasi.php',
                method: 'POST',
                data: {
                    sponsor_id: sponsor_id,
                    paket_id: paket_id
                },
                success: function(response) {
                    $('#id_kodeaktivasi').html(response).prop('disabled', false);
                },
                error: function() {
                    $('#id_kodeaktivasi').html('<option value="">Error loading data</option>').prop('disabled', true);
                }
            });
        } else {
            $('#id_kodeaktivasi').html('<option value="">Pilih paket terlebih dahulu</option>').prop('disabled', true);
        }
    });

    // Load Kota based on Provinsi
    $('#provinsi').change(function() {
        var id_provinsi = $(this).val();
        $('#kota').html('<option value="">-- Loading... --</option>');
        $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
        $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
        
        if(id_provinsi) {
            $.ajax({
                url: 'controller/wilayah/get_kota.php',
                method: 'POST',
                data: {id_provinsi: id_provinsi},
                success: function(response) {
                    $('#kota').html(response);
                }
            });
        } else {
            $('#kota').html('<option value="">-- Pilih Kota --</option>');
        }
    });

    // Load Kecamatan based on Kota
    $('#kota').change(function() {
        var id_kota = $(this).val();
        $('#kecamatan').html('<option value="">-- Loading... --</option>');
        $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
        
        if(id_kota) {
            $.ajax({
                url: 'controller/wilayah/get_kecamatan.php',
                method: 'POST',
                data: {id_kota: id_kota},
                success: function(response) {
                    $('#kecamatan').html(response);
                }
            });
        } else {
            $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
        }
    });

    // Load Kelurahan based on Kecamatan
    $('#kecamatan').change(function() {
        var id_kecamatan = $(this).val();
        $('#kelurahan').html('<option value="">-- Loading... --</option>');
        
        if(id_kecamatan) {
            $.ajax({
                url: 'controller/wilayah/get_kelurahan.php',
                method: 'POST',
                data: {id_kecamatan: id_kecamatan},
                success: function(response) {
                    $('#kelurahan').html(response);
                }
            });
        } else {
            $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
        }
    });

    // Form submission with AJAX
    $('#formRegister').submit(function(e) {
        e.preventDefault();
        
        var $btn = $('#btnSubmit');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Proses Pendaftaran...');
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status) {
                    // Show success modal
                    $('#successModal').modal('show');
                    $('#successMessage').html(response.message);
                } else {
                    // Show error alert
                    var errorHtml = '<div class="alert alert-danger alert-dismissible" style="margin-top: 15px;">' +
                                   '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                   '<h4><i class="icon fa fa-ban"></i> Gagal!</h4>' +
                                   response.message +
                                   '</div>';
                    $('#formRegister').prepend(errorHtml);
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    $btn.prop('disabled', false).html('Daftarkan Member');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log('Response:', xhr.responseText);
                
                var errorHtml = '<div class="alert alert-danger alert-dismissible" style="margin-top: 15px;">' +
                               '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                               '<h4><i class="icon fa fa-ban"></i> Error!</h4>' +
                               'Terjadi kesalahan sistem. Silakan coba lagi.' +
                               '</div>';
                $('#formRegister').prepend(errorHtml);
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                $btn.prop('disabled', false).html('Daftarkan Member');
            }
        });
    });

    // Auto-fill nama rekening
    $('#nama_member').blur(function() {
        if($('#atas_nama_rekening').val() == '') {
            $('#atas_nama_rekening').val($(this).val());
        }
    });
});
</script>

<!-- Success Modal -->
<div class="modal modal-success fade" id="successModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="icon fa fa-check"></i> Pendaftaran Berhasil!
                </h4>
            </div>
            <div class="modal-body">
                <div id="successMessage" style="font-size: 15px;"></div>
            </div>
            <div class="modal-footer">
                <a href="?go=member_pohon_jaringan&id_member=<?= $data_upline->id_member ?>" class="btn btn-outline">
                    <i class="fa fa-sitemap"></i> Kembali ke Pohon Jaringan
                </a>
                <a href="?go=member_list" class="btn btn-outline">
                    <i class="fa fa-list"></i> Lihat Daftar Member
                </a>
            </div>
        </div>
    </div>
</div>