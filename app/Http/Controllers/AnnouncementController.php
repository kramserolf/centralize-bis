<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BarangaySetting;
use App\Models\Account;
use App\Models\Zone ;
use DataTables;

class AnnouncementController extends Controller
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

        $barangay_id = Account::barangayId();

        //load barangay table
        $announcement = [];
           if($request->ajax()) {
               $announcement = DB::table('announcements as a')
                                        ->where('barangay_id', $barangay_id)
                                        ->get();
   
               return DataTables::of($announcement)
                   ->addIndexColumn()
                   ->addColumn('action', function ($row) {
                       $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteResidentAccount"><i class="bi-trash" ></i> </a>';
                       return $btn;
                   })
                   ->rawColumns(['action'])
                   ->make(true);
           }
  
          return view('secretary/announcements', compact( 'announcement' ,'filter_setting'));

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
        //
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
