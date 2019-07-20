<?php
	namespace App\Exports;
	use App\Product;
	use Illuminate\Contracts\View\View;

	class DailyReportExportDetailInv implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($number_of_invoices, $start_date, $end_date)
	    {
	        $this->number_of_invoices = $number_of_invoices;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.dailyexcelDetailedInvoice')
        		->with('number_of_invoices', $this->number_of_invoices)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);
    	}
	}
?>