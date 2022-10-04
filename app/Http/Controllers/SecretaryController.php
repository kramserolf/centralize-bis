<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\User;
use App\Models\Barangay;
use App\Models\BarangaySetting;



use DataTables;
class SecretaryController extends Controller
{
    
    public function index()
    {   
        //get current authenticated user
        $id = Auth::id();
    
        // filter secretary account by barangay
        $filter = DB::table('users as u')   
                ->leftJoin('accounts as a', 'u.id' ,'a.user_id')
                ->rightJoin('barangays as b', 'a.barangay_id', 'b.id')
                ->select('u.*', 'b.*', 'a.*', 'b.id as brgy_id', 'b.barangayLogo as logo')
                ->where('u.id', $id)
                ->first();
        // get current authenticated barangay id
        $brgy_id = $filter->brgy_id;

        $filter_setting = BarangaySetting::filterSetting();

  
        // if(!empty($filter_setting)){
        //     return true;
        // } else{
            
        // }
        
        $population = DB::table('resident_information as r')
                            ->leftJoin('barangays as b', 'r.barangayId', 'b.id')
                            ->where('r.barangayId', $brgy_id)
                            ->get();
        $total = $population->count();
        // dd($population);
        return view('secretary.home', compact('filter', 'total', 'filter_setting'));
    }

}
