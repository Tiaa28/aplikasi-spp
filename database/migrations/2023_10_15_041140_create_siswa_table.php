<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->char('nisn', 10)->primary();
            $table->char('nis', 8)->unique();
            $table->string('password', 60);
            $table->string('nama', 35);
            $table->integer('id_kelas')->nullable();
            // $table->integer('id_kelas')->unsigned();
            // $table->foreignId('id_kelas')->constrained('kelas');
            // $table->integer('id_kelas')->length(11)->unsigned(); // Unsigned INTEGER with length 11
            // $table->unsignedInteger('id_kelas');

            // $table->integer('id_kelas')->unsigned()->nullable(); // Kolom ID Kelas yang berhubungan
            // $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('SET NULL')->onDelete('SET NULL')->nullable();
            $table->text('alamat');
            $table->char('no_telp', 13);
            // $table->unsignedBigInteger('id_spp');
            $table->integer('id_spp')->nullable(); // Kolom ID SPP yang berhubungan
            $table->foreign('id_spp')->references('id_spp')->on('spp')->onUpdate('SET NULL')->onDelete('SET NULL')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            //bisa pakai
            // php artisan migrate:rollback
            // drop all table and recreate: php artisan migrate:fresh

            // Add foreign key constraints
            // $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            // $table->foreign('id_spp')->references('id_spp')->on('spp');
        });

        // Schema::table('siswa', function (Blueprint $table) {
        //     // $table->unsignedBigInteger('id_kelas');

        //     $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
