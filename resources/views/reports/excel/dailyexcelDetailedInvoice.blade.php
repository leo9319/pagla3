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
				<th>Number of Invoices</th>
			</tr>
		</thead>
		<tbody>
			@foreach($number_of_invoices as $each_date_count)
			<tr>
				<td>{{Carbon\Carbon::parse($each_date_count->year . '-' . $each_date_count->month . '-' . $each_date_count->day)->format('d-M-Y')}}</td>
				<td>{{ $each_date_count->count }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>