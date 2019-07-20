<?php
	namespace App\Exports;
	use App\Product;
	use Illuminate\Contracts\View\View;

	class DailyReportExportDetailDiscount implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($detailed_discount, $start_date, $end_date)
	    {
	        $this->detailed_discount = $detailed_discount;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.dailyexcelDetailedDiscount')
        		->with('detailed_discount', $this->detailed_discount)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);
    	}
	}
?>