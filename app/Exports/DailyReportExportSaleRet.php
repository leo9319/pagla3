<?php
	namespace App\Exports;
	use App\Product;
	use Illuminate\Contracts\View\View;

	class DailyReportExportSaleRet implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($all_sales_return, $start_date, $end_date)
	    {
	        $this->all_sales_return = $all_sales_return;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.dailyexcelSaleRet')
        		->with('all_sales_return', $this->all_sales_return)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);

    	}
	}
?>