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

            $table->string('title');                 
            $table->text('description')->nullable();
            $table->string('speaker')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('banner')->nullable();

            // 👉 Tambahan penting untuk absensi
            $table->string('pin_code', 6)->nullable()
                  ->comment('PIN absensi yang dibuat panitia, hanya aktif saat acara berlangsung');

            // (opsional)
            $table->integer('max_participants')->nullable()
                  ->comment('Batas maksimal peserta, opsional');

            // (opsional)
            $table->boolean('is_active')->default(true)
                  ->comment('Status event, true = aktif');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
