<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ResidentAccount extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'barangay_id',
        'user_id', 
        'residentinfo_id',
    ];

    public function scopebarangayId()
    {
        $barangay_id = ResidentAccount::where('user_id', Auth::id())
                        ->first();

        return $barangay_id->barangay_id;
                        
    }
}
