<!DOCTYPE html>
<html>
<head>
	<title>Export</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Invoice No.</th>
				<th>Party Name</th>
				<?php $temp_start_date = $start_date; ?>
				@while (strtotime($temp_start_date) <= strtotime($end_date))

				<th>{{date('d-M-y', strtotime($temp_start_date))}}</th>
					<?php
						$temp_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($temp_start_date)));
					?>
				@endwhile
				<?php $temp_start_date = $start_date; ?>
			</tr>
		</thead>
		<tbody>
				@foreach($all_sales as $sale)
					@foreach($sale->clients as $client)
					<tr>
						<td>{{ $sale->invoice_no }}</td>
						<td>{{ $client->party_name }}</td>
					@endforeach
						@while (strtotime($temp_start_date) <= strtotime($end_date))	
							@if(($sale->date == $temp_start_date))
								<td>{{ $sale->amount_after_discount }}</td>
							@else
								<td></td>	
							@endif

							<?php
								$temp_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($temp_start_date)));
							?>
						@endwhile
						<?php $temp_start_date = $start_date; ?>
					</tr>
				@endforeach
		</tbody>
		
	</table>
</body>
</html>