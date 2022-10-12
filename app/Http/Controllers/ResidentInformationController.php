<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ResidentInformation;
use App\Models\BarangaySetting;
use App\Models\Barangay;
use App\Models\Zone;
use DataTables;

class ResidentInformationController extends Controller
{
    // check user if authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        // load resident table
        $resident = [];
        if($request->ajax()) {
            $resident = DB::table('resident_information as r')
                            ->leftJoin('accounts as a', 'r.barangayId', 'a.barangay_id')
                            ->leftJoin('zones as z', 'r.zone', 'z.id')
                            ->select('r.household_no', 'r.name', 'r.cp_number', 'r.id', 'z.zone as zone_name')
                            ->where('a.user_id', Auth::id())
                            ->orderBy('r.household_no', 'asc')
                            ->get();
            return DataTables::of($resident)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class=" m-1 btn btn-outline-success btn-sm viewResident"><i class="bi-eye"></i> </a>';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class=" m-1 btn btn-outline-success btn-sm generateResidentAccount"><i class="bi-key-fill"></i> </a>';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-secondary btn-sm editResident"><i class="bi-pencil-square"></i> </a>';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-danger btn-sm deleteResident"><i class="bi-trash"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('secretary/resident', [
            'resident' => $resident, 
            'filter_setting' => $filter_setting,
            'filter_zone' => $filter_zone,
        ]);
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
        $brgy_id = DB::table('barangays as b')
                        ->leftJoin('accounts as a', 'b.id', 'a.barangay_id')
                        ->select('b.id as id', 'b.barangayName as barangay')
                        ->where('a.user_id', Auth::id())
                        ->first();
  
       ResidentInformation::create([
        'barangayId' => $brgy_id->id,
        'family_no' => $request->family_no,
        'name' => $request->name,
        'gender' => $request->gender,
        'civil_status' => $request->civil_status,
        'birthday' => $request->birthday,
        'age' => $request->age,
        'zone' => $request->zone,
        'barangay' => $brgy_id->barangay,
        'municipality' => 'Baggao',
        'province' => 'Cagayan',
       ]);
       
       return response()->json(['success'=>'Resident saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $where = [
            'id' => $request->id
        ];
        $residents  = ResidentInformation::where($where)->first();
        return response()->json($residents);
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
        ResidentInformation::where('id', $request->id)->delete();
    }

    // household list
    public function household(Request $request)
    {
         // get current barangay setting
         $filter_setting = BarangaySetting::filterSetting();

        //  // get current barangay id
        //  $barangay_id = DB::table('accounts as a')
        //                     ->select('a.barangay_id')
        //                     ->where('a.user_id', Auth::id())
        //                     ->first();

        // $brgy_id = $barangay_id->barangay_id;
         // load resident table
         $household = [];
         if($request->ajax()) {
             $household = DB::table('resident_information as r')
                            ->leftJoin('accounts as a', 'r.barangayId', 'a.barangay_id')
                            ->leftJoin('zones as z', 'r.zone', 'z.id')
                            ->select('r.id', 'r.household_no', 'r.name', 'z.zone', 'r.cp_number')
                            ->where('a.user_id', Auth::id())
                            ->groupBy('r.household_no')
                            ->orderBy('r.household_no', 'asc')
                            ->get();
             return DataTables::of($household)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class=" m-1 btn btn-outline-success btn-sm viewResident"><i class="bi-eye"></i> </a>';
                     $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-secondary btn-sm editResident"><i class="bi-pencil-square"></i> </a>';
                     $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-danger btn-sm deleteResident"><i class="bi-trash"></i> </a>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }
         return view('secretary/household', [
             'household' => $household, 
             'filter_setting' => $filter_setting,
         ]);
    }

    // senior citizen list
    public function senior(Request $request)
    {
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        // load resident table
        $senior = [];
        if($request->ajax()) {
            $senior = DB::table('resident_information as r')
                                    ->leftJoin('accounts as a', 'r.barangayId', 'a.barangay_id')
                                    ->leftJoin('zones as z', 'r.zone', 'z.id')
                                    ->select('z.zone as zone', 'r.household_no', 'r.name', 'r.age', 'r.id')
                                    ->where('a.user_id', Auth::id())
                                    ->where('r.age', '>=', 60)
                                    ->orderBy('z.zone', 'asc')
                                    ->get();
            return DataTables::of($senior)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class=" m-1 btn btn-outline-success btn-sm viewResident"><i class="bi-eye"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('secretary/senior_citizen', [
            'senior' => $senior, 
            'filter_setting' => $filter_setting,
            'filter_zone' => $filter_zone,
        ]);
    }

    public function adminResident(Request $request)
    {
        $resident = [];
        if($request->ajax()) {
            $resident = DB::table('resident_information as r')
                            ->leftJoin('barangays as b', 'r.barangayId', 'b.id')
                            ->select('b.barangayName as barangay', 'r.*')
                            ->orderBy('barangay')
                            ->get();
            return DataTables::of($resident)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-success btn-sm viewResident"><i class="bi-eye"></i> View</a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin/resident', compact('resident'));
    }
}
