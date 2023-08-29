<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UomCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'uom_category_name',
        'created_by',
        'company_id'
    ];

    protected $primaryKey  = 'uom_category_id';
}
