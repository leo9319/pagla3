@extends('layouts.dashboard')

@section('content')

<div>
	<div class="custom-well">
		<a href="{{ route('statement.monthly') }}" class="btn btn-warning btn-block">Monthly Statement</a>
	</div>
	<div class="custom-well">
		<a href="{{ route('reports.daily') }}" class="btn btn-success btn-block">Daily Report</a>
	</div>
	<div class="custom-well">
		<a href="{{ route('reports.monthly') }}" class="btn btn-info btn-block">Monthly Report</a>
	</div>
	<div class="custom-well">
		<a href="{{ route('inventory.report') }}" class="btn btn-danger btn-block">Inventory Report</a>
	</div>
	<div class="custom-well">
		<a href="{{ route('due.report') }}" class="btn btn-primary btn-block">Due Report</a>
	</div>
</div>

@endsection