<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Zone extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'barangay_id', 
        'zone',
    ];


    public function scopezoneFilter()
    {
        $filter = DB::table('zones as z')
                            ->leftJoin('accounts as a', 'z.barangay_id', 'a.barangay_id')
                            ->select('z.zone as zone')
                            ->where('a.user_id', Auth::id())
                            ->orderBy('z.zone', 'asc')
                            ->get();
        return $filter;
                                    
    }

}
