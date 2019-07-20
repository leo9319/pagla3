@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Edit Party Type</h3></div>
				<hr>

				<div class="panel-body">
					{!! Form::model($paymentMethod, array('route'=>['payment_methods.update', $paymentMethod->id], 'method'=>'PUT')) !!}
					<div class="container-fluid">
						<div class="row">
							<div class="form-group col-md-6">
								<div class="form-group">
									{!! Form::label('method', 'Payment Method:') !!}
									{!! Form::text('method', null, ['class'=>'form-control']) !!}
					          </div>

					          <div class="form-group">
									{!! Form::label('gateway_charge', 'Gateway Charge %:') !!}
									{!! Form::text('gateway_charge', null, ['class'=>'form-control', 'required'=>'required']) !!}
					          </div>

					          <div class="form-group">
						            {!! Form::submit('Submit', ['class'=>'btn btn-default']) !!}
					          </div>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
                  </div>
						
				</div>
			</div>

			@if ( count( $errors ) > 0 )
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif

		</div>	
	</div>
</div>
@endsection