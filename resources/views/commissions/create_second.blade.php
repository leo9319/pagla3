@extends('layouts.dashboard')

@section('content')
<div class="container">
<h2>{{ $party_name }}</h2>
<p>Add the commission percentages in the table below:</p>            
<table class="table">
<thead>
  <tr>
    <th>Product Type</th>
    <th>Percentage</th>
  </tr>
</thead>
<tbody>
	{!! Form::open(['route'=>'create_third']) !!}
	
		@foreach($product_types as $product_type)
		<tr>
			<td>
				{{ $product_type->type }}
			</td>
			<td>
				<div class="form-group col-md-3">
                	{!! Form::number('commission_percentage[]', 0, ['class'=>'form-control', 'required'=>'required']) !!}
            	</div>
        	</td>
		</tr>
		{!! Form::hidden('party_id', $party_id) !!}
		@endforeach
	</tr>
	<tr>
		<td>
			<div class="form-group">
                {!! Form::submit('Submit', ['class'=>'btn btn-default']) !!}
            </div>
		</td>
		<td></td>
	</tr>
	{!! Form::close() !!}
</tbody>
</table>
</div>

	
		
	
@endsection