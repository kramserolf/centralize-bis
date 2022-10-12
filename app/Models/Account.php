<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'user_id', 
        'barangay_id',
        'contact_number' 
    ];

    public function scopebarangayId()
    {
        $barangay_id = Account::where('user_id', Auth::id())
                        ->first();

        return $barangay_id->barangay_id;
                        
    }
    // public function getCreatedAtAttribute($value)
    // {
    //     return $value->format('M d, Y ').' at '.$value->format('h:i:s');
    // }
}
