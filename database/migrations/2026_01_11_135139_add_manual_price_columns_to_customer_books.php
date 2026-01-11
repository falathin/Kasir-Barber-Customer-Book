<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManualPriceColumnsToCustomerBooks extends Migration
{
    public function up()
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->string('hair_coloring_price')->nullable()->after('colouring_other');
            $table->string('hair_extension_price')->nullable()->after('hair_coloring_price');
            $table->string('hair_extension_services_price')->nullable()->after('hair_extension_price');
        });
    }

    public function down()
    {
        Schema::table('customer_books', function (Blueprint $table) {
            $table->dropColumn([
                'hair_coloring_price',
                'hair_extension_price',
                'hair_extension_services_price'
            ]);
        });
    }
}
