<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuedCertificate extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'barangay_id',
        'resident_id', 
        'certificate_typeId',
        'certificate_layoutId',
        'certificate_path'
    ];
}
