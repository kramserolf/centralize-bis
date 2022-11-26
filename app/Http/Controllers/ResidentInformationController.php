<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ResidentInformation;
use App\Models\BarangaySetting;
use App\Models\CertificateLayout;
use App\Models\CertificateType;
use App\Models\Account;
use App\Models\Barangay;
use App\Models\IssuedCertificate;
use App\Models\Zone;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Shared\Converter;

class ResidentInformationController extends Controller
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
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();

        // filter barangay ID
        $barangay_id = Account::barangayId();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        // get certificates
        $certificate = DB::table('certificate_layouts as l')
                            ->leftJoin('certificate_types as t', 'l.cert_type', 't.id')
                            ->select('l.id', 't.name')
                            ->where('l.barangay_id', $barangay_id)
                            ->get();
        
        // load resident table
        $resident = [];
        if($request->ajax()) {
            $resident = DB::table('resident_information as r')
                            ->leftJoin('zones as z', 'r.zone', 'z.id')
                            ->select('r.household_no', 'r.name', 'r.cp_number', 'r.id', 'z.zone as zone_name')
                            ->where('r.barangayId', $barangay_id)
                            ->orderBy('r.household_no', 'asc')
                            ->get();
                            
            return DataTables::of($resident)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-success btn-sm viewResident"><i class="bi-eye"></i> </a>';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-success btn-sm generateResidentAccount"><i class="bi-key-fill"></i> </a>';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-secondary btn-sm editResident"><i class="bi-pencil-square"></i> </a>';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-danger btn-sm deleteResident"><i class="bi-trash"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('secretary/resident', [
            'resident' => $resident, 
            'filter_setting' => $filter_setting,
            'filter_zone' => $filter_zone,
            'certificate' => $certificate,
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
        $brgy_id = DB::table('barangays as b')
                        ->leftJoin('accounts as a', 'b.id', 'a.barangay_id')
                        ->select('b.id as id', 'b.barangayName as barangay')
                        ->where('a.user_id', Auth::id())
                        ->first();
  
        ResidentInformation::updateOrCreate(
            ['id' => $request->id],
            [
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
            'cp_number' =>   $request->cp_number,
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
    public function edit(Request $request)
    {
        $id = [
            'id' => $request->id
        ];

        $resident_id = ResidentInformation::where($id)
                        ->first();
        return response()->json($resident_id);
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

    // get certificate layout
    public function getCertificateLayout(Request $request)
    {
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();

        // filter barangay ID
        $barangay_id = Account::barangayId();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        // get certificates
        $certificate = DB::table('certificate_layouts as l')
                            ->leftJoin('certificate_types as t', 'l.cert_type', 't.id')
                            ->select('l.id', 't.name', 'l.cert_type')
                            ->where('l.barangay_id', $barangay_id)
                            ->get();
                // load resident table
        $resident = [];
        if($request->ajax()) {
            $resident = DB::table('resident_information as r')
                            ->leftJoin('zones as z', 'r.zone', 'z.id')
                            ->select('r.household_no', 'r.name', 'r.cp_number', 'r.id as id', 'z.zone as zone_name')
                            ->where('r.barangayId', $barangay_id)
                            ->orderBy('r.household_no', 'asc')
                            ->get();

            return DataTables::of($resident)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-secondary btn-sm issueCertificate"><i class="bi-file-earmark-pdf-fill"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('certificates/certificate', [
            'resident' => $resident, 
            'filter_setting' => $filter_setting,
            'filter_zone' => $filter_zone,
            'certificate' => $certificate,
        ]);

    }

    function printSeparator(Section $section)
    {
        $section->addTextBreak();
        $lineStyle = array('weight' => 0.2, 'width' => 20, 'height' => 0, 'align' => 'left');
        $section->addLine($lineStyle);
        $section->addTextBreak(2);
    }
    // issue certificate
    public function issueCertificate(Request $request)
    {

         // get barangay id
         $barangay_id = $request->barangay_id;

        //  get barangay name 
        $barangay = Barangay::where('id', $barangay_id)
                        ->first();

        //  resident id
        $resident_id = $request->resident_id;

        $resident = ResidentInformation::where('id', $resident_id)
                            ->select('name', 'zone')
                            ->first();
        $zone = Zone::where('id', $resident->zone)
                        ->select('zone')
                        ->first();

        // certificate layout id
        $certificateLayout_id = $request->cert_type;

        // get certificate layout
        $certificate =  DB::table('certificate_layouts as l')
                                ->leftJoin('certificate_types as t', 'l.cert_type', 't.id')
                                ->select('l.*', 't.name', 't.id as type_id')
                                ->where('l.id', $certificateLayout_id)
                                ->first();

        // $certificate_type = DB::table('certificate_types as t')
        //                         ->leftJoin('certificate_layouts as l', 't.id', 'l.cert_type')
        //                         ->select('t.name', 't.id')
        //                         ->first();


         $phpWord = new \PhpOffice\PhpWord\PhpWord();
 
         $paragraphStyleName1 = 'headerStyle';

         $paragraphStyleName2 = 'title1Style';

         $paragraphStyleName3 = 'title2Style';
         $paragraphStyleName4 = 'title3Style';
         $paragraphStyleName5 = 'title4Style';
         
        
         $phpWord->addParagraphStyle($paragraphStyleName1, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 30));

         $phpWord->addParagraphStyle($paragraphStyleName2, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 300));

         $phpWord->addParagraphStyle($paragraphStyleName3, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 800));
         $phpWord->addParagraphStyle($paragraphStyleName4, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore' => 1300, 'spaceAfter' => 1000));
         $phpWord->addParagraphStyle($paragraphStyleName5, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END, 'spaceBefore' => 0, 'spaceAfter' => 0));
         
         $section = $phpWord->addSection();

        $section->addText(
            'Republic of the Philippines', array('name' => 'Times New Roman', 'size' => 12), $paragraphStyleName1
        );
        
        $section->addText(
            'Province of Cagayan', array('name' => 'Times New Roman', 'size' => 12), $paragraphStyleName1
        );
        $section->addText(
            'Municipality of Baggao', array('name' => 'Times New Roman', 'size' => 12), $paragraphStyleName1
        );
        $section->addText(
            'Barangay '.$barangay->barangayName.'', array('name' => 'Times New Roman', 'size' => 14), $paragraphStyleName1
        );
        $section->addImage(
            public_path('certificate_logos/'.$certificate->logo1.''),
            array(
                'width'            => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
                'height'           => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
                'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
                'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_MARGIN,
                'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_MARGIN,
                'marginLeft'       => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(15.5),
                'marginTop'        => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.55),
            )
        );
        $section->addImage(
            public_path('certificate_logos/'.$certificate->logo2.''),
            array(
                'width'            => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
                'height'           => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
                'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
                'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_MARGIN,
                'posVerticalRel'   => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_MARGIN,
                'marginLeft'       => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(15.5),
                'marginTop'        => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.55),
            )
        );


        //  certificate header
        $section->addText(
            $certificate->cert_header, array('name' => 'Times New Roman', 'size' => 16, 'upperCase' => true), $paragraphStyleName2 
        );

        // certificate type
        $section->addText(
            $certificate->cert_title, array('name' => 'Times New Roman', 'size' => 20, 'upperCase' => true, 'underline' => 'single'), $paragraphStyleName3 
        );

         $text = $section->addText(
             'TO WHOM IT MAY CONCERN:', array('name' => 'Times New Roman', 'size' => 12, 'spaceAfter' => 500)
         ); 


         $section->addText(
            '        THIS IS TO CERTIFY that '.$resident->name.' is a bonafide resident of '.$barangay->barangayName. ' ,Baggao Cagayan. Located at '.$zone->zone.'.', array('name' => 'Times New Roman', 'size' => 12, 'spaceBefore' => 300, 'spaceAfter' => 300)
        );

         $section->addText('        '.$certificate->paragraph2 ,$paragraphStyleName2, array('size' => 13, 'spaceBefore' => 300, 'spaceAfter' => 300));
         $section->addText('        '.$certificate->paragraph3 ,$paragraphStyleName2, array('size' => 13, 'spaceBefore' => 300, 'spaceAfter' => 300));

         $time = Carbon::now();

         $section->addText(
            '        Done this '.$time->format('jS').' day of '.$time->format('F Y').' at Barangay '.$barangay->barangayName.', Baggao, Cagayan', $paragraphStyleName2, array('size' => 13, 'spaceBefore' => 300, 'spaceAfter' => 300)
         );

         $section->addText(
            'Certified Correct:', array('name' => 'Times New Roman', 'size' => 12, 'bold' =>true), $paragraphStyleName4
        );
         $section->addText($barangay->barangayCaptain, array(
            'name' => 'Times New Roman', 'size' => 14, 'underline' => 'single' , 'bold' => true), $paragraphStyleName5
        );
         $removeSpace = str_replace(' ', '', $resident->name);
         $fileName = Carbon::now()->toDateString().$removeSpace;
         $section->addText('Punong Barangay', array(
            'name' => 'Times New Roman', 'size' => 12 , 'italic' => true), $paragraphStyleName5
        );
         $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('certificates/'.$fileName.'.docx');


         IssuedCertificate::create([
            'barangay_id' => $barangay_id,
            'resident_id' => $resident_id,
            'certificate_typeId' => $certificate->type_id,
            'certificate_layoutId' =>  $certificateLayout_id,
            'certificate_path' => $fileName
         ]);

         return response()->json('Certificate issued successfully.');
    }

    // household list
    public function household(Request $request)
    {
         // get current barangay setting
         $filter_setting = BarangaySetting::filterSetting();

         $household = [];
         if($request->ajax()) {
             $household = DB::table('resident_information as r')
                            ->leftJoin('accounts as a', 'r.barangayId', 'a.barangay_id')
                            ->leftJoin('zones as z', 'r.zone', 'z.id')
                            ->select('r.id', 'r.household_no', 'r.name', 'z.zone', 'r.cp_number')
                            ->where('a.user_id', Auth::id())
                            ->groupBy('r.household_no')
                            ->orderBy('r.household_no', 'asc')
                            ->get();
             return DataTables::of($household)
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
         return view('secretary/household', [
             'household' => $household, 
             'filter_setting' => $filter_setting,
         ]);
    }

    // senior citizen list
    public function senior(Request $request)
    {
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        // load resident table
        $senior = [];
        if($request->ajax()) {
            $senior = DB::table('resident_information as r')
                                    ->leftJoin('accounts as a', 'r.barangayId', 'a.barangay_id')
                                    ->leftJoin('zones as z', 'r.zone', 'z.id')
                                    ->select('z.zone as zone', 'r.household_no', 'r.name', 'r.age', 'r.id')
                                    ->where('a.user_id', Auth::id())
                                    ->where('r.age', '>=', 60)
                                    ->orderBy('z.zone', 'asc')
                                    ->get();
            return DataTables::of($senior)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class=" m-1 btn btn-outline-success btn-sm viewResident"><i class="bi-eye"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('secretary/senior_citizen', [
            'senior' => $senior, 
            'filter_setting' => $filter_setting,
            'filter_zone' => $filter_zone,
        ]);
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

    public function residentPerZone(Request $request)
    {
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();

        // filter barangay ID
        $barangay_id = Account::barangayId();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        // get certificates
        $certificate = DB::table('certificate_layouts as l')
                            ->leftJoin('certificate_types as t', 'l.cert_type', 't.id')
                            ->select('l.id', 't.name')
                            ->where('l.barangay_id', $barangay_id)
                            ->get();
        
        // load resident table
        $resident = [];
        if($request->ajax()) {
            $resident = DB::table('resident_information as r')
                            ->leftJoin('zones as z', 'r.zone', 'z.id')
                            ->select('r.household_no', 'r.name', 'r.cp_number', 'r.id', 'z.zone as zone_name', 'r.zone')
                            ->where('r.barangayId', $barangay_id)
                            ->orderBy('r.household_no', 'asc')
                            ->get();
                            
            return DataTables::of($resident)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="m-1 btn btn-outline-success btn-sm viewResident"><i class="bi-eye"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('secretary/resident_per_zone', [
            'resident' => $resident, 
            'filter_setting' => $filter_setting,
            'filter_zone' => $filter_zone,
            'certificate' => $certificate,
        ]);
    }

    public function filterZone(Request $request)
    {
        // get current barangay setting
        $filter_setting = BarangaySetting::filterSetting();
        // filter barangay ID
        $barangay_id = Account::barangayId();
        // filter Zone
        $filter_zone = Zone::zoneFilter();

        $result = '';
        if($request->ajax()){
            $result = DB::table('resident_information as r')
                            ->leftJoin('zones as z', 'r.zone', 'z.id')
                            ->select('r.id','r.household_no', 'r.name', 'r.cp_number', 'r.id', 'z.zone as zone_name', 'r.zone')
                            ->where('r.barangayId', $barangay_id)
                            ->where('r.zone', $request->zone)
                            ->orderBy('r.household_no', 'asc')
                            ->get();
            if($result){
                foreach($result as $key => $resident){
                    $result .='<tr style="font-size: 15px">'.
                    '<td>'.$resident->household_no.'</td>'.
                    '<td>'.$resident->name.'</td>'.
                    '<td>'.$resident->zone_name.'</td>'.
                    '<td>'.$resident->cp_number.'</td>'.
                '</tr>';
                }
                return response($result);
            }
        }
        return view('secretary/resident_per_zone', compact('result'));
    }
    public function search(Request $request)
    {
        // filter barangay ID
        $barangay_id = Account::barangayId();
        $output = "";
        if($request->ajax()){
            $residents = DB::table('resident_information as r')
                    ->leftJoin('zones as z', 'r.zone', 'z.id')
                    ->select('r.*','z.zone as zone_name')
                    ->where('r.name', 'LIKE', '%'.$request->search."%")
                    ->where('r.barangayId', $barangay_id)
                    ->get();
            if($residents){
                foreach($residents as $key => $resident){
                    $output .='<tr style="font-size: 15px">'.
                    '<td>'.$resident->household_no.'</td>'.
                    '<td>'.$resident->name.'</td>'.
                    '<td>'.$resident->zone_name.'</td>'.
                    '<td>'.$resident->cp_number.'</td>'.
                '</tr>';
                }
                return response($output);
            }
        }
    }
}
