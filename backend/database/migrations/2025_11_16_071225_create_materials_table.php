<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();      // Materi PDF/PowerPoint dll.
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
