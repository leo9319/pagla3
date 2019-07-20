@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Edit Product</h3></div>
				<hr>

				<div class="panel-body">
								
						{!! Form::model($product, array('route'=>['products.update', $product->id], 'method'=>'PUT')) !!}
							<div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('date', 'Date') !!}
                            {!! Form::date('date', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_name', 'Product Name:') !!}
                            {!! Form::text('product_name', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_size', 'Product Size:') !!}
                            {!! Form::text('product_size', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('case_size', 'Case Size:') !!}
                            {!! Form::text('case_size', null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">
							<div class="form-group">
								{!! Form::label('product_code', 'Product Code:') !!}
								{!! Form::text('product_code', null, ['class'=>'form-control', 'readonly']) !!}
							</div>                 

							<div class="form-group">
								{!! Form::label('brand', 'Brand:') !!}
								{!! Form::text('brand', null, ['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
                            {!! Form::label('product_type', 'Product Type:') !!}
                            {!! Form::select('product_type', $product_types, null, ['class'=>'form-control']) !!}
                          </div>
                        </div>

                        <div class="col-md-12">
							<div class="form-group">
							    {!! Form::button('Update', ['type'=>'submit', 'class'=>'btn btn-success btn-block']) !!}
							</div>
						</div>
                      </div>
                  </div>
						{!! Form::close() !!}
					
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