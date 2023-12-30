<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([[
            'nama_kelas' => "12 PPLG 1",
            'kompetensi_keahlian' => "PPLG",
            'created_at' => Carbon::now(),
        ],
        [
            'nama_kelas' => "12 PPLG 2",
            'kompetensi_keahlian' => "PPLG",
            'created_at' => Carbon::now(),
        ],
        [
            'nama_kelas' => "12 PPLG 3",
            'kompetensi_keahlian' => "PPLG",
            'created_at' => Carbon::now(),
        ],
        [
            'nama_kelas' => "12 PPLG 4",
            'kompetensi_keahlian' => "PPLG",
            'created_at' => Carbon::now(),
        ]
        ]);
    }
}
