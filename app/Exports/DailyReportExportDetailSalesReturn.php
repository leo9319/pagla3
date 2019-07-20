<?php
	namespace App\Exports;
	use App\Product;
	use Illuminate\Contracts\View\View;

	class DailyReportExportDetailSalesReturn implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($detailed_sales_returns, $start_date, $end_date)
	    {
	        $this->detailed_sales_returns = $detailed_sales_returns;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.dailyexcelDetailedSalesReturn')
        		->with('detailed_sales_returns', $this->detailed_sales_returns)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);
    	}
	}
?>