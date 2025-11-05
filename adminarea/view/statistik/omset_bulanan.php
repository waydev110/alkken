<?php
    require_once '../model/classKodeAktivasi.php';
    
    $obj = new classKodeAktivasi();
    $omset = $obj->omset_bulanan();
?>
<style>
    h5 {
        margin-bottom: 0px;
    }
</style>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" border="1" bordercolor="#ddd" id="example1">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-left">Bulan</th>
                    <?php
                    $header_omset = $obj->header_omset();
                    while($header = $header_omset->fetch_object()){
                    ?>
                        <th class="text-center"><?=$header->nama_plan?></th>
                    <?php
                    }
                    ?>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $totalNominal = [];
                    while($data = $omset->fetch_object()){
                        $no++;
                    ?>
                    <tr>
                        <td class="text-center"><?=$no?></td>
                        <td class="text-left"><?=bulan_tahun($data->bulan)?></td>
                    <?php
                    $header_omset = $obj->header_omset();
                    while($header = $header_omset->fetch_object()){
                        $kolom = $header->nama_plan;
                        // Jumlahkan setiap nominal ke dalam array totalNominal
                        if (!isset($totalNominal[$kolom])) {
                            $totalNominal[$kolom] = 0; // Inisialisasi jika belum ada
                        }
                        $totalNominal[$kolom] += $data->$kolom; // Tambahkan ke total
                    ?>
                        <td class="text-right"><?=currency($data->$kolom)?></td>
                    <?php
                    }
                    ?>
                        <td class="text-right"><?=currency($data->Total)?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right"><strong>Total</strong></td>
                    <?php
                    // Tampilkan total untuk setiap jenis plan
                    $header_omset = $obj->header_omset();
                    while($header = $header_omset->fetch_object()){
                        $kolom = $header->nama_plan;
                    ?>
                        <td class="text-right text-bold"><?=currency($totalNominal[$kolom] ?? 0)?></td>
                    <?php
                    }
                    ?>
                        <td class="text-right text-bold"><?=currency(array_sum($totalNominal))?></td> <!-- Total keseluruhan -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
