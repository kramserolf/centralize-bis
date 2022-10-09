<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateLayout extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'logo1', 
        'logo2',
        'cert_type',
        'cert_header',
        'cert_title',
        'cert_purpose',
        'paragraph1',
        'paragraph2',
        'paragraph3',
        'paragraph4'
    ];
}
