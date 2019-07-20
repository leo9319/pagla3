<!DOCTYPE html>
<html>
<head>
	<title>Export</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Client Name</th>
				<th>Client Type</th>
				<th>Zone</th>
				<th>Collector</th>

				<?php 
					$temp_start_date = $start_date;
				?>
				@while (strtotime($temp_start_date) <= strtotime($end_date))

				<th>{{date('M-y', strtotime($temp_start_date))}}</th>
					<?php
						$temp_start_date = date ("Y-m-d", strtotime("+1 month", strtotime($temp_start_date)));
					?>
				@endwhile
				<?php $temp_start_date = $start_date; ?>
			</tr>
		</thead>
		<tbody>
			@foreach($detailed_payment_monthly as $detail_payment_monthly)
				<tr>
					<td>{{ $detail_payment_monthly->party_name }}</td>
					<td>{{ $detail_payment_monthly->party_type }}</td>
					<td>{{ $detail_payment_monthly->zone }}</td>
					<td>{{ $detail_payment_monthly->collector }}</td>

				@while (strtotime($temp_start_date) <= strtotime($end_date))
					@if(Carbon\Carbon::parse($temp_start_date)->month == $detail_payment_monthly->month_number)
						<td>{{ $detail_payment_monthly->total_received }}</td>
					@else
						<td>-</td>
					@endif

					<?php
						$temp_start_date = date ("Y-m-d", strtotime("+1 month", strtotime($temp_start_date)));
					?>
					
				@endwhile
				<?php $temp_start_date = $start_date; ?>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>