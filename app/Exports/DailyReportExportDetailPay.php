<?php
	namespace App\Exports;
	use App\Product;
	use Illuminate\Contracts\View\View;

	class DailyReportExportDetailPay implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($detailed_payment_received, $start_date, $end_date)
	    {
	        $this->detailed_payment_received = $detailed_payment_received;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{
        	return view('reports.excel.dailyexcelDetailedPayment')
        		->with('detailed_payment_received', $this->detailed_payment_received)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);

    	}
	}
?>