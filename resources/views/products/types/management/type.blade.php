@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<table class="table table-hover">
				<h2 class="text-center">Product Types</h2>
				<br>
			    <thead>
			      <tr>
			        <th>Product Types</th>
			        <th>Status</th>
			        <th>Audit Approved</th>
			      </tr>
			    </thead>
			    <tbody>
		    	@foreach($product_types as $product_type)
			      <tr>
			        <td>{{ $product_type->type }}</td>

		        	<!-- management Approval -->

                  @if($product_type->management_approval == -1)
                    <td>
						{{ link_to_route('product_type.management.approval','Approve', [$product_type->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

						{{ link_to_route('product_type.management.dissapproval','Dissaprove', [$product_type->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($product_type->management_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($product_type->management_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif



			 		@if($product_type->audit_approval == 1)
			 			<td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
		 			@elseif($product_type->audit_approval == -1)
			 			<td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
			 		@else
			 			<td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
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
	{!! Form::open(array('route'=>'product_type.store')) !!}
	<div class="container-fluid">
		<div class="row">
			<div class="form-group col-md-6">
				<div class="form-group">
					{!! Form::label('type', 'Type Name:') !!}
					{!! Form::text('type', null, ['class'=>'form-control']) !!}
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