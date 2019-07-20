@extends('layouts.dashboard')

@section('content')

<div class="card mb-3">

	<div class="card-header">

		<i class="fa fa-table"></i> Client Balances

	</div>

	<div class="card-body">

		<div class="table-responsive">

			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

				<thead>
					<tr>
						<th>Client ID</th>
						<th>Client Name</th>
						
						<th>Action</th>
				</thead>

				<tfoot>
					<tr>
						<th>Client ID</th>
						<th>Client Name</th>
						
						<th>Action</th>
					</tr>
				</tfoot>

				<tbody>
					@foreach($clients as $client)
					<tr>
						<td>{{ $client->party_id }}</td>
						<td>{{ $client->party_name }}</td>
						<td>
							<a href="{{ route('adjust-balance.show', $client->id) }}" class="btn btn-info btn-sm btn-block">Adjust</a>
						</td>
					</tr>
					@endforeach
				</tbody>

			</table>

		</div>

	</div>

</div>

@endsection