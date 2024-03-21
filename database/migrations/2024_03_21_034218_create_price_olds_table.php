<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceOldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_olds', function (Blueprint $table) {
            $table->id();
            $table->integer('p_id');
            $table->integer('p_ab');
            $table->integer('p_hsk');
            $table->integer('p_gu');
            $table->integer('p_tgs');
            $table->integer('p_lt');
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
        Schema::dropIfExists('price_olds');
    }
}
