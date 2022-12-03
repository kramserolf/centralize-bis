<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ResidentInformation;
use App\Models\User;
use App\Models\ResidentAccount;
use App\Models\Barangay;
use App\Models\Announcement;
use App\Models\BarangaySetting;
use App\Models\CertificateType;
use App\Models\Zone;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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

        $certificates = CertificateType::where('barangay_id', $barangay_id)
                            ->get();

        $announcements = db::table('announcements as a')
                                ->leftJoin('barangays as b', 'a.barangay_id', 'b.id')
                                ->select('a.*', 'b.barangayName', DB::raw('DATE_FORMAT(a.updated_at, \'%M %d, %Y\') as created'))
                                ->paginate(8);

        return view('resident.home', compact('barangay_name', 'announcements', 'certificates'));
    }

    public function adminProfile()
{
        return view('admin.profile');
    }
    public function secretaryProfile()
    {
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();

        // filter barangay ID
        $barangay_id = Account::barangayId();

        // filter Zone
        $filter_zone = Zone::zoneFilter();
        return view('secretary.profile', compact('filter_setting', 'barangay_id', 'filter_zone'));
    }

    public function residentProfile()
    {
        // get current Barangay id
        $barangay_id = ResidentAccount::barangayId();

        $certificates = CertificateType::where('barangay_id', $barangay_id)
        ->get();


        $current_barangay = Barangay::where('id', $barangay_id)
                                ->first();

        $barangay_name = $current_barangay->barangayName;

        

        return view('resident.profile', compact('barangay_name', 'certificates'));
    }


    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save();

        return back()->withSuccess('Profile updated successfully.');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => [
                Password::min(8)
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
            ],
            'password_confirmation' => 'nullable|min:6|max:12|required_with:new_password|same:new_password'
        ]);


        $user = User::findOrFail(Auth::user()->id);

        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withInput();
            }
        }

        $user->save();

        return back()->withSuccess('Profile updated successfully.');
    }


}
