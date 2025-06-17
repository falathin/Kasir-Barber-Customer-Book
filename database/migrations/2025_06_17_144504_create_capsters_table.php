<?php

// database/migrations/2025_06_17_000000_create_capsters_table.php

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
        Schema::create('capsters', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('inisial');
            $table->enum('jenis_kelamin', ['L', 'P']); // atau bisa juga pakai string biasa
            $table->string('no_hp');
            $table->date('tgl_lahir');
            $table->string('asal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capsters');
    }
};
