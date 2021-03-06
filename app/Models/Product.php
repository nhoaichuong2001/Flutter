<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'price',
        'stock',
        'unit',
        'image',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
}
