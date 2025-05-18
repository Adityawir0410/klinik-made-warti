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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->string('id_rekam', 25)->primary();
            $table->string('id_pasien', 10);

            // Foreign key ke tabel users → kolom 'id' (bukan id_user)
            $table->unsignedBigInteger('user_id'); 

            $table->date('tanggal_kunjungan');
            $table->text('keluhan');
            $table->integer('biaya');
            $table->timestamps();

            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
