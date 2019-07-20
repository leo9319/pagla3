@extends('layouts.dashboard')

@section('content')

<div class="card mb-3">

	<div class="card-header">

		<i class="fa fa-table"></i> Client Balances

	</div>

	<div class="card-body">

		<div class="card-section col-md-6 offset-md-3">

			<h3 style="text-align: center">:: Client's Information ::</h3>
			<hr>

			<table align="center" id="balance">
				<tbody>
					<tr>
						<td><p><b>Client Code:</b></p></td>
						<td><p> {{ $client->party_id }} </p></td>
					</tr>
					<tr>
						<td><p><b>Client Name:</b></p></td>
						<td><p> {{ $client->party_name }} </p></td>
					</tr>
					<tr>
						<td><p><b>Client Type:</b></p></td>
						<td><p> {{ App\Party_type::find($client->party_type_id) ? App\Party_type::find($client->party_type_id)->type : 'N/A' }} </p></td>
					</tr>
					<tr>
						<td><p><b>Payment Received:</b></p></td>
						<td><p> {{ number_format($payment_received) }} </p></td>
					</tr>
					<tr>
						<td><p><b>Overall Sales:</b></p></td>
						<td><p> {{ number_format($total_sales->sum('amount_after_discount')) }} </p></td>
					</tr>
					<tr>
						<td><p><b>Total Sales Return:</b></p></td>
						<td><p> {{ number_format($total_sales_return->sum('amount_after_discount')) }} </p></td>
					</tr>
					<tr>
						<td><br></td>
						<td><br></td>
					</tr>
					<tr>
						<td><p><b>True Balance:</b></p></td>
						<td><p> {{ number_format($true_balance) }}</p></td>
					</tr>
					<tr>
						<td><p><b>Total Adjustments:</b></p></td>
						<td><p> {{ number_format($overall_adjustments) }} <a href="{{ route('adjust-balance.history', $client->id) }}">(<i class="fa fa-search"></i>View)</a></p></td>
					</tr>
					<tr>
						<td><p><b>After Adjustments:</b></p></td>
						<td><p>{{ number_format($true_balance + $overall_adjustments) }}</p></td>
					</tr>
				</tbody>
			</table>

			@if(Auth::user()->user_type == 'audit')

			<hr>

			<h4 id="adjust"><b>Adjust Balance:</b></h4>

			{{ Form::open(['route'=>'adjust-balance.store', 'files' => true]) }}

			<div class="col-md-10 offset-md-1">
				<input type="hidden" name="client_id" value="{{$client->id}}">
				<input type="number" class="form-control adjust-input" name="amount">
				<input type="text" placeholder="Reference" class="form-control adjust-input" name="reference">
				<input type="file" name="reference_attatchment">
				<hr>
				<input type="submit" class="btn btn-success btn-block">
			</div>

			{{ Form::close() }}

			@endif

		</div>

	</div>

</div>
@endsection