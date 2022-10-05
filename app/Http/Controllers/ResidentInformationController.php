<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ResidentInformation;
use App\Models\BarangaySetting;
use DataTables;

class ResidentInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();
        // get current authentication id
        $id = Auth::id();
        // filter barangay id
        $filter = DB::table('users as u')   
                            ->leftJoin('accounts as a', 'u.id' ,'a.user_id')
                            ->rightJoin('barangays as b', 'a.barangay_id', 'b.id')
                            ->select('u.*', 'b.*', 'a.*', 'a.barangay_id as brgy_id')
                            ->where('u.id', $id)
                            ->first();
        // get current auth barangay id
        $brgy_id = $filter->brgy_id;
        // load resident table
        $resident = [];
        if($request->ajax()) {
            $resident = DB::table('resident_information as r')
                            ->leftJoin('accounts as a', 'r.barangayId', 'a.barangay_id')
                            ->leftJoin('barangays as b', 'r.barangayId', 'b.id')
                            ->select('b.barangayName as barangay_name', 'r.*')
                            ->where('a.user_id', Auth::id())
                            ->get();
            return DataTables::of($resident)
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
        return view('secretary/resident', compact('resident', 'filter', 'brgy_id', 'filter_setting'));
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
