<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\BarangaySetting;
use App\Models\Account;
use App\Models\Announcement;
use DataTables;


class AnnouncementController extends Controller
{
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
                       $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editAnnouncement"><i class="bi-pencil-square"></i> </a> ';
                       $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteAnnouncement"><i class="bi-trash" ></i> </a>';
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
        $request->validate([
            'title' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1920',
        ]);
        // barangay id
        $barangay_id = Account::barangayId();

        // get the image name
        if(!empty($request->image)){         
            $imageName = $request->image->getClientOriginalName();

            // move the image to the folder
            $request->image->move(public_path('images/announcements'), $imageName);
        } else{
            $imageName = null;
        }



        Announcement::create([
            'barangay_id' => $barangay_id,
            'title' => $request->title,
            'content' => $request->content,
            'image'=> $imageName,
            'date' => $request->date,
            'location' => $request->location
        ]);

        return response()->json('Announcement created successfully');
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
        $image_path = Announcement::where('id', $request->id)
                            ->first();
        // delete the image from the folder
        File::delete(public_path('images/announcements/'.$image_path->image.''));

        // delete the data in announcement table
        Announcement::where('id', $request->id)
                        ->delete();
        
    }
}