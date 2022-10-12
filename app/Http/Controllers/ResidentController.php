<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\ResidentInformation;
use App\Models\Resident;
use App\Models\BarangaySetting;
use App\Models\Account;
use App\Models\User;
use App\Models\Zone ;
use DataTables;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get current logo
        $filter_setting = BarangaySetting::filterSetting();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        $barangay_id = Account::barangayId();

        //load barangay table
        $resident_account = [];
           if($request->ajax()) {
               $resident_account = DB::table('residents as r')
                                        ->leftJoin('users as u', 'r.user_id', 'u.id')
                                        ->leftJoin('resident_information as i', 'r.residentinfo_id', 'i.id')
                                        ->leftJoin('zones as z', 'i.zone', 'z.id')
                                        ->select('u.name as name', 'u.email as email', 'z.zone as zone', 'r.id')
                                        ->where('r.barangay_id', $barangay_id)
                                        ->get();
   
               return DataTables::of($resident_account)
                   ->addIndexColumn()
                   ->addColumn('action', function ($row) {
                       $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteResidentAccount"><i class="bi-trash" ></i> </a>';
                       return $btn;
                   })
                   ->rawColumns(['action'])
                   ->make(true);
           }
  
          return view('secretary/resident_account', compact( 'resident_account' ,'filter_setting', 'filter_zone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get resident name
        $resident_info = ResidentInformation::where('id', $request->id)
                                ->first();
        // remove whitespace in name
        $resident_name = str_replace(' ', '', $resident_info->name);

        $user = User::create([
            'name' => $resident_info->name,
            'email' => ''.$resident_name.'@gmail.com',
            'password' => Hash::make('123456'),
            'is_role' => 2
        ]);

        // get inserted ID
        $lastInsertId = $user->id;

        //get current barangay
        $barangay_id = Account::barangayId();
        
        Resident::create([
            'residentinfo_id' => $request->id,
            'barangay_id' => $barangay_id,
            'user_id' => $lastInsertId,
        ]);

        return response()->json(['success'=>'Account saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $resident = Resident::where('id', $request->id)
                        ->first();
        Resident::where('id', $request->id)
                        ->delete();
        User::where('id', $resident->user_id)
                        ->delete();
    }
}
