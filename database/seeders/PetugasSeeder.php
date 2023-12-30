<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('petugas')->insert([[
            'nama_petugas' => 'Abdul',
            'username' => 'abdul',
            'password' => Hash::make('abdul'),
            'level' => 'admin',
            'created_at' => Carbon::now(),
        ],
        [
            'nama_petugas' => 'Budi',
            'username' => 'budi',
            'password' => Hash::make('budi'),
            'level' => 'petugas',
            'created_at' => Carbon::now(),
        ],
        ]);
    }
}
