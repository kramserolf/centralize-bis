<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BarangaySetting extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'barangay_id', 
        'user_id', 
        'logo',
        'barangay_captain',
        'municipality',
        'province',
    ];

    public function scopefilterSetting()
    {
        $barangay_id = DB::table('accounts as a')
                            ->select('a.barangay_id')
                            ->where('a.user_id', Auth::id())
                            ->first();

        $brgy_id = $barangay_id->barangay_id;
        
        $filter = DB::table('barangay_settings as s')
                            ->leftJoin('barangays as b', 's.barangay_id', 'b.id')
                            ->select('s.logo as logo', 'b.barangayName as barangay')
                            ->where('s.barangay_id', $brgy_id)
                            ->first();
        return $filter;
                                    
    }
}
