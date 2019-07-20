<!DOCTYPE html>
<html>
<head>
	<title>Export</title>
</head>
<body>
	<table>
		<thead>
			<tr>
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
				@foreach($all_sales_return->unique('client_id') as $sale)
					@foreach($sale->clients as $client)
					<tr>
						<td>{{ $client->party_name }}</td>
						@while (strtotime($temp_start_date) <= strtotime($end_date))	
						<?php $found = false; ?>
							@foreach($all_sales_return as $sale_date)
								@if(($sale_date->date == $temp_start_date) and ($sale_date->client_id == $client->id))
									<td>{{ $sale_date->amount_after_discount }}</td>	
									<?php $found = true; ?>
								@endif
							@endforeach
							@if(!$found)
								<td>-</td>
							@endif
							<?php
								$temp_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($temp_start_date)));
							?>
						@endwhile
						<?php $temp_start_date = $start_date; ?>
					</tr>
					@endforeach
				@endforeach
		</tbody>
		
	</table>
</body>
</html>