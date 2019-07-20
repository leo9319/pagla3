<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function getPDF()
    {
    	$pdf = PDF::loadView('pdf.customer');
    	return $pdf->download('Monthly Statement.pdf');
    }
}
