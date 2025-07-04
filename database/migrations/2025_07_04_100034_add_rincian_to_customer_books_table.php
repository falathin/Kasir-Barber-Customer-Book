<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->text('rincian')->nullable()->after('sell_use_product');
        });
    }

    public function down(): void
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->dropColumn('rincian');
        });
    }

};
