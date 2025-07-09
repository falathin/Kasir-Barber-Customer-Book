<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToCapstersTable extends Migration
{
    public function up()
    {
        Schema::table('capsters', function (Blueprint $table) {
            $table->enum('status', ['Aktif', 'sudah keluar'])
                  ->default('Aktif')
                  ->after('foto');
        });
    }

    public function down()
    {
        Schema::table('capsters', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}