<?php
	namespace App\Exports;
	use App\Product;
	use Illuminate\Contracts\View\View;

	class DailyReportExportDetailSales implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($detailed_sales, $start_date, $end_date)
	    {
	        $this->detailed_sales = $detailed_sales;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.dailyexcelDetailedSales')
        		->with('detailed_sales', $this->detailed_sales)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);
    	}
	}
?>