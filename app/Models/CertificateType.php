<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateType extends Model
{
    use HasFactory;

    // protected $dateFormat = 'F j, Y, g:i a';
    // protected $dateFormat = 'U';

    protected $fillable = [ 
        'barangay_id',
        'name', 
        'purpose',
    ];
}
