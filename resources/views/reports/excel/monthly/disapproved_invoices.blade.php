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
				@foreach($period as $dt)
					<th>{{ $dt->format("M Y") }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($parties as $party)
			<tr>
				<td>{{ $party->party_name }}</td>
				@foreach($period as $dt)
					<td>{{ $party->salesDisapproved($dt->format("m"), $dt->format("Y"))->count() }}</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>