<!DOCTYPE html>
<html>
<head>
	<title>Export</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Product ID</th>
				<th>Product Name</th>
				<th>Brand</th>
				<th>Product Type</th>
				<th>Quantity</th>

				@if(Auth::user()->user_type == 'management')
				<th>Cost</th>
				@endif

				<th>Wholesale Rate</th>
				<th>MRP</th>
				<th>Expiry date</th>
				<th>Batch code</th>
			</tr>
		</thead>
		<tbody>
			@foreach($inventories as $inventories)
				<tr>
					<td>{{ $inventories->product_code }}</td>
					<td>{{ $inventories->product_name }}</td>
					<td>{{ $inventories->brand }}</td>
					<td>{{ $inventories->product_type }}</td>
					<td>{{ $inventories->quantity }}</td>

					@if(Auth::user()->user_type == 'management')
						<td>{{ $inventories->cost }}</td>
					@endif

					<td>{{ $inventories->wholesale_rate }}</td>
					<td>{{ $inventories->mrp }}</td>
					<td>{{ $inventories->expiry_date }}</td>
					<td>{{ $inventories->batch_code }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>