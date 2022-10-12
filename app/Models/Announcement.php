<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'barangay_id', 
        'title', 
        'content', 
        'image',
        'date',
        'location'
    ];
    
    public function getRouteKeyName()
    {
        return 'title';
    }
}
