<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BarangaySetting;
use App\Models\Account;
use App\Models\CertificateLayout;
use App\Models\CertificateType;
use Yajra\DataTables\DataTables;

use function PHPUnit\Framework\returnSelf;

class CertificateLayoutController extends Controller
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
        $barangay = Account::where('user_id', Auth::id())
                            ->first();

        $cert_type = CertificateType::all();

         //load barangay table
         $certificate_layout = [];
         if($request->ajax()) {
             $certificate_layout = DB::table('certificate_layouts as l')
                                     ->leftJoin('certificate_types as t', 'l.cert_type', 't.id')
                                     ->select('l.id', 't.name', DB::raw('DATE_FORMAT(l.updated_at, \'%M %d, %Y\') as updated_at'))
                                     ->where('l.barangay_id', $barangay->barangay_id)
                                     ->get();
           
             return DataTables::of($certificate_layout)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editCertificateLayout"><i class="bi-pencil-square"></i> </a> ';
                     $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteCertificateLayout"><i class="bi-trash" ></i> </a>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }

        return view('certificates/layout', compact( 'certificate_layout' ,'filter_setting', 'cert_type'));
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
        // get barangay id
        $barangay_id = Account::barangayId();

        $request->validate([
            'paragraph2' => 'required|string',
            'logo1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1280',
            'logo2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1280',
            'cert_type' => 'required',
            'cert_header' => 'required|string',
            'cert_title' => 'required|string'
        ]); 


        if(empty($request->file('logo1'))){
            $logo1 = $request->edit_logo1;
        } else {

             $logo1 = $request->logo1->getClientOriginalName();
             $request->logo1->move(public_path('certificate_logos/'), $logo1);
        }

        if(empty($request->file('logo2'))){
            
            $logo2 = $request->edit_logo2;
        } else {

             $logo2 = $request->logo2->getClientOriginalName();
             $request->logo2->move(public_path('certificate_logos/'), $logo2);
        }
    

        CertificateLayout::updateOrCreate(
             ['id' => $request->id]   ,
            [
            'barangay_id' => $barangay_id,
            'cert_type' => $request->cert_type,
            'logo1' => $logo1,
            'logo2' => $logo2,
            'cert_header' => $request->cert_header,
            'cert_title' => $request->cert_title,
            'paragraph2' => $request->paragraph2,
            'paragraph3' => $request->paragraph3,
        ]);

        return response()->json('Certificate Layout created successfully');

        // return response()->download(public_path('certificate_layouts/'.$request->cert_type.'.docx'));
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
        $layout = DB::table('certificate_layouts as l')
                                ->leftJoin('certificate_types as t', 'l.cert_type', 't.id')
                                ->select('l.*', 't.name')
                                ->where('l.id', $request->id)
                                ->first();
        return response()->json($layout);
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
        CertificateLayout::where('id', $request->id)
                        ->delete();
    }
}
