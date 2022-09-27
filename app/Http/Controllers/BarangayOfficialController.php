<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BarangayOfficial;
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
        // get current authentication id
        $id = Auth::id();
        // filter barangay id
        $filter = DB::table('users as u')   
                            ->leftJoin('accounts as a', 'u.id' ,'a.account_id')
                            ->rightJoin('barangays as b', 'a.barangay_id', 'b.id')
                            ->select('u.*', 'b.*', 'a.*', 'a.barangay_id as brgy_id')
                            ->where('u.id', $id)
                            ->first();
        // get current auth barangay id
        $brgy_id = $filter->brgy_id;
        //load barangay table
        $barangay_officials = [];
        if($request->ajax()) {
            $barangay_officials = DB::table('barangay_officials as o')
                            ->leftJoin('barangays as b', 'o.barangay_id', 'b.id')
                            ->select('b.barangayName as barangay', 'o.*')
                            ->where('b.id', $brgy_id)
                            ->get();
            return DataTables::of($barangay_officials)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-success btn-sm editBarangayOfficial"><i class="fas fa-fw fa-pencil-alt"></i> Edit</a> ';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBarangayOfficial"><i class="fas fa-fw fa-trash-alt"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('secretary/barangay_officials', compact('barangay_officials', 'filter'));

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
            'barangay_id' => 'required',
            'position' => 'required|string',
            'name' => 'required|string',
            'official_committee' => 'required',
            'year_of_service' => 'required',
            'picture' => 'required',
        ]);

        // get current authentication id
        $id = Auth::id();
        // filter barangay id
        $filter = DB::table('users as u')   
                            ->leftJoin('accounts as a', 'u.id' ,'a.account_id')
                            ->rightJoin('barangays as b', 'a.barangay_id', 'b.id')
                            ->select('u.*', 'b.*', 'a.*', 'a.barangay_id as brgy_id')
                            ->where('u.id', $id)
                            ->first();
        // get current auth barangay id
        $brgy_id = $filter->brgy_id;

        $insert = BarangayOfficial::updateOrCreate(
            [ 'id' => $request->id ],
            [
               'barangay_id' => $brgy_id,
               'position' => $request->position, 
               'name' => $request->name,
               'official_committee' => $request->official_committee,  
               'year_of_service' => $request->year_of_service, 
               'picture' => $request->picture, 
            ]);
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
    public function destroy($id)
    {
        //
    }
}
