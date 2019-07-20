@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Human Resources
      @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse')
      <!-- Do Not show anything -->
      @else
        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Add HR</button></a>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Employee ID</th>
              <th>Name</th>
              <th>Contact</th>
              <th>Role (Sales/ Collection)</th>
              <th>Zone</th>
              <th>Status</th>
              <th>Audit Approved</th>
              <th>Sales Approved</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>SL.</th>
              <th>Employee ID</th>
              <th>Name</th>
              <th>Contact</th>
              <th>Role (Sales/ Collection)</th>
              <th>Zone</th>
              <th>Status</th>
              <th>Audit Approved</th>
              <th>Sales Approved</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($hrs as $hr)
              <tr>
                <td>{{ $hr->id }}</td>
                <td>{{ $hr->employee_id }}</td>
                <td>{{ $hr->name }}</td>
                <td>{{ $hr->phone }}</td>
                <td>{{ $hr->role }}</td>
                <td>
                  @foreach($hr->zones as $zone)
                    {{ $zone->zone }}
                  @endforeach
                </td>

                <!-- Management Approval -->
                @if($hr->management_approval == -1)
                  <td>
                    {{ link_to_route('hrs.management.approval','Approve', [$hr->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                    {{ link_to_route('hrs.management.dissapproval','Dissaprove', [$hr->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                  </td>
                @elseif($hr->management_approval == 1)
                  <td><p class="text-success font-weight-bold">Approved</p></td>
                @elseif($hr->management_approval == 0)
                  <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                @endif


                <!-- Show Audit and Sales approval to management -->

                @if($hr->audit_approval == 1)
                  <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                @elseif($hr->audit_approval == -1)
                  <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                @else
                  <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                @endif

                @if($hr->sales_approval == 1)
                  <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                @elseif($hr->sales_approval == -1)
                  <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                @else
                  <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                @endif

                
              </tr> 
              @endforeach    
          </tbody>
        </table>

        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h2>Add HR</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                {!! Form::open(['route'=>'hrs.store']) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('employee_id', 'Employee ID:') !!}
                            {!! Form::text('employee_id', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('phone', 'Contact Number:') !!}
                            {!! Form::text('phone', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('zone', 'Zone:') !!}
                            {!! Form::select('zone', $zones->pluck('zone', 'id'), null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">
                          
                          <div class="form-group">
                              {!! Form::label('name', 'Employee Name:') !!}
                              {!! Form::text('name', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                              {!! Form::label('role', 'Role (Sales/ Collection):') !!}
                              {!! Form::select('role', ['Sales' => 'Sales', 'Collection' => 'Collection'], null, ['class'=>'form-control']) !!}
                          </div> 

                        </div>
                      </div>
                  </div>

                  <div class="container-fluid">  
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