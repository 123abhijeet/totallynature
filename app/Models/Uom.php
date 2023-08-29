<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use HasFactory;
    protected $fillable = [
        'uom',
        'uom_category_id',
        'ratio',
        'created_by',
        'company_id'
    ];
}
