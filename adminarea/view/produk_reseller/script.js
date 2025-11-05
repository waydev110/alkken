
$(document).ready(function () {
    validationRules = {
        gambar: {
            required: true
        },
        nama_produk: {
            required: true
        },
        harga: {
            required: true
        },
        tampilkan: {
            required: true
        },
        plan_produk: {
            required: true
        }
    },
    validationMessages = {
        gambar: {
            required: "Gambar tidak boleh kosong."
        },
        nama_produk: {
            required: "Nama Produk tidak boleh kosong."
        },
        harga: {
            required: "Harga tidak boleh kosong."
        },
        tampilkan: {
            required: "Tampilkan tidak boleh kosong."
        },
        plan_produk: {
            required: "Plan Produk tidak boleh kosong."
        }
    }

    initValidation(validationRules, validationMessages);
});