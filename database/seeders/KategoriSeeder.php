<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'kategori_id'=>1,
                'kategori_kode'=>'FBV',
                'kategori_nama'=>'Food-Beverages'
            ],
            [
                'kategori_id'=>2,
                'kategori_kode'=>'BTH',
                'kategori_nama'=>'Beauty-Health'
            ],
            [
                'kategori_id'=>3,
                'kategori_kode'=>'FAC',
                'kategori_nama'=>'Fashion-Accessories'
            ],
            [
                'kategori_id'=>4,
                'kategori_kode'=>'HML',
                'kategori_nama'=>'Home-Living'
            ],
            [
                'kategori_id'=>5,
                'kategori_kode'=>'BAK',
                'kategori_nama'=>'Baby-Kid'
            ]
        ];
        DB::table('m_kategori')->insert($data);
    }
}
