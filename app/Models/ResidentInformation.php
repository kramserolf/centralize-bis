<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentInformation extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'barangayId', 
        'lastName', 
        'firstName', 
        'middleName',
        'alias',
        'birthday',
        'age',
        'civilStatus',
        'voterStatus',
        'birthPlace',
        'mobileNumber',
        'email',
        'spouse',
        'fatherName',
        'motherName',
        'addressOne',
        'addressTwo',
    ];
}
