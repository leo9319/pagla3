<?php
	namespace App\Exports;
	use App\Sale;
	use DB;
	use DatePeriod;
	use DateInterval;
	use DateTime;
	use Illuminate\Contracts\View\View;

	class DisapprovedSalesExport implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($parties, $start_date, $end_date)
	    {
	        $this->parties = $parties;
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	    }

		public function view(): View
    	{

			$begin = new DateTime($this->start_date);
			$end = new DateTime($this->end_date);

			$interval = DateInterval::createFromDateString('1 month');
			$period = new DatePeriod($begin, $interval, $end);

        	return view('reports.excel.monthly.disapproved_invoices')
        		->with('period', $period)
        		->with('parties', $this->parties)
        		->with('start_date', $this->start_date)
        		->with('end_date', $this->end_date);

    	}
	}
?>