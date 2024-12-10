<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('quantity')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
        });
    }
};
