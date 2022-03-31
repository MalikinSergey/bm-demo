<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAssetsAddSearchContentIndex extends Migration
{
    public function up()
    {
        Schema::table(
            'assets',
            function (Blueprint $table) {
                DB::statement("CREATE INDEX assets_search_content_gin ON assets USING GIN(search_content)");
                DB::statement("CREATE INDEX packs_search_content_gin ON packs USING GIN(search_content)");
            }
        );
    }

    public function down()
    {
        Schema::table(
            'assets',
            function (Blueprint $table) {
                DB::statement("DROP INDEX IF EXISTS assets_search_content_gin");
                DB::statement("DROP INDEX IF EXISTS packs_search_content_gin");

            }
        );
    }
}
