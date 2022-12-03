<?php

namespace App\Http\Controllers;

use App\Mail\IssueCertificate;
use App\Models\Account;
use App\Models\Barangay;
use App\Models\BarangaySetting;
use App\Models\IssuedCertificate;
use App\Models\Request as ModelsRequest;
use App\Models\ResidentAccount;
use App\Models\ResidentInformation;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestController extends Controller
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
        $filter_zone = Zone::zoneFilter();

        // get current barangay id
        $barangay_id = Account::barangayId();

            //load barangay table
            $requests = [];
            if($request->ajax()) {
                $requests = DB::table('requests as r')
                                    ->leftJoin('certificate_types as t', 'r.certificate_id', 't.id')
                                    ->leftJoin('resident_information as i', 'r.user_id', 'i.id')
                                    ->leftJoin('zones as z', 'i.zone', 'z.id')
                                    ->select('r.id as request_id', 'i.name', 'z.zone', 'r.purpose', DB::raw('DATE_FORMAT(r.created_at, \'%M %d, %Y\') as created_at'), 't.name as certificate')
                                    ->where('r.barangay_id', $barangay_id)
                                    ->where('r.status', 'pending')
                                    ->get();
    
                return DataTables::of($requests)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0);" data-id="'.$row->request_id.'" class="btn btn-outline-secondary btn-sm approveRequest"><i class="bi-check"></i> </a> ';
                        $btn .= '<a href="javascript:void(0);" data-id="'.$row->request_id.'" class="btn btn-outline-danger btn-sm deleteRequest"><i class="bi-exclamation-diamond-fill" ></i> </a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

        return view('secretary/request', compact( 'requests' ,'filter_setting', 'filter_zone'));
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
        $user= ResidentAccount::where('user_id', auth()->id())
                                ->select('residentinfo_id', 'barangay_id')
                                ->first();

            ModelsRequest::create([
                'barangay_id' => $user->barangay_id,
                'user_id' => $user->residentinfo_id,
                'certificate_id' => $request->cert_type,
                'purpose' => $request->purpose
            ]);

        return response()->json(['Success' => 'Request submitted successfully.', 'status' => 200]);
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
        DB::table('requests')
                ->where('id', $request->id)
                ->delete();
    }

    public function approveCertificate(Request $request)
    {

        $request = DB::table('requests')
                            ->where('id', $request->id)
                            ->first();

        $barangay_id = DB::table('requests')
                            ->where('barangay_id', $request->barangay_id)
                            ->first();
        
        //  get barangay name
        $barangay = Barangay::where('id', $barangay_id->barangay_id)->first();


        $resident = DB::table('resident_information as r')
                        ->leftJoin('zones as z', 'r.zone', 'z.id')
                        ->select('r.name', 'z.zone as zone_name')
                        ->where('r.id', $request->user_id)
                        ->first();

        $certificate = DB::table('certificate_layouts as l')
                                ->leftJoin('certificate_types as t', 'l.cert_type', 't.id')
                                ->select('t.id as type_id','t.name', 'l.*', 'l.id as layout_id')
                                ->where('t.id', $request->certificate_id)
                                ->first();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $paragraphStyleName1 = 'headerStyle';

        $paragraphStyleName2 = 'title1Style';

        $paragraphStyleName3 = 'title2Style';
        $paragraphStyleName4 = 'title3Style';
        $paragraphStyleName5 = 'title4Style';

        $phpWord->addParagraphStyle($paragraphStyleName1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 30]);

        $phpWord->addParagraphStyle($paragraphStyleName2, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 300]);

        $phpWord->addParagraphStyle($paragraphStyleName3, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 800]);
        $phpWord->addParagraphStyle($paragraphStyleName4, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore' => 1300, 'spaceAfter' => 1000]);
        $phpWord->addParagraphStyle($paragraphStyleName5, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END, 'spaceBefore' => 0, 'spaceAfter' => 0]);

        $section = $phpWord->addSection();

        $section->addText('Republic of the Philippines', ['name' => 'Times New Roman', 'size' => 12], $paragraphStyleName1);

        $section->addText('Province of Cagayan', ['name' => 'Times New Roman', 'size' => 12], $paragraphStyleName1);
        $section->addText('Municipality of Baggao', ['name' => 'Times New Roman', 'size' => 12], $paragraphStyleName1);
        $section->addText('Barangay ' . $barangay->barangayName . '', ['name' => 'Times New Roman', 'size' => 14], $paragraphStyleName1);
        $section->addImage(public_path('certificate_logos/' . $certificate->logo1 . ''), [
            'width' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
            'height' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
            'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
            'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_MARGIN,
            'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_MARGIN,
            'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(15.5),
            'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.55),
        ]);
        $section->addImage(public_path('certificate_logos/' . $certificate->logo2 . ''), [
            'width' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
            'height' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
            'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_MARGIN,
            'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_MARGIN,
            'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(15.5),
            'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.55),
        ]);

        //  certificate header
        $section->addText($certificate->cert_header, ['name' => 'Times New Roman', 'size' => 16, 'upperCase' => true], $paragraphStyleName2);

        // certificate type
        $section->addText($certificate->cert_title, ['name' => 'Times New Roman', 'size' => 20, 'upperCase' => true, 'underline' => 'single'], $paragraphStyleName3);

        $text = $section->addText('TO WHOM IT MAY CONCERN:', ['name' => 'Times New Roman', 'size' => 12, 'spaceAfter' => 500]);

        $section->addText('        THIS IS TO CERTIFY that ' . $resident->name . ' is a bonafide resident of ' . $barangay->barangayName . ' ,Baggao Cagayan. Located at ' . $resident->zone_name . '.', ['name' => 'Times New Roman', 'size' => 12, 'spaceBefore' => 300, 'spaceAfter' => 300]);

        $section->addText('        ' . $certificate->paragraph2, $paragraphStyleName2, ['size' => 13, 'spaceBefore' => 300, 'spaceAfter' => 300]);
        $section->addText('        ' . $certificate->paragraph3, $paragraphStyleName2, ['size' => 13, 'spaceBefore' => 300, 'spaceAfter' => 300]);

        $time = Carbon::now();

        $section->addText('        Done this ' . $time->format('jS') . ' day of ' . $time->format('F Y') . ' at Barangay ' . $barangay->barangayName . ', Baggao, Cagayan', $paragraphStyleName2, ['size' => 13, 'spaceBefore' => 300, 'spaceAfter' => 300]);

        $section->addText('Certified Correct:', ['name' => 'Times New Roman', 'size' => 12, 'bold' => true], $paragraphStyleName4);
        $section->addText(
            $barangay->barangayCaptain,
            [
                'name' => 'Times New Roman',
                'size' => 14,
                'underline' => 'single',
                'bold' => true,
            ],
            $paragraphStyleName5,
        );
        $removeSpace = str_replace(' ', '', $resident->name);
        $fileName = Carbon::now()->toDateString() . $removeSpace;
        $section->addText(
            'Punong Barangay',
            [
                'name' => 'Times New Roman',
                'size' => 12,
                'italic' => true,
            ],
            $paragraphStyleName5,
        );
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('certificates/' . $fileName . '.docx');

        IssuedCertificate::create([
            'barangay_id' => $request->barangay_id,
            'resident_id' => $request->user_id,
            'certificate_typeId' => $certificate->type_id,
            'certificate_layoutId' => $certificate->layout_id,
            'certificate_path' => $fileName,
        ]);

        DB::table('requests')
            ->where('id', $request->id)
            ->update([
                'status' => 'issued'
        ]);
        $email = DB::table('resident_accounts as a')
                        ->leftJoin('users as u', 'a.user_id', 'u.id')
                        ->where('residentinfo_id', $request->user_id)
                        ->select('u.email')
                        ->first();

        $user = DB::table('requests as r')
                    ->leftJoin('resident_information as i', 'r.user_id', 'i.id')
                    ->leftJoin('certificate_types as t', 'r.certificate_id', 't.id')
                    ->leftJoin('barangays as b', 'r.barangay_id', 'b.id')
                    ->leftJoin('barangay_settings as s', 'r.barangay_id', 's.barangay_id')
                    ->select('i.name as name', 't.name as certificate', 'b.barangayName', 's.logo as logo')
                    ->first();

        Mail::to($email->email)->send(new IssueCertificate($user));

        return response()->json('Certificate issued successfully.');
    }
}
