<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price_structure_id',
        'price',
    ];
}
