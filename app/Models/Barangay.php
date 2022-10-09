<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;
        protected $fillable = [ 
            'barangayName', 
            'barangayLogo', 
            'barangayCaptain', 
        ];
    
    public function getRouteKeyName()
    {
        return 'barangayName';
    }
}
