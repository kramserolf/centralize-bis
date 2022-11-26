<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Barangay;
use App\Models\BarangaySetting;
use App\Models\Blotter;
use App\Models\ResidentInformation;
use App\Models\User;
use DataTables;

class BlotterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_setting = BarangaySetting::filterSetting();
        $residents = ResidentInformation::select('id', 'name')
                            ->get();
        $blotter = [];
        if($request->ajax()) {
            $blotter = DB::table('blotters as b')
                            ->leftJoin('resident_information as i', 'b.user_id', 'i.id')
                            ->leftJoin('accounts as a', 'b.barangay_id', 'a.barangay_id')
                            ->select('b.*', 'i.name as complainant', DB::raw('DATE_FORMAT(b.schedule_date, \'%M %d, %Y\') as date'))
                            ->where('a.user_id', Auth::id())
                            ->get();
            return DataTables::of($blotter)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm viewBlotter"><i class="bi-eye"></i> </a> ';
                    // $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editBlotter"><i class="bi-pencil"></i> </a> ';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteBlotter"><i class="bi-trash"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('secretary/blotter', compact('blotter', 'filter_setting', 'residents'));
    }

    public function adminIndex(Request $request)
    {
        $blotter = [];
        if($request->ajax()) {
            $blotter = DB::table('blotters as b')
                            ->leftJoin('barangays as y', 'b.barangay_id', 'y.id')
                            ->select('b.*', 'y.barangayName as barangay')
                            ->get();
            return DataTables::of($blotter)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm viewBlotter"><i class="bi-eye"></i> </a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin/blotter', compact('blotter'));
    }

    public function viewBlotter(Request $request)
    {
        $blotters = DB::table('blotters as b')
                            ->leftJoin('barangays as y', 'b.barangay_id', 'y.id')
                            ->leftJoin('resident_information as r', 'b.user_id', 'r.id')
                            ->select('b.*', 'y.barangayName', 'r.name as complainant')
                            ->first();
        return response()->json($blotters);
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
            'user_id' => 'required',
            'incident_type' => 'required|string',
            'respondents' => 'required',
            'date_reported' => 'required',
            'schedule_date' => 'required',
            'narrative' => 'required|string'
        ]);

        $barangay = DB::table('accounts')
                        ->select('barangay_id')
                        ->where('user_id', Auth::id())
                        ->first();

        $blotter = Blotter::updateOrCreate(
            ['id' => $request->id],
            [
            'barangay_id' => $barangay->barangay_id,
            'user_id' => $request->user_id,
            'respondents' => $request->respondents,
            'incident_type' => $request->incident_type,
            'schedule_date' => $request->schedule_date,
            'date_reported' => $request->date_reported,
            'location' => $request->location,
            'narrative' => $request->narrative,
        ]);

        return response($blotter);
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
    public function edit(Request $request)
    {
        $blotters = DB::table('blotters as b')
                            ->leftJoin('resident_information as i', 'b.user_id', 'i.id')
                            ->leftJoin('accounts as a', 'b.barangay_id', 'a.barangay_id')
                            ->select('b.*', 'i.name as complainant')
                            ->where('b.id', $request->id)
                            ->first();
        return response()->json($blotters);
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
        Blotter::where('id', $request->id)
                    ->delete();
        return response()->json(['success' => 'Blotter deleted successfully']);
    }
}
