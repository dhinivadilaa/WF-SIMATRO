<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');      // Acara
            $table->unsignedBigInteger('user_id');       // Peserta
            $table->boolean('is_present')->default(false);
            $table->timestamp('check_in_time')->nullable();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
