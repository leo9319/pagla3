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
				<th>Product Name</th>
				<th>Product Type</th>
				<th>Commission percentage</th>
				<th>Zone</th>
				<th>Quantity</th>
				<th>Price</th>

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
			@foreach($detailed_sales_return_monthly as $detailed_sale_return_monthly)
				<tr>
					<td>{{ $detailed_sale_return_monthly->party_name }}</td>
					<td>{{ $detailed_sale_return_monthly->party_type }}</td>
					<td>{{ $detailed_sale_return_monthly->product_name }}</td>
					<td>{{ $detailed_sale_return_monthly->product_type }}</td>
					<td>{{ $detailed_sale_return_monthly->commission_percentage }}</td>
					<td>{{ $detailed_sale_return_monthly->zone }}</td>
					<td>{{ $detailed_sale_return_monthly->quantity }}</td>
					<td>{{ $detailed_sale_return_monthly->price_per_unit }}</td>

				@while (strtotime($temp_start_date) <= strtotime($end_date))
					@if(Carbon\Carbon::parse($temp_start_date)->month == $detailed_sale_return_monthly->month_number)
						<td>{{ $detailed_sale_return_monthly->amount }}</td>
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