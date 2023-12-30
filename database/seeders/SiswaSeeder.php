<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('siswa')->insert([[
            'nisn' => '001123',
            'nis' => '001121',
            'password' => Hash::make('1'),
            'nama' => 'Abu',
            'id_kelas' => 1,
            'alamat' => 'Kuningan',
            'no_telp' => '0823555',
            'id_spp' => 1,
            'created_at' => Carbon::now(),
        ],
        [
            'nisn' => '001124',
            'nis' => '001122',
            'password' => Hash::make('1'),
            'nama' => 'Lestari',
            'id_kelas' => 1,
            'alamat' => 'Ciledug',
            'no_telp' => '0823555',
            'id_spp' => 1,
            'created_at' => Carbon::now(),
        ],
        [
            'nisn' => '001125',
            'nis' => '001123',
            'password' => Hash::make('1'),
            'nama' => 'Budi',
            'id_kelas' => 1,
            'alamat' => 'Cikeusik',
            'no_telp' => '0823555',
            'id_spp' => 1,
            'created_at' => Carbon::now(),
        ],
        [
            'nisn' => '001126',
            'nis' => '001124',
            'password' => Hash::make('1'),
            'nama' => 'Putri',
            'id_kelas' => 1,
            'alamat' => 'Pabuaran',
            'no_telp' => '0823555',
            'id_spp' => 1,
            'created_at' => Carbon::now(),
        ],
        ]);
    }
}
