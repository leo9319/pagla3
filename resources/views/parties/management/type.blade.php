@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <table class="table table-hover">
        <h2 class="text-center">Client Types</h2>
        <br>
          <thead>
            <tr>
              <th>Client Types</th>
              <th>Status</th>
              <th>Audit Approved</th>
            </tr>
          </thead>
          <tbody>
            @foreach($party_types as $party_type)      
            <tr>
              <td>{{ $party_type->type }}</td>

              <!-- Management Approval -->

              @if($party_type->management_approval == -1)
                <td>
                    {{ link_to_route('party_type.management.approval','Approve', [$party_type->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                    {{ link_to_route('party_type.management.dissapproval','Dissaprove', [$party_type->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                </td>
              @elseif($party_type->management_approval == 1)
                <td><p class="text-success font-weight-bold">Approved</p></td>
                @elseif($party_type->management_approval == 0)
                <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
              @endif


              <!-- Showing audit approval to management -->

              @if($party_type->audit_approval == 1)
                <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
              @elseif($party_type->audit_approval == -1)
                <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
              @else
                <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
              @endif
              
            </tr>
            @endforeach
          </tbody>
      </table>
    </div>
  </div>
</div>

{!! Form::open(['route'=>'party_type.store']) !!}
  <div class="container-fluid">
    <div class="row">
      <div class="form-group col-md-6">
        <div class="form-group">
          {!! Form::label('type', 'Type Name:') !!}
          {!! Form::text('type', null, ['class'=>'form-control']) !!}
          </div>

          <div class="form-group">
              {!! Form::submit('Submit', ['class'=>'btn btn-default']) !!}
          </div>
      </div>
    </div>
  </div>
{!! Form::close() !!}

@endsection