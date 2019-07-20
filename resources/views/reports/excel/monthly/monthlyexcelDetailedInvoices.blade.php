<!DOCTYPE html>
<html>
<head>
	<title>Export</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Month</th>
				<th>Number of Invoice</th>
			</tr>
		</thead>
		<tbody>
			@foreach($number_of_invoices as $each_invoice)
				<tr>
					<td>{{Carbon\Carbon::parse($each_invoice->year . '-' . $each_invoice->month . '-01')->format('M-Y')}}</td>
					<td>{{ $each_invoice->count }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>