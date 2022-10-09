<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Zone;
use App\Models\Account;
use App\Models\BarangaySetting;
use App\Models\ResidentInformation;
use DataTables;

class ZoneController extends Controller
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
         // get current logo
         $filter_setting = BarangaySetting::filterSetting();

        //  count resident per zone

        // $per_zone = ResidentInformation::all();

        // $count = DB::table('resident_information as r')
        //                 ->leftJoin('accounts as a', 'r.barangayId', 'a.barangay_id')
        //                 ->leftJoin('zones as z', 'r.zone', 'z.id')
        //                 ->selectRaw('count(*) as per_zone, z.zone as zone_name')
        //                 ->groupBy('r.zone')
        //                 ->where('a.user_id', Auth::id())
        //                 ->get();


        // dd($array);
 
         //load barangay table
         $zone = [];
         if($request->ajax()) {
        $zone = DB::table('resident_information as r')
                            ->leftJoin('accounts as a', 'r.barangayId', 'a.barangay_id')
                            ->join('zones as z', 'r.zone', 'z.id')
                            ->selectRaw('count(*) as per_zone, z.zone, z.id')
                            ->where('a.user_id', Auth::id())
                            ->groupBy('r.zone')
                            ->orderBy('per_zone', 'desc')
                            ->get();
                                
             return DataTables::of($zone)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editZone"><i class="bi-pencil-square"></i> </a> ';
                     $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteZone"><i class="bi-trash"></i> </a>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }
         return view('secretary/zone', compact('zone', 'filter_setting'));
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
        $request->validate([
            'zone' => 'required|string',
        ]);

        // filter barangay id
        $filter = Account::where('user_id', Auth::id())
                            ->first();

        $insert = Zone::create([
               'barangay_id' => $filter->barangay_id,
               'zone' => $request->zone,
            ]);

            return response()->json(['success'=>'Zone saved successfully.']);
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
        Zone::where('id', $request->id)->delete();
        // ResidentInformation::where('zone', $request->id)
        //                 ->update(['zone' => null]);
    }
}
