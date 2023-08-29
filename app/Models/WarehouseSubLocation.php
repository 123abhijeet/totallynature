<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseSubLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'sub_location'
    ];
}
