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
				<th>Client Name</th>
				<th>Client Type</th>
				<th>Sales Person</th>
				<th>Amount after discount/VAT</th>
			</tr>
		</thead>
		<tbody>
		@foreach($detailed_sales as $detailed_sale)
			<tr>
				<td>{{ $detailed_sale->date ?? '-' }}</td>
				<td>{{ $detailed_sale->client->party_name ?? '-' }}</td>
				<td>{{ $detailed_sale->client->partyType->type ?? '-' }}</td>
				<td>{{ $detailed_sale->present_sr_id ?? '-' }}</td>
				<td>
					@if($detailed_sale->amount_after_discount != NULL)
						{{ $detailed_sale->amount_after_discount ?? '-' }}
					@else
						{{ $detailed_sale->amount_after_vat_and_discount ?? '-' }}
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
		
	</table>
</body>
</html>