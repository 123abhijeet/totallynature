<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceStructure extends Model
{
    use HasFactory;
    protected $fillable = [
        'price_structure',
        'created_by',
        'company_id'
    ];
}
