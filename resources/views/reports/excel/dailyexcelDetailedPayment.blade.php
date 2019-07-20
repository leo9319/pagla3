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
				<th>Payment Method</th>
				<th>Cheque Status</th>
				<th>Collector</th>

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
			@foreach($detailed_payment_received as $detailed_pr)
					<tr>
						<td>{{ $detailed_pr->party_name }}</td>
						<td>{{ $detailed_pr->party_type }}</td>
						<td>{{ $detailed_pr->method }}</td>
						<td>{{ $detailed_pr->cheque_clearing_status }}</td>
						<td>{{ $detailed_pr->collector }}</td>

						@while (strtotime($temp_start_date) <= strtotime($end_date))	
								@if($detailed_pr->date == $temp_start_date)
									<td>{{ $detailed_pr->paid_amount }}</td>	
								@else 
									<td>-</td>
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