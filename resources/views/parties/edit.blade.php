@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Edit Client</h3></div>
				<hr>

				<div class="panel-body">
					{!! Form::model($parties, array('route'=>['parties.update', $parties->id], 'method'=>'PUT')) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('party_id', 'Client ID:') !!}
                            {!! Form::text('party_id', null, ['class'=>'form-control']) !!}
                          </div>                     

                          <div class="form-group">
                            {!! Form::label('email', 'Email ID:') !!}
                            {!! Form::email('email', null, ['class'=>'form-control']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('contact_person', 'Contact Person:') !!}
                            {!! Form::text('contact_person', null, ['class'=>'form-control']) !!}
                          </div>                 

                          <div class="form-group">
                            {!! Form::label('party_type_id', 'Client Type:') !!}
                            {!! Form::select('party_type_id', $party_types, null, ['class'=>'form-control']) !!}
                          </div>  

                          <div class="form-group">
                            {!! Form::label('credit_limit', 'Credit Limit:') !!}
                            {!! Form::number('credit_limit', null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">

                          <div class="form-group">
                            {!! Form::label('party_name', 'Client Name:') !!}
                            {!! Form::text('party_name', null, ['class'=>'form-control']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('party_phone', 'Phone:') !!}
                            {!! Form::text('party_phone', null, ['class'=>'form-control']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('owner_number', 'Owner Number:') !!}
                            {!! Form::text('owner_number', null, ['class'=>'form-control']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('zone', 'Zone:') !!}
                            {!! Form::select('zone', $zones, null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-12">

                          <div class="form-group">
                            {!! Form::label('address', 'Address:') !!}
                            {!! Form::textarea('address', null, ['class'=>'form-control', 'required',  'size' => '30x3']) !!}
                          </div> 

                        </div>
                      </div>
                  </div>
                    <button type="submit" class="btn btn-success btn-block">Update</button>
                    
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