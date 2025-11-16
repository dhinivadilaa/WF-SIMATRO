<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');               // Judul acara
            $table->text('description')->nullable(); // Deskripsi acara
            $table->string('speaker')->nullable();   // Pemateri
            $table->dateTime('start_time');        // Waktu mulai
            $table->dateTime('end_time')->nullable(); // Waktu selesai
            $table->string('location')->nullable();  // Tempat acara
            $table->string('banner')->nullable();    // Gambar/banner acara
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
