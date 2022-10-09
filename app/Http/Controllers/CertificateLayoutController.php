<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BarangaySetting;

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
    public function index()
    {
        // get current logo
        $filter_setting = BarangaySetting::filterSetting();

        return view('certificates/layout', compact('filter_setting'));
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
        $barangay_name = DB::table('accounts as a')
                            ->leftJoin('barangays as b', 'a.barangay_id', 'b.id')
                            ->select('b.barangayName')
                            ->where('a.user_id', Auth::id())
                            ->first();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        // $text = $section->addText($request->get('cert_type'));
        $text = $section->addText(
            'Republic of the Philippines', array('name' => 'Times New Roman', 'size' => 12)
        );
        $text = $section->addText(
            'Province of Cagayan', array('name' => 'Times New Roman', 'size' => 12)
        );
        $text = $section->addText(
            'Municipality of Baggao', array('name' => 'Times New Roman', 'size' => 12)
        );

        $text = $section->addText(
            'Barangay '.$barangay_name->barangayName.'', array('name' => 'Times New Roman', 'size' => 14)
        );
        $text = $section->addText(
            'TO WHOM IT MAY CONCERN:', array('name' => 'Times New Roman', 'size' => 12)
        );
        $section->addImage(public_path('images/baggao_logo.png'));  
        $text = $section->addText($request->get('cert_header'));
        $text = $section->addText($request->get('cert_title'));
        $text = $section->addText($request->get('paragraph1'));
        $text = $section->addText($request->get('paragraph2'));
        $text = $section->addText($request->get('paragraph3'));
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(''.$request->cert_type.'.docx');
        return response()->download(public_path('phpflow.docx'));
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
