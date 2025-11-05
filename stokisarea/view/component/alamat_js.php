<script>
    $(document).ready(function () {
        $('#id_provinsi').on("change keyup", function (e) {
            var id_provinsi = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/alamat/kota.php',
                data: {
                    id_provinsi: id_provinsi
                },
                success: function (result) {
                    $('#id_kota').html(result);
                }
            });
        });

        $('#id_kota').on("change keyup", function (e) {
            var id_kota = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/alamat/kecamatan.php',
                data: {
                    id_kota: id_kota
                },
                success: function (result) {
                    $('#id_kecamatan').html(result);
                }
            });
        });

        $('#id_kecamatan').on("change keyup", function (e) {
            var id_kecamatan = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/alamat/kelurahan.php',
                data: {
                    id_kecamatan: id_kecamatan
                },
                success: function (result) {
                    $('#id_kelurahan').html(result);
                }
            });
        });

    });
</script>