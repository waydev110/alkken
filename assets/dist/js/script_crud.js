var dataTable;
function initValidation(rules, messages) {
    var formSubmit = $('#formSubmit');
    var btnSubmit = $('#btnSubmit');
    var textBtn = btnSubmit.html();

    $.validator.addMethod("regex", function (value, element, param) {
        return this.optional(element) || param.test(value);
    }, "Format tidak sesuai.");

    formSubmit.validate({
        rules: rules,
        messages: messages,
        errorPlacement: function (error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                // Cari elemen .select2-container yang terkait dengan select2
                error.insertAfter(element.next('.select2'));
            } else if (element.closest('.input-group').length) {
                error.insertAfter(element.closest('.input-group'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    btnSubmit.on("click", function (e) {
        if (formSubmit.valid()) {
            formSubmit.submit();
        }
        e.preventDefault();
    });

    formSubmit.on("submit", function (e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var formData = new FormData(this);
        var method = formSubmit.attr("method");
        var action = formSubmit.attr("action");
        var redirectUrl = formSubmit.data('redirect-url');

        $.ajax({
            type: method,
            url: action,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                loader_open();
            },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = redirectUrl;
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            complete: function () {
                loader_close(textBtn);
            }
        });
    });
}

function initDatatable(redirectUrl, columnDefs, targetUrl = '') {
    var url = 'list';
    if (targetUrl !== '') {
        url = targetUrl;
    }
    dataTable = $("#dataTable").DataTable({
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

        processing: true,
        serverSide: true,
        ajax: {
            url: `controller/${redirectUrl}/${url}.php`,
            type: "post",
        },
        columnDefs: columnDefs
    });

    $('#btnFilter').on('submit', (event) => {
        event.preventDefault();
        dataTable.ajax.reload();
    });

    $('#btnReset').on('click', (event) => {
        event.preventDefault();
        dataTable.ajax.reload();
    });
}

function initApprove(id, url, e, text = 'menyetujui') {
    Swal.fire({
        title: "Konfirmasi Approve",
        text: `Apakah Anda yakin ingin ${text} data ini?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya, Lakukan!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `controller/${url}/approve.php`,
                type: "POST",
                data: { id: id },
                dataType: 'json',
                beforeSend: function () {
                    loader_open();
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // $(e).attr('disabled', true);
                                // $(e).removeClass('btn-primary btn-danger').addClass('btn-default');
                                $(e).closest('td').html('<span class="text-success">Diapprove</span>');
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
        }
    });
}

function initReject(id, url, e, text = 'menolak') {
    Swal.fire({
        title: "Konfirmasi Reject",
        text: `Apakah Anda yakin ingin ${text} data ini?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya, lakukan!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `controller/${url}/reject.php`,
                type: "POST",
                data: { id: id },
                dataType: 'json',
                beforeSend: function () {
                    loader_open();
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // $(e).attr('disabled', true);
                                // $(e).removeClass('btn-primary btn-danger').addClass('btn-default');
                                $(e).closest('td').html('<span class="text-danger">Direject</span>');
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
        }
    });
}

let imagesToDelete = [];
$(document).ready(function () {
    let imageIndex = $('.image-box').length;
    const fileInput = $('#multi_image');
    const previewContainer = $('#preview-container');
    const imageOrder = $('#image_order');

    $('#upload-area').on('click', function (e) {
        if (e.target.id !== 'multi_image') {
            fileInput.trigger('click');
        }
    });

    $('#upload-area').on('dragover', function (e) {
        e.preventDefault();
        $(this).css('background-color', '#f0f0f0');
    }).on('dragleave drop', function () {
        $(this).css('background-color', 'transparent');
    });

    $('#upload-area').on('drop', function (e) {
        e.preventDefault();
        handleFiles(e.originalEvent.dataTransfer.files);
    });

    fileInput.on('change', function () {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            const currentIndex = imageIndex++;

            reader.onload = function (e) {
                const previewHTML = `
                    <div class="image-box" data-index="${currentIndex}">
                        <img src="${e.target.result}">
                        <button type="button" class="btn btn-sm btn-block btn-danger remove-btn mt-2"><i class="fa fa-times"></i> Hapus</button>
                    </div>
                `;
                // previewContainer.prepend(previewHTML);
                $('#upload-area').before(previewHTML);
                updateOrder();
            };

            reader.readAsDataURL(file);
        });
    }

    previewContainer.on('click', '.remove-btn', function () {
        $(this).closest('.image-box').remove();
        updateOrder();
    });

    function updateOrder() {
        const order = [];
        $('.image-box').each(function () {
            order.push($(this).data('index'));
        });
        imageOrder.val(order.join(','));
    }

    if (typeof Sortable !== 'undefined' && $('#preview-container').length) {
        new Sortable(document.getElementById('preview-container'), {
            animation: 150,
            onSort: updateOrder
        });
    }
});


function removeImage(filename, el) {
    imagesToDelete.push(filename);
    $(el).closest('.image-box').remove();
}
function loader_open(){    
    $('.waiting-wrap').fadeIn();
}

function loader_close(){    
    $('.waiting-wrap').fadeOut('fast');
}