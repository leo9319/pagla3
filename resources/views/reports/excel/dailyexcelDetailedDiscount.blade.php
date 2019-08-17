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
				<th>Invoice No</th>
				<th>Client Name</th>
				<th>Total Discount</th>
			</tr>
		</thead>
		<tbody>
				@foreach($detailed_discount as $dd)
					<tr>
						<td>{{ $dd->date }}</td>
						<td>{{ $dd->invoice_no }}</td>
						<td>{{ $dd->client->party_name }}</td>
						<td>{{ $dd->total_sales - $dd->amount_after_discount }}</td>
					</tr>
				@endforeach
		</tbody>
		
	</table>
</body>
</html>