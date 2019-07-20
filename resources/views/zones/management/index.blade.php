@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<table class="table table-hover">
				<h2 class="text-center">Zones</h2>
				<br>
			    <thead>
			      <tr>
			        <th>Zones</th>
			        <th>Status</th>
			        <th>Audit Approved</th>
		    	  </tr>
			    </thead>
			    <tbody>
		    	@foreach($zones as $zone)
			      <tr>
			        <td>{{ $zone->zone }}</td>

			        <!-- Management Approval -->

					@if($zone->management_approval == -1)
					<td>
						{{ link_to_route('zones.management.approval','Approve', [$zone->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

						{{ link_to_route('zones.management.dissapproval','Dissaprove', [$zone->id], ['class' => 'btn btn-secondary btn-sm btn-width btn-sm btn-width']) }}

					</td>
					@elseif($zone->management_approval == 1)
						<td><p class="text-success font-weight-bold">Approved</p></td>
					@elseif($zone->management_approval == 0)
						<td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
					@endif


					<!-- Showing audit approval to management -->

					@if($zone->audit_approval == 1)
						<td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
					@elseif($zone->audit_approval == -1)
						<td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
					@else
						<td class="text-center"><p class="text-danger font-weight-bold">Disapproved!</p></td>
					@endif

				</tr>
		      	@endforeach
			    </tbody>
			</table>
		</div>
	</div>
</div>
@if($user->user_type == 'audit'  || $user->user_type == 'warehouse' || $user->user_type == 'hr')
<!-- Do Not show anything -->
@else
	{!! Form::open(array('route'=>'zones.store')) !!}
	<div class="container-fluid">
		<div class="row">
			<div class="form-group col-md-6">
				<div class="form-group">
					{!! Form::label('zone', 'Zone:') !!}
					{!! Form::text('zone', null, ['class'=>'form-control']) !!}
	          </div>

	          <div class="form-group">
		            {!! Form::submit('Submit', ['class'=>'btn btn-default']) !!}
	          </div>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
@endif

@endsection