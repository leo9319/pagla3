@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Edit Product Type</h3></div>
				<hr>

				<div class="panel-body">
					{!! Form::model($product_type, array('route'=>['product_type.update', $product_type->id], 'method'=>'PUT')) !!}
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