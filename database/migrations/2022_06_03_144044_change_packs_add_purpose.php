<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('packs', function (Blueprint $table) {
            $table->string('purpose')->default('paid');
        });
    }

    public function down()
    {
        Schema::table('packs', function (Blueprint $table) {
            $table->dropColumn('purpose');
        });
    }
};