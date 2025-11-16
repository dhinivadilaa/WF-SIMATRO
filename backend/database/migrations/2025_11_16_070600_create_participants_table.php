<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete(); 
            // Jika event dihapus → pesertanya ikut terhapus

            $table->string('name');
            $table->string('email')->index();
            $table->string('phone')->nullable();

            $table->string('pin')->unique(); 
            // PIN digunakan untuk absensi dan generate sertifikat

            $table->boolean('is_verified')->default(false);
            // Untuk menandai jika email sudah diverifikasi (opsional)

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('participants');
    }
};
