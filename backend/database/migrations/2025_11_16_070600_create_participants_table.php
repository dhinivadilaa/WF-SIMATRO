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

            // ❌ HAPUS event_id — peserta bisa ikut banyak event
            // ❌ HAPUS pin — PIN milik event, bukan peserta
            // ❌ HAPUS is_verified — peserta TIDAK login

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('participants');
    }
};
