<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\BarangayOfficial;
use App\Models\BarangaySetting;
use App\Models\Zone;
use DataTables;

class BarangayOfficialController extends Controller
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

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        //load barangay table
        $barangay_officials = [];
        if($request->ajax()) {
            $barangay_officials = DB::table('barangay_officials as o')
                                    ->leftJoin('accounts as a', 'o.barangay_id', 'a.barangay_id')
                                    ->select('o.*')
                                    ->where('a.user_id', Auth::id())
                                    ->get();

            return DataTables::of($barangay_officials)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editBarangayOfficial"><i class="bi-pencil-square"></i> </a> ';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteBarangayOfficial"><i class="bi-trash" ></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('secretary/barangay_officials', compact('barangay_officials', 'filter_setting', 'filter_zone'));

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
            'position' => 'required|string',
            'name' => 'required|string',
        ]);

        // filter barangay id
        $filter = Account::where('user_id', Auth::id())
                            ->first();

        $insert = BarangayOfficial::create([
               'barangay_id' => $filter->barangay_id,
               'position' => $request->position, 
               'name' => $request->name,
               'official_committee' => $request->committee,  
               'years_of_service' => $request->years_of_service, 
               'zone' => $request->zone, 
            ]);

            return response()->json(['success'=>'Barangay saved successfully.']);
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
        BarangayOfficial::where('id', $request->id)->delete();
    }

}
