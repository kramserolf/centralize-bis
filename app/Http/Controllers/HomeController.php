<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ResidentInformation;
use App\Models\User;


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
        return view('resident.home');
    }
}
