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
				<th>Sales Person</th>
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
				@foreach($detailed_sales as $detailed_sale)
					<tr>
						<td>{{ $detailed_sale->party_name }}</td>
						<td>{{ $detailed_sale->party_type }}</td>
						<td>{{ $detailed_sale->product_name }}</td>
						<td>{{ $detailed_sale->product_type }}</td>
						<td>{{ $detailed_sale->price }}</td>
						<td>{{ $detailed_sale->quantity }}</td>
						<td>{{ $detailed_sale->commission_percentage }}</td>
						<td>{{ $detailed_sale->sr_name }}</td>
						<td>{{ $detailed_sale->zone }}</td>

						<?php
							$total_init = $detailed_sale->price * $detailed_sale->quantity;
							$disc = ($total_init * $detailed_sale->commission_percentage)/100;
							$after_disc = $total_init - $disc;
						?>

						@while (strtotime($temp_start_date) <= strtotime($end_date))	
								@if($detailed_sale->date == $temp_start_date)
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
				@endforeach
		</tbody>
		
	</table>
</body>
</html>