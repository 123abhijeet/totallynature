<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicledocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'document_title',
        'document_issue_date',
        'document_expiry_date',
        'document_file',
        'created_by',
        'company_id'
    ];
}
