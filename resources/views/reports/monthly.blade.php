@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Monthly Report</h3></div>
				<hr>

				<div class="panel-body">
					<div class="container-fluid">
						{!! Form::open() !!}
						<div class="row">
							<div class="col-md-6">
								<div>
									<div class="form-group">
										{!! Form::label('start_month', 'Start Month:') !!}
										{!! Form::selectMonth('start_month', null, ['class'=>'form-control', 'required']) !!}
									</div>

									<div class="form-group">
										{!! Form::label('start_year', 'Start Year:') !!}
										{!! Form::selectYear('start_year', 2018, 2030, ['class'=>'form-control field', 'required']) !!}
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div>
									<div class="form-group">
										{!! Form::label('end_month', 'End Month:') !!}
										{!! Form::selectMonth('end_month', null, ['class'=>'form-control', 'required']) !!}
									</div>

									<div class="form-group">
										{!! Form::label('end_year', 'End Year:') !!}
										{!! Form::selectYear('end_year', 2018, 2030, ['class'=>'form-control field', 'required']) !!}
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div>
									<div class="form-group">
										{!! Form::label('table_id', 'Report Category:') !!}
										{!! Form::select('table_id', [
												'1' => 'Sales',
												'2' => 'Sales Return',
												'3' => 'Payment',
												'4' => 'Commission',
												'5' => 'Number of Invoices',
												'6' => 'Collection'
											], null, ['class'=>'form-control']) !!}
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div>
									<div class="form-group">
										{!! Form::label('report_name', 'Report Name:') !!}
										{!! Form::select('report_name', [
												'1' => 'Client Report',
												'2' => 'Sales Person Report',
												'3' => 'Collection Person Report',
												'4' => 'Due Report',
												'5' => 'Detailed Report'
											], null, ['class'=>'form-control']) !!}
									</div>
								</div>
							</div>

							<div class="col-md-12">
								{!! Form::submit('Generate Report', ['class'=>'btn btn-success btn-block mt-4']) !!}
							</div>
						</div>
						{!! Form::close() !!} 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection