<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Barangay;
use App\Models\BarangaySetting;
use App\Models\File;
use App\Models\Zone;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Auth;

class FileController extends Controller
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

        // filter barangay ID
        $barangay_id = Account::barangayId();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        //load barangay table
        $file = [];
        if($request->ajax()) {
            $file = DB::table('files')
                            ->where('barangay_id', $barangay_id)
                            ->select('files.*',  DB::raw('DATE_FORMAT(created_at, \'%M %d, %Y\') as created_at'))
                            ->get();
                            return DataTables::of($file)
                            ->addIndexColumn()
                            ->addColumn('action', function ($row) {
                                // $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-success btn-sm deleteFile"><i class="bi-eye"></i> </a>';
                                // $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-secondary btn-sm editResident"><i class="bi-pencil-square"></i> </a>';
                                $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-danger btn-sm deleteFile"><i class="bi-trash"></i> </a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                    }
            return view('secretary.files', [
                'file' => $file, 
                'filter_setting' => $filter_setting,
                'filter_zone' => $filter_zone,
                'barangay_id' => $barangay_id
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
        // filter barangay ID
        $barangay_id = Account::barangayId();

        //  get barangay name 
        $barangay = Barangay::where('id', $request->barangay_id)
                        ->first();
    
        $request->validate([
            'filename' => 'required',
            'title' => 'required'
        ]);
        // get file name
        $fileName = $request->filename->getClientOriginalName();

        $file = str_replace(' ', '', $fileName);
        // move the image to banners folder
        $request->filename->move(public_path('files/'.$barangay->barangayName.'/'), $file);

        File::create([
            'barangay_id' => $request->barangay_id,
            'file' => $file,
            'title' => $request->title,
            'remarks' => $request->remarks 
        ]);

        return response()->json(['success' => 'Succcess']);


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
        $file_id = $request->id;

        $file_path = File::where('id', $file_id)
                        ->delete();

    }

    public function adminIndex(Request $request)
    {
    //load barangay table
    $file = [];
    if($request->ajax()) {
        $file = DB::table('files as f')
                        ->leftJoin('barangays as b', 'f.barangay_id', 'b.id')
                        ->select('f.*', 'b.barangayName as barangay', DB::raw('DATE_FORMAT(f.created_at, \'%M %d, %Y\') as created_at'))
                        ->get();
                        return DataTables::of($file)
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = '
                            <form method="GET" action="'.route("admin.certificate-download").'">
                            <input hidden class="form-control form-control-sm" name="id" value="'.$row->id.'">
                            <button type="submit" class="m-1 btn btn-outline-secondary btn-sm downloadCertificate"><i class="bi-download"></i></button>
                            </form>
                        ';
                        return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
                }
        return view('admin.files', [
            'file' => $file, 
        ]);
    }

    public function downloadCertificate(Request $request)
    {
        $file_id = $request->id;

        $barangay = DB::table('files as f')
                        ->leftJoin('barangays as b', 'f.barangay_id', 'b.id')
                        ->select('f.*', 'b.barangayName')
                        ->where('f.id', $file_id)
                        ->first();

        $filePath = public_path('files/'.$barangay->barangayName. '/'.$barangay->file);
        $headers = ['Content-Type: application/pdf'];
        $fileName = $barangay->file;

        return response()->download($filePath, $fileName, $headers);
    }
}
