<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoHpKeluargaToCapstersTable extends Migration
{
    public function up()
    {
        Schema::table('capsters', function (Blueprint $table) {
            $table->string('no_hp_keluarga', 20)->nullable()->after('no_hp');
        });
    }

    public function down()
    {
        Schema::table('capsters', function (Blueprint $table) {
            $table->dropColumn('no_hp_keluarga');
        });
    }
}