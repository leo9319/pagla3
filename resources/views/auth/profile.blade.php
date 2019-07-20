@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                	<table class="table table-striped">
					    <thead>
					      <tr>
					        <th>Name</th>
					        <th>Username</th>
					        <th>User Type</th>
					      </tr>
					    </thead>
					    <tbody>
					    	@foreach($users as $user)
					      <tr>
					        <td>{{ $user->name }}</td>
					        <td>{{ $user->username }}</td>
					        <td>{{ ucfirst($user->user_type) }}</td>
					      </tr>
					      	@endforeach
					    </tbody>
					  </table>          
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
