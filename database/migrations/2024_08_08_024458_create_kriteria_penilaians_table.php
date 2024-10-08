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
        Schema::create('kriteria_penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspek_id')->constrained('aspek_kriterias')->onDelete('cascade');
            $table->string('nama');
            $table->integer('bobot')->nullable();
            $table->integer('persentase')->nullable();
            $table->enum('factory', ['core', 'secondary']);
            $table->integer('nilai_target');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_penilaians');
    }
};
