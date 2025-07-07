<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->string('customer')->nullable()->after('note');
            $table->string('cap')->nullable()->after('customer');
            $table->string('haircut_type')->nullable()->after('cap');
            $table->string('barber_name')->nullable()->after('haircut_type');
            $table->text('colouring_other')->nullable()->after('barber_name');
            $table->text('sell_use_product')->nullable()->after('colouring_other');
            $table->string('price')->nullable()->default(0)->after('sell_use_product');
            $table->string('qr')->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn([
                'customer',
                'cap',
                'haircut_type',
                'barber_name',
                'colouring_other',
                'sell_use_product',
                'price',
                'qr',
            ]);
        });
    }
};
