<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_barcode',
        'brand',
        'product_name',
        'ab_beautyworld',
        'hasaki',
        'guardian',
        'thegioiskinfood',
        'lamthao'
    ];
}