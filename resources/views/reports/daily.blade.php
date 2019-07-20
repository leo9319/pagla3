@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Daily Report</h3></div>
				<hr>

				<div class="panel-body">
					<div class="container-fluid">
						{!! Form::open() !!}
						<div class="row">
							<div class="col-md-6">
								<div>
									<div class="form-group">
										{!! Form::label('start_date', 'Start Date:') !!}
										{!! Form::date('start_date', null, ['class'=>'form-control', 'required']) !!}
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div>
									<div class="form-group">
										{!! Form::label('end_date', 'End Date:') !!}
										{!! Form::date('end_date', null, ['class'=>'form-control', 'required']) !!}
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
												'6' => 'Collection',
												'7' => 'Discount'
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