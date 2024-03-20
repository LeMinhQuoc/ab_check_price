<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;



public function up()
{
    Schema::create('products', 
    function (Blueprint $table) {
        $table->id();
        $table->string('product_name');
        $table->integer('ab_beautyworld');
        $table->integer('hasaki');
        $table->integer('guardian');
        $table->integer('thegioiskinfood');
        $table->integer('lamthao');
        $table->timestamps();
    });
}
}
