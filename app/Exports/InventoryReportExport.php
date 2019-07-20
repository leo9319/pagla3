<?php
	namespace App\Exports;
	use Illuminate\Contracts\View\View;

	class InventoryReportExport implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($inventories)
	    {
	        $this->inventories = $inventories;
	    }

		public function view(): View
    	{
        	return view('reports.excel.inventory.inventoryexcel')
        		->with('inventories', $this->inventories);
    	}
	}
?>
