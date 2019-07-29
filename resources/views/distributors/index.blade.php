@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Distributors

        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Add Distributor</button></a>

      
      <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Dist. ID</th>
              <th>Dist. Name</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Zone</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>SL.</th>
              <th>Dist. ID</th>
              <th>Dist. Name</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Zone</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($parties->where('distributor', 1) as $index => $party)
              @foreach($party->zones as $zone)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $party->party_id }}</td>
                <td>{{ $party->party_name }}</td>
                <td>{{ $party->party_phone }}</td>
                <td>{{ $party->address }}</td>
                <td>{{ $zone->zone }}</td>
              </tr>
              @endforeach()
            @endforeach()
            
          </tbody>
        </table>

        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h2 class="text-center">Select Client</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                {!! Form::open(array('route'=>'distributors.store')) !!}
                  <div class="container-fluid">
                      <div class="form-group">
                        {!! Form::select('party_id', $parties->pluck('party_name', 'id'), null, ['class'=>'form-control select2', 'style'=>'width:735px']) !!}
                      </div>
                  </div>

                  <div class="container-fluid">  
                    <button type="submit" class="btn btn-success btn-block btn-sm">Save</button>
                    <button type="button" class="btn btn-default btn-block btn-sm" data-dismiss="modal">Close</button>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script type="text/javascript">
    
    $(".select2").select2({
      placeholder: 'Select a value', 
      allowClear: true
    });

  </script>
@endsection