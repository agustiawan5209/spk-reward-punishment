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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_penilaians')->cascadeOnDelete();
            $table->json('kategori');

            $table->foreignId('aspek_id');
            $table->json('aspek');

            $table->foreignId('staff_penilai_id');
            $table->json('staff_penilai')->nullable();

            $table->foreignId('staff_id');
            $table->json('staff')->nullable();

            $table->date('tgl_penilaian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
