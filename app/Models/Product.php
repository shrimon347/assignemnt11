<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'short_description',
        'long_description',
        'image',
        'stock',
        'status',
        'seo_tags',
    ];
}
