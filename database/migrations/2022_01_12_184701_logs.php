<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Logs extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamps();

            $table->text('level')->nullable();

            $table->text('message')->nullable();

            $table->unsignedBigInteger('object_id')->nullable();

            $table->string('object_class')->nullable();

            $table->jsonb('object_state')->nullable();

            $table->jsonb('data')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
}