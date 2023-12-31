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
        Schema::create('spp', function (Blueprint $table) {
            $table->integer('id_spp')->autoIncrement();
            $table->integer('tahun')->unique();
            $table->integer('nominal');
            $table->timestamps(); // kolom ini otomatis menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp');
    }
};
