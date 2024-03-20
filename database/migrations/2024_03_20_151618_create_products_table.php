<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', 
        function (Blueprint $table) {
            $table->id();
            $table->string('product_barcode');
            $table->string('brand');
            $table->string('product_name');
            $table->string('ab_beautyworld');
            $table->string('hasaki');
            $table->string('guardian');
            $table->string('thegioiskinfood');
            $table->string('lamthao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
