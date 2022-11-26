<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\BarangaySetting;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Client\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        // get current logo
        $filter_setting = BarangaySetting::filterSetting();

        // filter Zone
        $filter_zone = Zone::zoneFilter();

        $barangay_id = Account::barangayId();
        $certificate = [];
        if($request->ajax()) {
            $certificate = DB::table('issued_certificates as i')
                                    ->leftJoin('resident_information as r', 'i.resident_id', 'r.id')
                                    ->leftJoin('certificate_types as t', 'i.certificate_typeId', 't.id')
                                    ->leftJoin('zones as z', 'r.zone', 'z.id')
                                    ->select('i.id', 'r.name', 'z.zone', 't.name as certificate', 't.purpose', 'i.certificate_path', DB::raw('DATE_FORMAT(i.created_at, \'%M %d, %Y\') as issue_date'))
                                    ->where('r.barangayId', $barangay_id)
                                    ->orderBy('i.created_at', 'desc')
                                    ->get();
            return DataTables::of($certificate)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                        <form method="GET" action="'.route("certificate.download").'">
                        <input hidden class="form-control form-control-sm" name="certificate" value="'.$row->certificate_path.'">
                        <button type="submit" class="m-1 btn btn-outline-secondary btn-sm downloadCertificate"><i class="bi-download"></i></button>
                        </form>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('secretary.certificate', compact('certificate', 'filter_setting', 'filter_zone', ));
    }

    public function downloadCertificate(Request $request)
    {
        $filePath = public_path('certificates/'.$request->certificate.'.docx');
        $headers = ['Content-Type: application/pdf'];
        $fileName = $request->certificate.'.docx';

        return response()->download($filePath, $fileName, $headers);
    }
}
