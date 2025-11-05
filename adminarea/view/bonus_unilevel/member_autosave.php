<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar <?= $title ?></h3>
    </div>
    <div class="box-body">
        <div class="row mb-4">
            <label for="" class="control-label col-sm-2 text-right align-self-center">Member Max Autosave</label>
            <div class="col-sm-2">
                <select class="form-control" name="tutup_poin" id="tutup_poin">
                    <option value="">Semua</option>
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
            <label for="" class="control-label col-sm-1 text-right align-self-center">Tanggal</label>
            <div class="col-sm-5">
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date" id="start_date" value="<?= date('Y-m', strtotime('-1 month')) ?>-01">
                    <span class="input-group-addon">s/d</span>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                </div>
            </div>
            <div class="col-sm-2 text-right">
                <div class="input-group">
                    <div class="input-group-btn">
                        <!-- <div class="btn-group" id="btn-group"> -->
                        <button type="button" class="btn btn-primary" id="btnFilter">
                            <i class="fa fa-search"></i>
                            Filter</button>
                        <button type="reset" class="btn btn-primary" id="btnReset">Clear</button>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="dataTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Bulan</th>
                    <th class="text-center">ID <?= $lang['member'] ?></th>
                    <th class="text-center">Nama <?= $lang['member'] ?></th>
                    <th class="text-center">Paket</th>
                    <th class="text-center">Max Autosave</th>
                    <th class="text-center">Total Potongan</th>
                    <th class="text-center">Total Tupo</th>
                    <th class="text-center">Total Autosave</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade bs-example-modal-md" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header border-none">
                <h3 class="modal-title">Input Saldo</h3>
            </div>
            <div class="modal-body text-center">
                <form class="form-horizontal" id="frmFixSaldo" method="post" action="controller/bonus_unilevel/fix_saldo.php">
                <input type="hidden" id="member_id" name="member_id">
                <input type="hidden" id="bulan" name="bulan">
                    <div class="form-group row">
                        <label for="nominal_tupo" class="control-label col-sm-4">ID <?=$lang['member']?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="id_member" name="id_member" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nominal_tupo" class="control-label col-sm-4">Nama <?=$lang['member']?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama_member" name="nama_member" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="saldo_masuk" class="control-label col-sm-4">Saldo Masuk</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control autonumeric3" name="saldo_masuk" id="saldo_masuk">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="saldo_keluar" class="control-label col-sm-4">Saldo Keluar</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control autonumeric3" name="saldo_keluar" id="saldo_keluar">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">Close</span></button>
                <button type="button" id="btnSubmit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mod_url = '<?= $mod_url ?>';
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function() {
        dataTable = $("#dataTable").DataTable({
            sDom: "<'row'<'col-sm-6'l><'col-sm-6'<'d-flex justify-content-end'fB>>><'table-responsive't><'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        orthogonal: 'export'
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        orthogonal: 'export'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        orthogonal: 'export'
                    }
                }
            ],
            aLengthMenu: [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 10,
            AutoWidth: true,
            processing: true,
            serverSide: true,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: `controller/${mod_url}/member_autosave.php`,
                type: "post",
                data: function(d) {
                    d.tutup_poin = $('#tutup_poin').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
            },
            columnDefs: [{
                targets: [0, 1, 2, 4, -1],
                className: 'text-center'
            }, {
                targets: [5,6,7,8],
                className: 'text-right'
            }]
        });
        $('#btnFilter').click(function() {
            dataTable.ajax.reload();
        });
        $('#btnReset').click(function() {
            // Mengatur tanggal hari ini
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = today.getMonth(); // Bulan dimulai dari 0, jadi tidak perlu tambah 1
            var yyyy = today.getFullYear();

            // Jika bulan adalah Januari (0), mundurkan ke Desember tahun sebelumnya
            if (mm === 0) {
                mm = 11; // Desember
                yyyy -= 1; // Mundurkan tahun
            } else {
                mm -= 1; // Mundurkan satu bulan
            }

            // Format bulan agar dua digit
            mm = String(mm + 1).padStart(2, '0'); // Tambahkan 1 karena `getMonth()` dimulai dari 0

            // Format tanggal menjadi YYYY-MM-DD
            var formattedToday = yyyy + '-' + mm + '-01';
            console.log(formattedToday);

            // Mengatur nilai input
            $('#start_date').val(formattedToday);
            $('#end_date').val(''); // Tetap kosong untuk end_date

            // Reload dataTable
            dataTable.ajax.reload();
        });
        $('#btnSubmit').click(function() {
            dataTable.ajax.reload();
        });
        $('#btnSubmit').click(function() {
            $('#frmFixSaldo').submit();
        });

        $('#frmFixSaldo').on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    const obj = JSON.parse(result);
                    alert(obj.message);
                    if (obj.status == true) {
                        dataTable.ajax.reload();
                    }
                    modalDetail.modal('hide');
                }
            });
            e.preventDefault();
        });
    });

    function create($member_id, $id_member, $nama_member, $bulan, $kekurangan, e){
        $('#member_id').val($member_id);
        $('#bulan').val($bulan);
        $('#id_member').val($id_member);
        $('#nama_member').val($nama_member);
        $('#saldo_masuk').val($kekurangan).trigger('keyup');
        $('#saldo_keluar').val($kekurangan).trigger('keyup');
        modalDetail.modal('show');
    }
</script>