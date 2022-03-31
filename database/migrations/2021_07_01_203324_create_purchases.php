<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchases extends Migration
{
    public function up()
    {
        Schema::create(
            'purchases',
            function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->unsignedBigInteger('user_id')->nullable();

                $table->unsignedBigInteger('purchase_id')->nullable();

                $table->string('purchase_type')->nullable();

                $table->string('license')->nullable();

                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}