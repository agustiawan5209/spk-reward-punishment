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
        Schema::create('keputusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id');
            $table->json('kategori');
            $table->foreignId('staff_id');
            $table->json('staff');
            $table->string('alasan');
            $table->double('point', 10,2)->default(0);
            $table->enum('jenis_putusan', ['punishment', 'reward']);
            $table->date('tgl_putusan');
            $table->string('hasil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keputusans');
    }
};
