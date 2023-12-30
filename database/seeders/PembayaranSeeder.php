<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembayaran')->insert([[
            'id_petugas' => 1,
            'nisn' => '001123',
            'tgl_bayar' => Carbon::now(),
            'bulan_dibayar' => 'Agustus',
            'tahun_dibayar' => '2023',
            'id_spp' => 1,
            'jumlah_bayar' => '500000',
            'created_at' => Carbon::now(),
        ],
        [
            'id_petugas' => 1,
            'nisn' => '001123',
            'tgl_bayar' => Carbon::now(),
            'bulan_dibayar' => 'September',
            'tahun_dibayar' => '2023',
            'id_spp' => 1,
            'jumlah_bayar' => '500000',
            'created_at' => Carbon::now(),
        ],
        ]);
    }
}
