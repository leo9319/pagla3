<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\InvoiceExport;

class ExcelController extends Controller
{
    public function ExportClients()
    {
    	$num = 2;
    	return Excel::download(new InvoiceExport($num), 'invoices.xlsx');
    }
}
