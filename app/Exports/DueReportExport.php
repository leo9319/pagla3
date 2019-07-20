<?php
	namespace App\Exports;
	use Illuminate\Contracts\View\View;

	class DueReportExport implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($parties)
	    {
	        $this->parties = $parties;
	    }

		public function view(): View
    	{
        	return view('reports.excel.dues')
        		->with('parties', $this->parties);
    	}
	}
?>
