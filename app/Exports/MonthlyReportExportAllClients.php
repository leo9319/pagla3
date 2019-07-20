<?php
	namespace App\Exports;
	use Illuminate\Contracts\View\View;

	class MonthlyReportExportAllClients implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($clients, $period)
	    {
	        $this->clients = $clients;
			$this->period = $period;
	    }

		public function view(): View
    	{
        	return view('reports.excel.monthly.monthly_statement_all_clients')
        		->with('clients', $this->clients)
        		->with('period', $this->period);
    	}
	}
?>
