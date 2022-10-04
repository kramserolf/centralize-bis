<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

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
        $filter = DB::table('barangay_settings as s')
                            ->leftJoin('barangays as b', 's.barangay_id', 'b.id')
                            ->select('s.logo as logo', 'b.barangayName as barangay')
                            ->where('s.user_id', Auth::id())
                            ->first();
        return $filter;
                                    
    }
}
