<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePrices extends Migration
{
    public function up()
    {
        Schema::table(
            'assets',
            function (Blueprint $table) {
                $table->dropColumn('price');

                $table->unsignedInteger('price_personal')->nullable();
                $table->unsignedInteger('price_commercial')->nullable();
                $table->unsignedInteger('price_commercial_ext')->nullable();
            }
        );

        Schema::table(
            'families',
            function (Blueprint $table) {
                $table->dropColumn('price');

                $table->unsignedInteger('price_personal')->nullable();
                $table->unsignedInteger('price_commercial')->nullable();
                $table->unsignedInteger('price_commercial_ext')->nullable();
            }
        );

        Schema::table(
            'packs',
            function (Blueprint $table) {
                $table->dropColumn('price');
                $table->unsignedInteger('price_personal')->nullable();
                $table->unsignedInteger('price_commercial')->nullable();
                $table->unsignedInteger('price_commercial_ext')->nullable();
            }
        );
    }

    public function down()
    {
        Schema::table(
            'assets',
            function (Blueprint $table) {
                $table->unsignedInteger('price')->nullable();
                $table->dropColumn('price_personal');
                $table->dropColumn('price_commercial');
                $table->dropColumn('price_commercial_ext');
            }
        );

        Schema::table(
            'families',
            function (Blueprint $table) {
                $table->unsignedInteger('price')->nullable();
                $table->dropColumn('price_personal');
                $table->dropColumn('price_commercial');
                $table->dropColumn('price_commercial_ext');
            }
        );
        Schema::table(
            'packs',
            function (Blueprint $table) {
                $table->unsignedInteger('price')->nullable();
                $table->dropColumn('price_personal');
                $table->dropColumn('price_commercial');
                $table->dropColumn('price_commercial_ext');
            }
        );
    }
}