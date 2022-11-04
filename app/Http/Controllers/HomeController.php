<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ResidentInformation;
use App\Models\User;
use App\Models\ResidentAccount;
use App\Models\Barangay;
use App\Models\Announcement;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_population = ResidentInformation::count();

        $total_accounts = User::where('is_role', 1)
                            ->count();

        return view('admin/home', compact('total_population', 'total_accounts'));
    }

    public function residentHome()
    {
        // get current Barangay id
        $barangay_id = ResidentAccount::barangayId();

        $current_barangay = Barangay::where('id', $barangay_id)
                                ->first();

        $barangay_name = $current_barangay->barangayName;

        $announcements = Announcement::where('barangay_id', $barangay_id)
                                    ->get();

        return view('resident.home', compact('barangay_name', 'announcements'));
    }
}
