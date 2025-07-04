<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->string('asisten')->nullable()->after('cap');
        });
    }

    public function down()
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->dropColumn('asisten');
        });
    }

};
