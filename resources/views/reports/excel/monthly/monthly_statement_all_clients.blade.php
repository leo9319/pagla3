<!DOCTYPE html>
<html>
<head>
	<title>Export</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Date</th>
				<th>Client ID</th>
				<th>Client Name</th>
				<th>Client Type</th>
				<th>Zone</th>
				<th>Previous Month Balance</th>
				<th>Sales</th>
				<th>Return</th>
				<th>Adjustment</th>
				<th>Collection</th>
			</tr>
		</thead>
		<tbody>
			@foreach($clients as $client)

				<?php $i = 0; ?>

				@foreach($period  as $date)

					@if($i == 0)

						<?php 

							$monthly_balance = $client->monthlyBalance($date->format('m')-1, $date->format('Y'));

							$i++;

						?>

					@endif

					<tr>
						<td>{{ $date->format("d-m-Y") }}</td>
						<td>{{ $client->party_id }}</td>
						<td>{{ $client->party_name }}</td>
						<td>{{ $client->client->type }}</td>
						<td>{{ $client->modalZone->zone ?? 'N/A' }}</td>
						<td>{{ $monthly_balance }}</td>
						<td>{{ $client->sales->where('date', $date->format('Y-m-d'))->sum('amount_after_discount') }}</td>
						<td>{{ $client->sales_return->where('date', $date->format('Y-m-d'))->sum('amount_after_discount') }}</td>
						<td>{{ $client->adjustmentedBalance->where('created_at', $date->format('Y-m-d'))->sum('amount') }}</td>
						<td>
							{{ $client->payments_received_without_cheque->where('date', $date->format('Y-m-d'))->sum('total_received') + $client->payments_received_with_cheque->where('date', $date->format('Y-m-d'))->sum('total_received') }}
						</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
</body>
</html>