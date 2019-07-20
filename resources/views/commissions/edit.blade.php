@extends('layouts.dashboard')

@section('content')
<div class="container">
  <h2>{{$party_name->type}}</h2>    
   
    <table class="table">
    <thead>
      <tr>
        <th>Product Type</th>
        <th>Commission Percentage (%)</th>
      </tr>
    </thead>
    <tbody>
    	{!! Form::open(array('route'=>['commission.update2'])) !!}
	    	  <tr>
              <td>{{ $product_name->type }}</td>
              <td>{!! Form::text('commission_percentage', $commission->commission_percentage, ['class'=>'form-control', 'style'=>'width:200px']) !!}</td>
          </tr>
    </tbody>
  </table>
  <div class="form-group">
        {!! Form::hidden('party_id', $id_party) !!}
        {!! Form::hidden('product_id', $id_product) !!}
        {!! Form::submit('Update', ['class'=>'btn btn-default']) !!}
  </div>
  {!! Form::close() !!}
</div>
@endsection