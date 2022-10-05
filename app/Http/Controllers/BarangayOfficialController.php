<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\BarangayOfficial;
use App\Models\BarangaySetting;
use DataTables;

class BarangayOfficialController extends Controller
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


        // get current authentication id
        // $id = Auth::id();
        // filter barangay id
        // $filter = DB::table('users as u')   
        //                     ->leftJoin('accounts as a', 'u.id' ,'a.user_id')
        //                     ->rightJoin('barangays as b', 'a.barangay_id', 'b.id')
        //                     ->select('u.*', 'b.*', 'a.*', 'a.barangay_id as brgy_id')
        //                     ->where('u.id', $id)
        //                     ->first();
        // get current auth barangay id
        // $brgy_id = $filter->brgy_id;
        //load barangay table
        $barangay_officials = [];
        if($request->ajax()) {
            $barangay_officials = DB::table('barangay_officials as o')
                                    ->leftJoin('accounts as a', 'o.barangay_id', 'a.barangay_id')
                                    ->where('a.user_id', Auth::id())
                                    ->get();
            // $barangay_officials = DB::table('barangay_officials as o')
            //                 ->leftJoin('barangays as b', 'o.barangay_id', 'b.id')
            //                 ->select('b.barangayName as barangay', 'o.*')
            //                 ->where('b.id', $brgy_id)
            //                 ->get();
            return DataTables::of($barangay_officials)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editBarangayOfficial"><i class="bi-pencil-square"></i> Edit</a> ';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteBarangayOfficial"><i class="bi-trash"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('secretary/barangay_officials', compact('barangay_officials', 'filter_setting'));

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
