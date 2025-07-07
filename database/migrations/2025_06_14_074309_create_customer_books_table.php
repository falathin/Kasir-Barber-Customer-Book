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
        Schema::create('customer_books', function (Blueprint $table) {
            $table->id();
            $table->string('customer')->nullable();
            $table->string('cap')->nullable();
            $table->string('haircut_type')->nullable();
            $table->string('barber_name')->nullable();
            $table->text('colouring_other')->nullable();
            $table->text('sell_use_product')->nullable();
            $table->string('price')->nullable()->default(0);
            $table->string('qr')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_books');
    }
};
