<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BarangaySetting;
use App\Models\Account;
use App\Models\CertificateType;
use DataTables;

class CertificateTypeController extends Controller
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


        // get current barangay id
        $barangay_id = Account::barangayId();

         //load barangay table
         $certificate_type = [];
         if($request->ajax()) {
             $certificate_type = DB::table('certificate_types as t')
                                        ->where('t.barangay_id', $barangay_id)
                                        ->get();
 
             return DataTables::of($certificate_type)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editCertificateType"><i class="bi-pencil-square"></i> </a> ';
                     $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteCertificateType"><i class="bi-trash" ></i> </a>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }

        return view('certificates/types', compact( 'certificate_type' ,'filter_setting'));
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
            'name' => 'required|string'
        ]);

        //filter barangay id
        $barangay_id = Account::barangayId();

        $certificateType = CertificateType::updateOrCreate([
                                    'id' => $request->id
                                ],
                                [
                                    'barangay_id' => $barangay_id,
                                    'name' => $request->name,
                                    'purpose' => $request->purpose,
                                ]);
        //     ['id' => $requ]
        //     [
        //     'id' => $request
        //     'barangay_id' => $barangay_id,
        //     'name' => $request->name,
        //     'purpose' => $request->purpose,
        // ]);
        return response()->json($certificateType);
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

        //filter barangay id
        $barangay_id = Account::barangayId();

        $certificate_type = DB::table('certificate_types as t')
                                ->leftJoin('barangays as b', 't.barangay_id', 'b.id')
                                ->where('t.id', $request->id)
                                ->first();
        return response()->json($certificate_type);
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
        CertificateType::where('id', $request->id)
                        ->delete();
    }
}
