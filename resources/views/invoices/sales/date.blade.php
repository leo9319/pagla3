@extends('layouts.dashboard')

@section('content')
<div class="modal-body">
{!! Form::open(['route' => ['sales.show.invoice', 'id' => $id]]) !!}
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					{!! Form::label('date', 'Due Date Till: ') !!}
					{!! Form::date('date', Carbon\Carbon::today()->format('Y-m-d'), ['class'=>'form-control']) !!}
				</div>

				<div class="form-group">
					{!! Form::submit('View Invoice', ['class'=>'btn btn-success']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection