<?php
	namespace App\Exports;
	use App\Product;
	use Illuminate\Contracts\View\View;

	class DailyReportExport implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($all_sales, $start_date, $end_date)
	    {
	        $this->all_sales  = $all_sales;
	        $this->start_date = $start_date;
	        $this->end_date   = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.dailyexcel')
        		->with('all_sales', $this->all_sales)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);

    	}
	}
?>