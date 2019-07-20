@extends('layouts.dashboard')

@section('content')
{!! Form::open(['route' => 'create_second']) !!}
<div class="container-fluid">
	<div class="row">
		<div class="form-group col-md-6">
			<div class="form-group">
	            {!! Form::label('party_type', 'Select the Client Type:') !!}
	            {!! Form::select('party_type', $party_types, null, ['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::submit('Add', ['class' => 'btn']) }}
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@endsection