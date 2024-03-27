<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NowPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'p_id',
        'p_ab',
        'p_hsk',
        'p_gu',
        'p_tgs',
        'p_lt'    
    ];
}
