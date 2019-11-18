@extends('layouts.dashboard')

@section('content')
  <div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Clients
      @if($user->user_type == 'warehouse' || $user->user_type == 'audit' || $user->user_type == 'hr')
      <!-- Do Not show anything -->
      @else
        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Add Clients</button></a>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Client ID</th>
              <th>Client Name</th>
              <th>Address</th>
              <th>BIN</th>
              <th>Phone Number</th>
              <th>Email ID</th>
              <th>Contact Person</th>
              <th>Owner Number</th>
              <th>Client Type</th>
              <th>Credit Limit</th>
              <th>Zone</th>
              <th>Status</th>
              <th>Audit Approved</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>SL.</th>
              <th>Client ID</th>
              <th>Client Name</th>
              <th>Address</th>
              <th>BIN</th>
              <th>Phone Number</th>
              <th>Email ID</th>
              <th>Contact Person</th>
              <th>Owner Number</th>
              <th>Client Type</th>
              <th>Credit Limit</th>
              <th>Zone</th>
              <th>Status</th>
              <th>Audit Approved</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($parties as $party)
              <tr>
                <td>{{ $party->id }}</td>
                <td>{{ $party->party_id }}</td>
                <td>{{ $party->party_name }}</td>
                <td>{{ $party->address }}</td>
                <td>{{ $party->bin }}</td>
                <td>{{ $party->party_phone }}</td>
                <td>{{ $party->email }}</td>
                <td>{{ $party->contact_person }}</td>
                <td>{{ $party->owner_number }}</td>
                <td>
                  @foreach($party->clients as $client_type)
                    {{ $client_type->type }}
                  @endforeach
                </td>
                <td>{{ number_format($party->credit_limit) }}</td>      
                <td>
                    @foreach($party->zones as $zone)
                      {{ $zone->zone }}
                    @endforeach
                </td>

                <!-- Management Approaval -->
                @if($user->user_type == 'management')
                  @if($party->management_approval == -1)
                    <td>
                      {{ link_to_route('parties.management.approval','Approve', [$party->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}


                      {{ link_to_route('parties.management.dissapproval','Dissaprove', [$party->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($party->management_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($party->management_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>

                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Show Management the Audit Approval -->
                @if($user->user_type == 'management')
                  @if($party->audit_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($party->audit_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pendings</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif
                
              </tr>
              @endforeach
          </tbody>
        </table>

        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h2>Add Client</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                {!! Form::open(array('route'=>'parties.store')) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('party_id', 'Client ID:') !!}
                            {!! Form::text('party_id', $client_id, ['class'=>'form-control', 'readonly']) !!}
                          </div>                     

                          <div class="form-group">
                            {!! Form::label('email', 'Email ID:') !!}
                            {!! Form::email('email', null, ['class'=>'form-control']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('contact_person', 'Contact Person Name:') !!}
                            {!! Form::text('contact_person', null, ['class'=>'form-control', 'required']) !!}
                          </div>                 

                          <div class="form-group">
                            {!! Form::label('party_type_id', 'Client Type:') !!}
                            {!! Form::select('party_type_id', $party_types, null, ['class'=>'form-control']) !!}
                          </div>  

                          <div class="form-group">
                            {!! Form::label('credit_limit', 'Credit Limit:') !!}
                            {!! Form::number('credit_limit', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">

                          <div class="form-group">
                            {!! Form::label('party_name', 'Client Name:') !!}
                            {!! Form::text('party_name', null, ['class'=>'form-control', 'required']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('party_phone', 'Phone:') !!}
                            {!! Form::text('party_phone', null, ['class'=>'form-control', 'required']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('owner_number', 'Owner Number:') !!}
                            {!! Form::text('owner_number', null, ['class'=>'form-control', 'required']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('zone', 'Zone:') !!}
                            {!! Form::select('zone', $zones, null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('bin', 'BIN:') !!}
                            {!! Form::text('bin', null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-12">

                          <div class="form-group">
                            {!! Form::label('address', 'Address:') !!}
                            {!! Form::textarea('address', null, ['class'=>'form-control', 'required', 'size' => '30x3']) !!}
                          </div> 

                        </div>
                      </div>
                  </div>
                    <button type="submit" class="btn btn-success btn-block">Save</button>
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
                  </div>
                  
                {!! Form::close() !!}
              </div>

              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
@endsection