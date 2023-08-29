<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_modal',
        'license_plate',
        'current_odometer',
        'last_odometer',
        'next_servicing_odometer',
        'servicing_status',
        'model_year',
        'model_color',
        'horsepower',
        'fuel_type',
        'created_by',
        'company_id'
    ];
    protected $primaryKey  = 'vehicle_id';
}
