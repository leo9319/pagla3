@extends('layouts.dashboard')

@section('content')

<table class="table">
    <thead>
      <tr>
        <th>Client Types</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @foreach($party_types as $party_type)
      <tr>
        <td>{{ $party_type->type }}</td>
        <td><a href="{{route('commissions.show', ['id' => $party_type->party_types_id])}}"><button class="btn btn-primary">View</button></a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endsection


