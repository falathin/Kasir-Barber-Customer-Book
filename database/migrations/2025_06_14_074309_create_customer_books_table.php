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
        Schema::create('customer_books', function (Blueprint $table) {
            $table->id();

            // Informasi customer & service
            $table->string('customer')->nullable();
            $table->string('cap')->nullable();
            $table->string('asisten')->nullable();
            $table->string('haircut_type')->nullable();
            $table->string('barber_name')->nullable();

            // Detail panjang
            $table->text('colouring_other')->nullable();
            $table->text('sell_use_product')->nullable();
            $table->text('rincian')->nullable();

            // Waktu, antrean, harga, QR
            $table->dateTime('created_time')->nullable();
            $table->integer('antrian')->nullable();
            $table->string('price')->nullable()->default('0');
            $table->string('qr')->nullable();

            // created_at & updated_at
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