@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Monthly Statement</h3></div>
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
										{!! Form::label('party_id', 'Select Party:') !!}
										{!! Form::select('party_id', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control select2']) !!}
									</div>
								</div>
							</div>

							<div class="col-md-12">
								{!! Form::submit('Generate Report', ['class'=>'btn btn-success btn-block mt-4']) !!}
							</div>

							<div class="col-md-12">
								{{-- <a href="{{ route('statement.monthly.all_clients') }}" class="btn btn-primary btn-block mt-4">Generate Report For All Clients</a> --}}

								<button type="button" class="btn btn-primary btn-block mt-4" data-toggle="modal" data-target="#select-month">Generate Report For All Clients</button>

							</div>
						</div>
						{!! Form::close() !!} 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="select-month" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>

        {{ Form::open(['route'=>'statement.monthly.all_clients']) }}

        <div class="modal-body">
          
          		<div class="form-group">
          			
          			{{ Form::label('select_month') }}
          			{{ Form::selectMonth('month', null, ['class'=>'form-control']) }}

          		</div>

          		<div class="form-group">
          			
          			{{ Form::label('select_year') }}
          			{{ Form::selectRange('year', 2018, 2030 , null, ['class'=>'form-control']) }}

          		</div>

          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

        {{ Form::close() }}

      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript"> 

	$(".select2").select2({
      placeholder: 'Select a value', 
      allowClear: true
    });

</script>

@endsection