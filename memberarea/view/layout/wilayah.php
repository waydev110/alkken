<script>
    $(document).ready(function () {
        $('#provinsi').on("change keyup", function (e) {
            var id_provinsi = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/wilayah/kota.php',
                data: {
                    id_provinsi: id_provinsi
                },
                success: function (result) {
                    $('#kota').html(result);
                }
            });
        });

        $('#kota').on("change keyup", function (e) {
            var id_kota = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/wilayah/kecamatan.php',
                data: {
                    id_kota: id_kota
                },
                success: function (result) {
                    $('#kecamatan').html(result);
                }
            });
        });

        $('#kecamatan').on("change keyup", function (e) {
            var id_kecamatan = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/wilayah/kelurahan.php',
                data: {
                    id_kecamatan: id_kecamatan
                },
                success: function (result) {
                    $('#kelurahan').html(result);
                }
            });
        });

    });
</script>