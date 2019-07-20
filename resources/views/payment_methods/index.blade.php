@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<table class="table table-hover">
				<h2 class="text-center">Payment Methods</h2>
				<br>
			    <thead>
			      <tr>
			        <th>Method</th>
			        <th>Gateway Charge %</th>

					@if($user->user_type == 'management')
						<th>Status</th>
					@else
					<!-- Do nothing -->
					@endif

			        @if($user->user_type == 'sales' || $user->user_type == 'audit'  || $user->user_type == 'warehouse' || $user->user_type == 'hr')
					@else
						<th>Edit</th>
						<th>Delete</th>
					@endif

					@if($user->user_type == 'audit')
						<th>Management Approved</th>
					@else
					<!-- Do nothing -->
					@endif
			      </tr>
			    </thead>
			    <tbody>
		    	@foreach($payment_methods as $payment_method)
			      <tr>
			        <td>{{ $payment_method->method }}</td>
			        <td class="text-center">{{ $payment_method->gateway_charge }}</td>

			        @if($user->user_type == 'management')
	                  @if($payment_method->management_approval == -1)
	                    <td>
	                      {{ link_to_route('payment_methods.management.approval','Approve', [$payment_method->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

  						  {{ link_to_route('payment_methods.management.dissapproval','Dissaprove', [$payment_method->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
	                    </td>
	                  @elseif($payment_method->management_approval == 1)
	                    <td><p class="text-success font-weight-bold">Approved</p></td>
                      @elseif($payment_method->management_approval == 0)
	                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
	                  @endif
	                @else
	                  <!-- Do nothing -->
	                @endif

	                <!-- Show Sales approved to audit -->
	                @if($user->user_type == 'audit')
	                  @if($payment_method->management_approval == 1)
	                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
	                  @elseif($payment_method->management_approval == -1)
	                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
	                  @else
	                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
	                  @endif
	                @endif
			        
			        @if($user->user_type == 'sales' || $user->user_type == 'audit'  || $user->user_type == 'warehouse' || $user->user_type == 'hr')
					@else
						<td>{{ link_to_route('payment_methods.edit','Edit', [$payment_method->id], ['class' => 'btn btn-primary']) }}</td>
			        <td>
			        	{!! Form::open(array('route'=>['payment_methods.destroy', $payment_method->id], 'method'=>'DELETE')) !!}
							
						{!! Form::button('Delete', ['class'=>'btn btn-danger', 'type'=>'submit']) !!}

						{!! Form::close() !!}
					</td>
					@endif 
			      </tr>
		      	@endforeach
			    </tbody>
			</table>
		</div>
	</div>
</div>

@if($user->user_type == 'sales' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
@else
	{!! Form::open(array('route'=>'payment_methods.store')) !!}
	<div class="container-fluid">
		<div class="row">
			<div class="form-group col-md-6">
				<div class="form-group">
					{!! Form::label('method', 'Payment Method:') !!}
					{!! Form::text('method', null, ['class'=>'form-control']) !!}
	          </div>
	          <div class="form-group">
					{!! Form::label('gateway_charge', 'Gateway Charge %:') !!}
					{!! Form::text('gateway_charge', 0, ['class'=>'form-control', 'required'=>'required']) !!}
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