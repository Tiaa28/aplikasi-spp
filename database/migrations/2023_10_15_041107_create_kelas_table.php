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
        Schema::create('kelas', function (Blueprint $table) {
            // $table->id('id_kelas');
            $table->integer('id_kelas')->autoIncrement();
            // $table->string('nama_kelas', 10);
            // $table->string('kompetensi_keahlian', 50);
            // $table->timestamps();
            // $table->integer('id_kelas', 11)->autoIncrement();
            $table->string('nama_kelas', 10)->unique();
            $table->string('kompetensi_keahlian', 50);
            // Anda dapat menambahkan kolom lain sesuai kebutuhan
            $table->timestamps(); // kolom ini otomatis menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
