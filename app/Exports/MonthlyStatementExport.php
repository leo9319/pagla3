<?php
	namespace App\Exports;
	use App\Party;
	use App\Sale;
	use App\Sales_return;
	use DB;
	use Illuminate\Contracts\View\View;

	class MonthlyStatementExport implements \Maatwebsite\Excel\Concerns\FromView
	{
		public function __construct($start_date, $end_date, $party_id)
	    {
	        $this->start_date = $start_date;
	        $this->end_date = $end_date;
	        $this->party_id = $party_id;
	    }

		public function view(): View
    	{
    		$client_profile = Party::find($this->party_id);
    		$client_name = $client_profile->party_name;
    		$client_code = $client_profile->party_id;
    		$client_address = $client_profile->address;
    		$all_sales = Sale::where('client_id', $this->party_id)->get();
    		$all_sales_return = Sales_return::where('client_id', $this->party_id)->get();

			$sales_return_payment_joined = DB::table('sales AS S')
    			->select('S.date AS sales_date', 'S.amount_after_discount AS sales_amount', 'SR.date AS sales_return_date', 'SR.amount_after_discount AS sales_return_amount', 'S.created_at as sales_create', 'SR.created_at AS return_create', 'SR.id AS return_id', 'S.id AS sale_id', 'PR.date AS received_date', 'PR.paid_amount AS amount_received', 'PR.id AS received_id')
    			->join('sales_returns AS SR', 'S.client_id', 'SR.client_id')
    			->join('payment_receiveds AS PR', 'S.client_id', 'PR.client_code')
    			->where('PR.cheque_clearing_status', '!=', 'Due')
    			->where('S.client_id', $this->party_id)
    			->where('S.date', '>=', $this->start_date)
    			->where('S.date', '<=', $this->end_date)
    			->where('SR.date', '>=', $this->start_date)
    			->where('SR.date', '<=', $this->end_date)
    			->where('S.audit_approval', 1)
    			->where('S.management_approval', 1)
    			->where('SR.audit_approval', 1)
    			->where('SR.management_approval', 1)
    			->where('PR.sales_approval', 1)
    			->where('PR.management_approval', 1)
    			->get();

			$sales = DB::table('sales AS S')
						->select('S.amount_after_discount AS sales_amount')
						->where('S.client_id', $this->party_id)
						->where('S.date', '>=', $this->start_date)
						->where('S.date', '<=', $this->end_date)
						->where('S.audit_approval', 1)
						->where('S.management_approval', 1)
						->get();

			$sum_of_sales = $sales->sum('sales_amount');

			$return = DB::table('sales_returns AS SR')
						->select('SR.amount_after_discount AS sales_return_amount')
						->where('SR.client_id', $this->party_id)
						->where('SR.date', '>=', $this->start_date)
						->where('SR.date', '<=', $this->end_date)
						->where('SR.audit_approval', 1)
						->where('SR.management_approval', 1)
						->get();

			$sum_of_return = $return->sum('sales_return_amount');

			// Time has come to find the total payment received:
			$payment_received = DB::table('payment_receiveds AS PR')
								->select('PR.paid_amount AS amount_received')
								->where('PR.client_code', $this->party_id)
								->where('PR.cheque_clearing_status', '!=', 'Due')
								->where('PR.date', '>=', $this->start_date)
    							->where('PR.date', '<=', $this->end_date)
    							->where('PR.sales_approval', 1)
    							->where('PR.management_approval', 1)
    							->get();

			$sum_of_payment_recieved = $payment_received->sum('amount_received');

			$balance =  $sum_of_return + $sum_of_payment_recieved - $sum_of_sales;
			$statement_id = 'ODS_' . \Carbon\Carbon::now()->format('ymdHis');

        	return view('reports.excel.statement.monthlyStatement')
        		->with('client_name', $client_name)
        		->with('client_code', $client_code)
        		->with('client_address', $client_address)
        		->with('all_sales', $all_sales)
        		->with('all_sales_return', $all_sales_return)
        		->with('sales_return_payment_joined', $sales_return_payment_joined)
        		->with('sum_of_sales', $sum_of_sales)
        		->with('sum_of_return', $sum_of_return)
        		->with('sum_of_payment_recieved', $sum_of_payment_recieved)
        		->with('balance', $balance)
        		->with('statement_id', $statement_id);

    	}
	}
?>