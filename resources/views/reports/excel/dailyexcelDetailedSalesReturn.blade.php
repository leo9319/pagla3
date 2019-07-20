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
				<th>Price</th>
				<th>Quantity</th>
				<th>Commission amount</th>
				<th>Zone</th>

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
			@foreach($detailed_sales_returns as $detailed_sales_return)
				@if($detailed_sales_return->quantity > 0)
					<tr>
						<td>{{ $detailed_sales_return->party_name }}</td>
						<td>{{ $detailed_sales_return->party_type }}</td>
						<td>{{ $detailed_sales_return->product_name }}</td>
						<td>{{ $detailed_sales_return->product_type }}</td>
						<td>{{ $detailed_sales_return->price }}</td>
						<td>{{ $detailed_sales_return->quantity }}</td>
						<td>{{ $detailed_sales_return->commission_percentage }}</td>
						<td>{{ $detailed_sales_return->zone }}</td>

						<?php
							$total_init = $detailed_sales_return->price * $detailed_sales_return->quantity;
							$disc = ($total_init * $detailed_sales_return->commission_percentage)/100;
							$after_disc = $total_init - $disc;
						?>

						@while (strtotime($temp_start_date) <= strtotime($end_date))	
								@if($detailed_sales_return->date == $temp_start_date)
									<td>{{ $after_disc }}</td>
								@else 
									<td>-</td>
								@endif
							<?php
								$temp_start_date = date ("Y-m-d", strtotime("+1 day", strtotime($temp_start_date)));
							?>
						@endwhile
						<?php $temp_start_date = $start_date; ?>

					</tr>
				@endif
			@endforeach
		</tbody>
		
	</table>
</body>
</html>