<?php
	namespace App\Exports;
	use Illuminate\Contracts\View\View;

	class MonthlyReportExportDetailSales implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($detailed_sales_monthly, $start_month, $start_year, $end_month, $end_year, $start_date, $end_date)
	    {
	        $this->detailed_sales_monthly = $detailed_sales_monthly;
	        $this->start_month = $start_month;
	        $this->start_year = $start_year;
	        $this->end_month = $end_month;
	        $this->end_year = $end_year;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.monthly.monthlyexcelDetailedSales')
        		->with('detailed_sales_monthly', $this->detailed_sales_monthly)
        		->with('start_month', $this->start_month)
        		->with('end_month', $this->end_month)
        		->with('end_year', $this->end_year)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);
    	}
	}
?>
