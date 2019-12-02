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
				<th>Invoice ID</th>
				<th>Client Name</th>
				<th>Client Type</th>
				<th>Product Code</th>
				<th>Product Name</th>
				<th>Brand</th>
				<th>Product Type</th>
				<th>Commission percentage</th>
				<th>Sales Person</th>
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
			@foreach($detailed_sales_monthly as $detailed_sale_monthly)
				<tr>
					<td>{{ $detailed_sale_monthly->date }}</td>
					<td>{{ $detailed_sale_monthly->invoice_no }}</td>
					<td>{{ $detailed_sale_monthly->party_name }}</td>
					<td>{{ $detailed_sale_monthly->party_type }}</td>
					<td>{{ $detailed_sale_monthly->product_code }}</td>
					<td>{{ $detailed_sale_monthly->product_name }}</td>
					<td>{{ $detailed_sale_monthly->brand }}</td>
					<td>{{ $detailed_sale_monthly->product_type }}</td>
					<td>{{ $detailed_sale_monthly->commission_percentage }}</td>
					<td>{{ $detailed_sale_monthly->present_sr_id }}</td>
					<td>{{ $detailed_sale_monthly->zone }}</td>
					<td>{{ $detailed_sale_monthly->quantity }}</td>
					<td>{{ $detailed_sale_monthly->price_per_unit }}</td>

				@while (strtotime($temp_start_date) <= strtotime($end_date))
					@if(Carbon\Carbon::parse($temp_start_date)->month == $detailed_sale_monthly->month_number)
					@if(Carbon\Carbon::parse($temp_start_date)->year == $detailed_sale_monthly->year)
						<td>{{ $detailed_sale_monthly->amount }}</td>

					@endif
					@else
						<td>-</td>
					@endif

					<?php
						$temp_start_date = date ("Y-m-d", strtotime("+1 month", strtotime($temp_start_date)));
					?>
					
				@endwhile
				<?php $temp_start_date = $start_date; ?>
			@endforeach
				</tr>
		</tbody>
	</table>
</body>
</html>