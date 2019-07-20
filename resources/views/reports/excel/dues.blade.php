<!DOCTYPE html>
<html>
<head>
	<title>Client Dues</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Client ID</th>
				<th>Client Name</th>
				<th>Total Sales</th>
				<th>Total Sales Return</th>
				<th>Total Amount Received without cheque</th>
				<th>Total Amount Received with cheque</th>
				<th>Adjustments</th>
				<th>Dues</th>
				<th>Advance</th>
			</tr>
		</thead>
		<tbody>
		@foreach($parties as $party)
			<tr>
				<td>{{ $party->party_id }}</td>
				<td>{{ $party->party_name }}</td>
				<td>{{ $party->sales->sum('amount_after_discount') ?? 'N/A' }}</td>
				<td>{{ $party->sales_return->sum('amount_after_discount') ?? 'N/A' }}</td>
				<td>{{ $party->payments_received_without_cheque->sum('total_received') ?? 'N/A' }}</td>
				<td>{{ $party->payments_received_with_cheque->sum('total_received') ?? 'N/A' }}</td>
				<td>{{ $party->adjustmentedBalance->sum('amount') ?? 'N/A' }}</td>

				<?php

					$sales          = $party->sales->sum('amount_after_discount');
					$sales_return   = $party->sales_return->sum('amount_after_discount');
					$without_cheque = $party->payments_received_without_cheque->sum('total_received');
					$with_cheque    = $party->payments_received_with_cheque->sum('total_received');
					$adjustments    = $party->adjustmentedBalance->sum('amount');


					$balance = $sales_return + 
							   $without_cheque + 
							   $with_cheque -
							   $sales + 
							   $adjustments;

				    if($balance < 0) {
				    	$dues    = $balance;
				    	$advance = 0;
				    } else {
				    	$dues    = 0;
				    	$advance = $balance;
				    }

				?>

				<td>{{ abs($dues) }}</td>
				<td>{{ $advance }}</td>
			</tr>
		@endforeach
		</tbody>
		
	</table>
</body>
</html>