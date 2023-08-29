<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'service_type',
        'driver_id',
        'vehicle_id',
        'date',
        'odometer_value',
        'cost',
        'invoice_file',
        'odometer_file',
        'notes',
        'created_by',
        'company_id'
    ];

    protected $primaryKey  = 'service_id';
}
