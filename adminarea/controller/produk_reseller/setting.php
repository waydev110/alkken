<?php
    $url = 'produk_reseller';
    $table = 'mlm_produk';
    $dir_img = 'produk';
    $arr_field = [
        // [
        //     'column' => '',
        //     'type' => 'hidden',
        //     'input' => 'previous_image',
        //     'label' => 'Gambar Sebelumnya',
        //     'placeholder' => '',
        //     'from_column' => 'gambar',
        // ],
        // [
        //     'column' => 'gambar',
        //     'type' => 'image',
        //     'input' => 'file',
        //     'label' => 'Gambar Produk',
        //     'placeholder' => '',
        //     'from_column' => 'nama_produk',
        // ],
        [
            'column' => 'id_produk_jenis',
            'type' => 'number',
            'input' => 'select',
            'label' => 'Jenis Produk',
            'placeholder' => '-- Pilih Jenis Produk --',
            'option' => []
        ],
        [
            'column' => 'multi_image',
            'type' => 'multi_image',
            'input' => 'multi_image',
            'label' => 'Gambar Produk',
            'placeholder' => '',
            'from_column' => 'nama_produk',
        ],
        [
            'column' => 'nama_produk',
            'type' => 'varchar',
            'input' => 'text',
            'label' => 'Nama Produk',
            'placeholder' => 'Masukan Nama Produk',
        ],
        [
            'column' => 'slug',
            'type' => 'slug',
            'input' => '',
            'label' => '',
            'placeholder' => '',
            'from_column' => 'nama_produk',
        ],
        [
            'column' => 'hpp',
            'type' => 'number',
            'input' => 'currency',
            'label' => 'HPP',
            'placeholder' => 'Masukan HPP',
        ],
        [
            'column' => 'harga',
            'type' => 'number',
            'input' => 'currency',
            'label' => 'Harga',
            'placeholder' => 'Masukan Harga',
        ],
        [
            'column' => 'nilai_produk',
            'type' => 'number',
            'input' => 'decimal',
            'label' => 'Nilai Produk',
            'placeholder' => 'Masukan Nilai Produk',
        ],
        [
            'column' => 'poin_pasangan',
            'type' => 'number',
            'input' => 'decimal',
            'label' => 'Poin Pasangan',
            'placeholder' => 'Masukan Poin Pasangan',
        ],
        [
            'column' => 'poin_reward',
            'type' => 'number',
            'input' => 'decimal',
            'label' => 'Poin Reward',
            'placeholder' => 'Masukan Poin Reward',
        ],
        [
            'column' => 'bonus_sponsor',
            'type' => 'number',
            'input' => 'currency',
            'label' => 'Bonus Sponsor',
            'placeholder' => 'Masukan Bonus Sponsor',
        ],
        [
            'column' => 'bonus_cashback',
            'type' => 'number',
            'input' => 'currency',
            'label' => 'Bonus Cashback',
            'placeholder' => 'Masukan Bonus Cashback',
        ],
        [
            'column' => 'bonus_generasi',
            'type' => 'number',
            'input' => 'currency',
            'label' => 'Bonus Generasi',
            'placeholder' => 'Masukan Bonus Generasi',
        ],
        [
            'column' => 'bonus_upline',
            'type' => 'number',
            'input' => 'currency',
            'label' => 'Bonus Titik',
            'placeholder' => 'Masukan Bonus Titik',
        ],
        [
            'column' => 'fee_stokis',
            'type' => 'number',
            'input' => 'currency',
            'label' => 'Fee Stokis',
            'placeholder' => 'Masukan Fee Stokis',
        ],
        // [
        //     'column' => 'fee_founder',
        //     'type' => 'number',
        //     'input' => 'currency',
        //     'label' => 'Fee Founder',
        //     'placeholder' => 'Masukan Fee Founder',
        // ],
        // [
        //     'column' => 'poin_badge',
        //     'type' => 'number',
        //     'input' => 'decimal',
        //     'label' => 'Poin Reward Pribadi',
        //     'placeholder' => 'Masukan Poin Reward Pribadi',
        // ],
        // [
        //     'column' => 'poin_pasangan',
        //     'type' => 'number',
        //     'input' => 'decimal',
        //     'label' => 'Poin Pasangan',
        //     'placeholder' => 'Masukan Poin Pasangan',
        // ],
        // [
        //     'column' => 'poin_belanja',
        //     'type' => 'number',
        //     'input' => 'decimal',
        //     'label' => 'Poin Belanja',
        //     'placeholder' => 'Masukan Poin Belanja',
        // ],
        // [
        //     'column' => 'poin_redeem',
        //     'type' => 'number',
        //     'input' => 'decimal',
        //     'label' => 'Poin Redeem',
        //     'placeholder' => 'Masukan Poin Redeem',
        // ],
        [
            'column' => 'qty',
            'type' => 'number',
            'input' => 'decimal',
            'label' => 'Qty',
            'placeholder' => 'Masukan Qty',
        ],
        [
            'column' => 'satuan',
            'type' => 'varchar',
            'input' => 'select',
            'label' => 'Satuan',
            'placeholder' => '-- Pilih Satuan --',
            'option' => []
        ],
        [
            'column' => 'keterangan',
            'type' => 'text',
            'input' => 'textarea',
            'label' => 'Deskripsi',
            'placeholder' => 'Masukan Deskripsi Produk',
        ],
        [
            'column' => 'tampilkan',
            'type' => 'number',
            'input' => 'select',
            'label' => 'Tampilkan',
            'placeholder' => '-- Pilih Status --',
            'option' => [
                [
                    'label' => 'Ya',
                    'value' => '1'
                ],
                [
                    'label' => 'Tidak',
                    'value' => '0'
                ]
            ]
        ],
        // [
        //     'column' => 'bisa_dijual',
        //     'type' => 'number',
        //     'input' => 'select',
        //     'label' => 'Bisa Dijual',
        //     'placeholder' => '-- Pilih Bisa Dijual --',
        //     'option' => [
        //         [
        //             'label' => 'Aktif',
        //             'value' => '1'
        //         ],
        //         [
        //             'label' => 'Tidak Aktif',
        //             'value' => '0'
        //         ]
        //     ]
        // ],
        // [
        //     'column' => 'status',
        //     'type' => 'number',
        //     'input' => 'select',
        //     'label' => 'Status',
        //     'placeholder' => '-- Pilih Status --',
        //     'option' => [
        //         [
        //             'label' => 'Aktif',
        //             'value' => '1'
        //         ],
        //         [
        //             'label' => 'Tidak Aktif',
        //             'value' => '0'
        //         ]
        //     ]
        // ]
        [
            'column' => 'produk_plan',
            'type' => 'multi_checkbox',
            'input' => 'checkbox',
            'label' => 'Plan Produk',
            'placeholder' => '-- Pilih Plan Produk --',
            'option' => []
        ],
    ];    
?>