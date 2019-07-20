<?php
	namespace App\Exports;
	use Illuminate\Contracts\View\View;

	class MonthlyReportExportDetailInv implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($number_of_invoices, $start_month, $start_year, $end_month, $end_year, $start_date, $end_date)
	    {
	        $this->number_of_invoices = $number_of_invoices;
	        $this->start_month = $start_month;
	        $this->start_year = $start_year;
	        $this->end_month = $end_month;
	        $this->end_year = $end_year;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.monthly.monthlyexcelDetailedInvoices')
        		->with('number_of_invoices', $this->number_of_invoices)
        		->with('start_month', $this->start_month)
        		->with('end_month', $this->end_month)
        		->with('end_year', $this->end_year)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);
    	}
	}
?>
