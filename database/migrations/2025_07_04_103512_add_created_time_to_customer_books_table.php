<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->dateTime('created_time')->nullable()->after('rincian');
        });
    }

    public function down(): void
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->dropColumn('created_time');
        });
    }
};
