<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->integer('antrian')->nullable()->after('created_time'); // Bisa juga pakai default(0)
        });
    }

    public function down(): void
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->dropColumn('antrian');
        });
    }
};
