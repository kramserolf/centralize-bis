<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayOfficial extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'barangay_id', 
        'position', 
        'name',
        'official_committee',
        'year_of_service',
    ];
}
