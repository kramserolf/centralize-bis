<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;


class CertificateController extends Controller
{
    public function generatePdf()
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHtml('<h1>This is a test</h1>');
        return $pdf->stream();
    }
}
