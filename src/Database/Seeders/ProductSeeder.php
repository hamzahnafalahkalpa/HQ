<?php

namespace Projects\Hq\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Hanafalah\LaravelPermission\Facades\LaravelPermission;
use Hanafalah\LaravelSupport\Concerns\Support\HasRequest;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use HasRequest;

    protected array $__products = [
        [
            'label' => 'LITE', 
            'name' => 'Wellmed Lite', 
            'ordering' => 1,
            'price' => 1250000,
            'discount' => 60, // in percent
            'notes' => [
                'Cocok untuk klinik kecil dan praktik perorangan.',
                'Fitur dasar untuk manajemen pasien dan rekam medis elektronik.',
                'Terinstall tiga (3) pengguna secara default.',
                'Hanya untuk satu (1) poliklinik/departemen.',
            ],
            'product_items' => [
                [
                    'name' => 'Dashboard',
                    'master_product_item' => [
                        'name' => 'Dashboard',
                        'label' => 'Dashboard',
                    ],
                    'note' => null,
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Rekam Medis Elektronik',
                    'master_product_item' => [
                        'name' => 'Rekam Medis Elektronik',
                        'label' => 'EMR',
                    ],
                    'note' => null,
                    'price' => 150000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Pemeriksaan',
                    'master_product_item' => [
                        'name' => 'Pemeriksaan',
                        'label' => 'Consultation',
                    ],
                    'note' => null,
                    'price' => 150000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Laporan',
                    'master_product_item' => [
                        'name' => 'Laporan',
                        'label' => 'Report',
                    ],
                    'note' => null,
                    'price' => 100000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Integrasi Satu Sehat',
                    'master_product_item' => [
                        'name' => 'Integrasi Satu Sehat',
                        'label' => 'SatuSehat',
                    ],
                    'note' => null,
                    'price' => 250000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Kasir',
                    'master_product_item' => [
                        'name' => 'Kasir',
                        'label' => 'Cashier',
                    ],
                    'note' => null,
                    'price' => 100000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Jumlah Pengguna',
                    'master_product_item' => [
                        'name' => 'Jumlah Pengguna',
                        'label' => 'User',
                    ],
                    'note' => 'Max 3 Pengguna',
                    'price' => 300000,
                    'discount' => 0,
                    'value' => 3,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Poli Klinik',
                    'master_product_item' => [
                        'name' => 'Poli Klinik',
                        'label' => 'MedicService',
                    ],
                    'note' => null,
                    'price' => 300000,
                    'discount' => 0,
                    'dynamic_forms' => [
                        [
                            'label'          => 'Nama Poli',
                            'key'            => 'medic_service_id',
                            'type'           => 'Select',
                            'component_name' => 'MedicService',
                            'default_value'  => null,
                            'attribute'      => [
                                'max' => 1
                            ],
                            'rule'           => null,
                            'options'        => [],
                            'value'          => null
                        ]
                    ]
                ]                
            ],
            'additional_items' => [
                [
                    'name' => 'Penambahan Pengguna',
                    'label' => 'User',
                    'master_product_item' => [
                        'name' => 'Add on User',
                        'label' => 'Add on User',
                    ],
                    'price' => 100000,
                    'discount' => 0,
                    'dynamic_forms' => [
                        [
                            'label'          => 'Jumlah Pengguna',
                            'key'            => 'user_count',
                            'type'           => 'InputNumber',
                            'component_name' => 'UserCount',
                            'default_value'  => null,
                            'attribute'      => [],
                            'rule'           => null,
                            'options'        => [],
                            'value'          => null
                        ]
                    ]
                ],
                [
                    'name' => 'Penambahan Formulir',
                    'label' => 'Form',
                    'master_product_item' => [
                        'name' => 'Add on Form',
                        'label' => 'Add on Form',
                    ],
                    'price' => 1500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Penambahan Laporan',
                    'label' => 'Report',
                    'master_product_item' => [
                        'name' => 'Add on Report',
                        'label' => 'Add on Report',
                    ],
                    'price' => 1500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ]
            ]
        ],
        [
            'label' => 'PLUS', 
            'name' => 'Wellmed Plus', 
            'ordering' => 2,
            'price' => 4100000,
            'discount' => 55, // bundle price 1.850.000
            'notes' => [
                'Cocok untuk klinik menengah dengan kebutuhan integrasi dan AI.',
                'Termasuk 8 pengguna dan 2 poliklinik secara default.',
                'Mendukung integrasi BPJS, laboratorium, dan radiologi.',
                'Termasuk AI patient recap hingga 500 pasien per bulan.'
            ],
            'product_items' => [
                [
                    'name' => 'Dashboard',
                    'master_product_item' => [
                        'name' => 'Dashboard',
                        'label' => 'Dashboard',
                    ],
                    'note' => null,
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Rekam Medis Elektronik',
                    'master_product_item' => [
                        'name' => 'Rekam Medis Elektronik',
                        'label' => 'EMR',
                    ],
                    'note' => 'Recap per visit + full export in PDF',
                    'price' => 400000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Pemeriksaan',
                    'master_product_item' => [
                        'name' => 'Pemeriksaan',
                        'label' => 'Consultation',
                    ],
                    'note' => 'Include 500 patient recap (AI) / bulan',
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Laporan',
                    'master_product_item' => [
                        'name' => 'Laporan',
                        'label' => 'Reporting',
                    ],
                    'note' => 'Medium (~20 laporan)',
                    'price' => 200000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Integrasi Satu Sehat',
                    'master_product_item' => [
                        'name' => 'Integrasi Satu Sehat',
                        'label' => 'SatuSehat Integration',
                    ],
                    'note' => null,
                    'price' => 250000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Integrasi BPJS',
                    'master_product_item' => [
                        'name' => 'Integrasi BPJS',
                        'label' => 'BPJS Integration',
                    ],
                    'note' => null,
                    'price' => 250000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Laboratorium',
                    'master_product_item' => [
                        'name' => 'Laboratorium',
                        'label' => 'Laboratorium',
                    ],
                    'note' => 'Document repository dan koneksi ke EMR',
                    'price' => 300000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Radiologi',
                    'master_product_item' => [
                        'name' => 'Radiologi',
                        'label' => 'Radiologi',
                    ],
                    'note' => 'Document repository dan koneksi ke EMR',
                    'price' => 300000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Apotek',
                    'master_product_item' => [
                        'name' => 'Apotek',
                        'label' => 'Pharmacy',
                    ],
                    'note' => 'Dispense dan link ke kasir',
                    'price' => 400000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Reservasi / Kalendar',
                    'master_product_item' => [
                        'name' => 'Reservasi / Kalendar',
                        'label' => 'Reservation / Calendar',
                    ],
                    'note' => null,
                    'price' => 100000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Poli Klinik',
                    'master_product_item' => [
                        'name' => 'Poli Klinik',
                        'label' => 'MedicService',
                    ],
                    'note' => null,
                    'price' => 300000,
                    'discount' => 0,
                    'dynamic_forms' => [
                        [
                            'label'          => 'Nama Poli',
                            'key'            => 'medic_service_id',
                            'type'           => 'MultiSelect',
                            'component_name' => 'MedicService',
                            'default_value'  => null,
                            'attribute'      => [
                                'max' => 2
                            ],
                            'rule'           => null,
                            'options'        => [],
                            'value'          => []
                        ]
                    ]
                ],
                [
                    'name' => 'Jumlah Pengguna',
                    'master_product_item' => [
                        'name' => 'Jumlah Pengguna',
                        'label' => 'Users Included',
                    ],
                    'note' => 'Max 8 pengguna',
                    'price' => 1200000,
                    'discount' => 0,
                    'value' => 8,
                    'dynamic_forms' => []
                ]
            ],
            'additional_items' => [
                [
                    'name' => 'Penambahan Poli',
                    'label' => 'MedicService',
                    'master_product_item' => [
                        'name' => 'Add on Poli',
                        'label' => 'AdditionalMedicService',
                    ],
                    'price' => 300000,
                    'discount' => 0,
                    'dynamic_forms' => [
                        [
                            'label'          => 'Nama Poli',
                            'key'            => 'medic_service_id',
                            'type'           => 'MultiSelect',
                            'component_name' => 'MedicService',
                            'default_value'  => null,
                            'attribute'      => null,
                            'rule'           => null,
                            'options'        => [],
                            'value'          => []
                        ]
                    ]
                ],
                [
                    'name' => 'Add on Patient Recap',
                    'label' => 'PatientRecap',
                    'master_product_item' => [
                        'name' => 'Add on Patient Recap',
                        'label' => 'Add on 1000 Patients (AI)',
                    ],
                    'price' => 200000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Add on User',
                    'label' => 'User',
                    'master_product_item' => [
                        'name' => 'Add on User',
                        'label' => 'Add on User',
                    ],
                    'price' => 150000,
                    'discount' => 0,
                    'dynamic_forms' => [
                        [
                            'label'          => 'Jumlah Pengguna',
                            'key'            => 'user_count',
                            'type'           => 'InputNumber',
                            'component_name' => 'UserCount',
                            'default_value'  => null,
                            'attribute'      => [],
                            'rule'           => null,
                            'options'        => [],
                            'value'          => null
                        ]
                    ]
                ],
                [
                    'name' => 'Add on Integrations',
                    'label' => 'Integration',
                    'master_product_item' => [
                        'name' => 'Add on Integrations',
                        'label' => 'Integrations (Selected)',
                    ],
                    'price' => 1200000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Integration Config (One Time)',
                    'label' => 'Integration',
                    'master_product_item' => [
                        'name' => 'Integration Config',
                        'label' => 'Integration Setup',
                    ],
                    'price' => 6000000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Add on Skrining (One Time)',
                    'label' => 'Screening',
                    'master_product_item' => [
                        'name' => 'Add on Skrining',
                        'label' => 'Custom Screening Form',
                    ],
                    'price' => 1500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Add on Report (One Time)',
                    'label' => 'Report',
                    'master_product_item' => [
                        'name' => 'Add on Report',
                        'label' => 'Custom Report',
                    ],
                    'price' => 1500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ]
            ]
        ],
        [
            'label' => 'E',
            'name' => 'Wellmed E',
            'ordering' => 3,
            'price' => 15400000,
            'discount' => 42, // bundle price 9.000.000
            'notes' => [
                'Paket lengkap untuk klinik besar atau rumah sakit kecil.',
                'Termasuk integrasi LIS, PACS, dan modul lanjutan.',
                'Cocok untuk layanan multi-poli, rawat inap, dan IGD.',
                'Mendukung 30 pengguna dan 2 spesialisasi secara default.'
            ],
            'product_items' => [
                [
                    'name' => 'Dashboard',
                    'master_product_item' => [
                        'name' => 'Dashboard',
                        'label' => 'Dashboard',
                    ],
                    'note' => null,
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Rekam Medis Elektronik',
                    'master_product_item' => [
                        'name' => 'Rekam Medis Elektronik',
                        'label' => 'EMR',
                    ],
                    'note' => 'Recap per visit + full export in PDF',
                    'price' => 500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Pemeriksaan',
                    'master_product_item' => [
                        'name' => 'Pemeriksaan',
                        'label' => 'Consultation',
                    ],
                    'note' => 'Include 100 patient recap (AI) / bulan',
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Laporan',
                    'master_product_item' => [
                        'name' => 'Laporan',
                        'label' => 'Reporting',
                    ],
                    // 'note' => 'Medium (~20 laporan)',
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Integrasi Satu Sehat',
                    'master_product_item' => [
                        'name' => 'Integrasi Satu Sehat',
                        'label' => 'SatuSehat Integration',
                    ],
                    'note' => null,
                    'price' => 250000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Integrasi BPJS',
                    'master_product_item' => [
                        'name' => 'Integrasi BPJS',
                        'label' => 'BPJS Integration',
                    ],
                    'note' => null,
                    'price' => 250000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Laboratorium',
                    'master_product_item' => [
                        'name' => 'Laboratorium',
                        'label' => 'Laboratorium',
                    ],
                    'note' => 'Document repository dan koneksi ke EMR',
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Radiologi',
                    'master_product_item' => [
                        'name' => 'Radiologi',
                        'label' => 'Radiologi',
                    ],
                    'note' => 'Document repository dan koneksi ke EMR',
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Apotek',
                    'master_product_item' => [
                        'name' => 'Apotek',
                        'label' => 'Pharmacy',
                    ],
                    'note' => 'Dispense dan link ke kasir',
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Kasir',
                    'master_product_item' => [
                        'name' => 'Kasir',
                        'label' => 'Cashier',
                    ],
                    'note' => null,
                    'price' => 0,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Reservasi / Kalendar',
                    'master_product_item' => [
                        'name' => 'Reservasi / Kalendar',
                        'label' => 'Reservation / Calendar',
                    ],
                    'note' => 'Kyoo + kalendar dan antrian',
                    'price' => 100000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Poli Klinik',
                    'master_product_item' => [
                        'name' => 'Poli Klinik',
                        'label' => 'MedicService',
                    ],
                    'price' => 300000,
                    'discount' => 0,
                    'dynamic_forms' => [
                        [
                            'label'          => 'Nama Poli',
                            'key'            => 'medic_service_id',
                            'type'           => 'MultiSelect',
                            'component_name' => 'MedicService',
                            'default_value'  => null,
                            'attribute'      => [
                                'max' => 2
                            ],
                            'value' => []
                        ]
                    ]
                ],
                [
                    'name' => 'Advanced Reporting',
                    'master_product_item' => [
                        'name' => 'Advanced Reporting',
                        'label' => 'Custom Self Service Reports',
                    ],
                    'note' => null,
                    'price' => 500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Advanced Kasir',
                    'master_product_item' => [
                        'name' => 'Advanced Kasir',
                        'label' => 'Advanced Cashier',
                    ],
                    'note' => 'Invoice, payer, voucher by payer, custom pricelists',
                    'price' => 1000000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Advanced Apotek',
                    'master_product_item' => [
                        'name' => 'Advanced Apotek',
                        'label' => 'Advanced Pharmacy',
                    ],
                    'note' => 'Added inventory support (alkes)',
                    'price' => 1000000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Advanced Lab',
                    'master_product_item' => [
                        'name' => 'Advanced Lab',
                        'label' => 'LIS Integration',
                    ],
                    'note' => null,
                    'price' => 1000000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Advanced Radiologi',
                    'master_product_item' => [
                        'name' => 'Advanced Radiologi',
                        'label' => 'PACS Integration',
                    ],
                    'note' => 'Custom PACS support',
                    'price' => 1000000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Rawat Inap',
                    'master_product_item' => [
                        'name' => 'Rawat Inap',
                        'label' => 'Inpatient',
                    ],
                    'note' => null,
                    'price' => 500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'MCU',
                    'master_product_item' => [
                        'name' => 'MCU',
                        'label' => 'Medical Check Up',
                    ],
                    'note' => null,
                    'price' => 1000000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'IGD',
                    'master_product_item' => [
                        'name' => 'IGD',
                        'label' => 'Emergency Unit',
                    ],
                    'note' => null,
                    'price' => 500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Jumlah Pengguna',
                    'master_product_item' => [
                        'name' => 'Jumlah Pengguna',
                        'label' => 'Users Included',
                    ],
                    'note' => '@30 pengguna',
                    'price' => 6000000,
                    'discount' => 0,
                    'dynamic_forms' => [],
                    'value' => 30
                ]
            ],
            'additional_items' => [
                [
                    'name' => 'Penambahan Poli',
                    'label' => 'MedicService',
                    'master_product_item' => [
                        'name' => 'Add on Poli',
                        'label' => 'AdditionalMedicService',
                    ],
                    'price' => 500000,
                    'discount' => 0,
                    'dynamic_forms' => [
                        [
                            'label'          => 'Nama Poli',
                            'key'            => 'medic_service_id',
                            'type'           => 'MultiSelect',
                            'component_name' => 'MedicService',
                            'default_value'  => null,
                            'attribute'      => null,
                            'rule'           => null,
                            'options'        => [],
                            'value'          => []
                        ]
                    ]
                ],
                [
                    'name' => 'Add on Patient Recap',
                    'label' => 'PatientRecap',
                    'master_product_item' => [
                        'name' => 'Add on Patient Recap',
                        'label' => 'Add on 1000 Patients (AI)',
                    ],
                    'price' => 200000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Add on User',
                    'label' => 'User',
                    'master_product_item' => [
                        'name' => 'Add on User',
                        'label' => 'Add on User',
                    ],
                    'price' => 200000,
                    'discount' => 0,
                    'dynamic_forms' => [
                        [
                            'label'          => 'Jumlah Pengguna',
                            'key'            => 'user_count',
                            'type'           => 'InputNumber',
                            'component_name' => 'UserCount',
                            'default_value'  => null,
                            'attribute'      => [],
                            'rule'           => null,
                            'options'        => [],
                            'value'          => null
                        ]
                    ]
                ],
                [
                    'name' => 'Add on Integrations',
                    'label' => 'Integration',
                    'master_product_item' => [
                        'name' => 'Add on Integrations',
                        'label' => 'Integrations (Selected)',
                    ],
                    'price' => 1200000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Integration Config (One Time)',
                    'label' => 'Integration',
                    'master_product_item' => [
                        'name' => 'Integration Config',
                        'label' => 'Integration Setup',
                    ],
                    'price' => 6000000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Add on Skrining (One Time)',
                    'label' => 'Screening',
                    'master_product_item' => [
                        'name' => 'Add on Skrining',
                        'label' => 'Custom Screening Form',
                    ],
                    'price' => 1500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ],
                [
                    'name' => 'Add on Report (One Time)',
                    'label' => 'Report',
                    'master_product_item' => [
                        'name' => 'Add on Report',
                        'label' => 'Custom Report',
                    ],
                    'price' => 1500000,
                    'discount' => 0,
                    'dynamic_forms' => []
                ]
            ]
        ]

    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->__products as $product) {
            switch ($product['label']) {
                case 'LITE': $product['icon'] = hq_asset_url('/assets/wellmed-lite.png');break;
                case 'PLUS': $product['icon'] = hq_asset_url('/assets/wellmed-plus.png');break;
                case 'E': $product['icon'] = hq_asset_url('/assets/wellmed-e.png');break;
            }
            app(config('app.contracts.Product'))->prepareStoreProduct($this->requestDTO(config('app.contracts.ProductData'),$product));
        }
    }
}
