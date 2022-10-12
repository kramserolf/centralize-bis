<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentAccount extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'barangay_id',
        'user_id', 
        'residentinfo_id',
    ];
}
