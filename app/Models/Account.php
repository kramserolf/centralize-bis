<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'account_id', 
        'barangay_id',
        'name',
        'email',
        'password',
        'contact_number' 
    ];
}
