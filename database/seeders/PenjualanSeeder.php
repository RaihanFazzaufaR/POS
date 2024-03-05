<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'penjualan_id'=>1,
                'user_id'=>3,
                'pembeli'=>'Salman',
                'penjualan_kode'=>'PJ001',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>2,
                'user_id'=>3,
                'pembeli'=>'Shani',
                'penjualan_kode'=>'PJ002',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>3,
                'user_id'=>3,
                'pembeli'=>'Shinta',
                'penjualan_kode'=>'PJ003',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>4,
                'user_id'=>3,
                'pembeli'=>'Joko',
                'penjualan_kode'=>'PJ004',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>5,
                'user_id'=>3,
                'pembeli'=>'Kasino',
                'penjualan_kode'=>'PJ005',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>6,
                'user_id'=>3,
                'pembeli'=>'Gunawan',
                'penjualan_kode'=>'PJ006',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>7,
                'user_id'=>3,
                'pembeli'=>'Budiman',
                'penjualan_kode'=>'PJ007',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>8,
                'user_id'=>3,
                'pembeli'=>'Ani',
                'penjualan_kode'=>'PJ008',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>9,
                'user_id'=>3,
                'pembeli'=>'Budi',
                'penjualan_kode'=>'PJ009',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ],
            [
                'penjualan_id'=>10,
                'user_id'=>3,
                'pembeli'=>'Zaki',
                'penjualan_kode'=>'PJ010',
                'penjualan_tanggal'=>'2024-03-05 14:35:54'
            ]
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
