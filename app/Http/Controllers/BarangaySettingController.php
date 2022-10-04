<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BarangaySetting;
use App\Models\Barangay;
use App\Models\Account;

class BarangaySettingController extends Controller
{
    public function index()
    {
        $filter_setting = BarangaySetting::filterSetting();
        return view('secretary/barangay_setting', compact('filter_setting') );
    }

    public function saveSetting(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1280',
        ]);

        // get image name
        $imageName = $request->image->getClientOriginalName();
        // move the image to banners folder
        $request->image->move(public_path('images/barangay_logo/'), $imageName);

        //barangay id
        $query = Account::where('user_id', Auth::id())
                                    ->first();
        $barangay_id = $query->barangay_id;                         

        $update = BarangaySetting::where('user_id', Auth::id())
                        ->update([
                            'barangay_id' => $barangay_id,
                            'logo' => $imageName
                        ]);
        if(!empty($update)){
            return true;
        } else{
            BarangaySetting::create([
                'barangay_id' => $barangay_id,
                'logo' => $imageName,
                'user_id' => Auth::id()
            ]);
        }
        
        return response()->json('Banner created successfully');
    }
}
