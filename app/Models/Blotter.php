<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blotter extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'user_id', 
        'barangay_id',
        'respondents',
        'incident_type',
        'status',
        'schedule_date',
        'date_reported',
        'time_incident',
        'location',
        'narrative',
    ];
}
