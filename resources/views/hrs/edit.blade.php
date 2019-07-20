@extends('layouts.dashboard')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading text-center"><h3>Edit HR Information</h3></div>
					<hr>

					<div class="panel-body">
						{!! Form::model($hr, ['route'=>['hrs.update', $hr->id], 'method'=>'PUT']) !!}

						<div class="container-fluid">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
			                            {!! Form::label('employee_id', 'Employee ID:') !!}
			                            {!! Form::text('employee_id', null, ['class'=>'form-control']) !!}
		                            </div>
		                            <div class="form-group">
			                            {!! Form::label('phone', 'Contact Number:') !!}
			                            {!! Form::text('phone', null, ['class'=>'form-control']) !!}
		                            </div>
		                            <div class="form-group">
			                            {!! Form::label('zone', 'Zone:') !!}
			                            {!! Form::select('zone', $zones->pluck('zone', 'id'), null, ['class'=>'form-control']) !!}
		                            </div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
              						    {!! Form::label('name', 'Employee Name:') !!}
              						    {!! Form::text('name', null, ['class'=>'form-control']) !!}
              						</div>
              						<div class="form-group">
			                            {!! Form::label('role', 'Role (Sales/ Collection):') !!}
			                            {!! Form::select('role', ['Sales' => 'Sales', 'Collection' => 'Collection'], null, ['class'=>'form-control']) !!}
		                        	</div> 								
								</div>
								<div class="col-md-12" style="padding-top: 25px;">
									{!! Form::submit('Update', ['class'=>'btn btn-success btn-block']) !!}
								</div>
							</div>
							
						</div>

						{!! Form::close() !!}
					</div>
					
				</div>
				
			</div>
			
		</div>
	</div>
@endsection