@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Payment Received
      @if($user->user_type == 'sales' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
      @else
        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create Payment Received</button></a>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Date</th>
              <th>Client Code</th>
              <th>Client Name</th>
              <th>Payment Mode</th>
              <th>Paid Amount</th>
              <th>Gateway Charge %</th>
              <th>Gateway Charge</th>
              <th>Total Received</th>
              <th>Money Receipt Reference</th>
              <th>Collector</th>
              <th>Bank Deposit Reference</th>
              <th>Cheque Clearing Date</th>
              <th>Cheque Clearing Status</th>

              @if($user->user_type == 'management' || $user->user_type == 'sales')
                <th>Status</th>
              @else
                <!-- Do nothing -->
              @endif

              @if($user->user_type == 'audit')
                <th>Management Approved</th>
                <th>Sale Approved</th>
              @endif

              @if($user->user_type == 'management')
                <th>Sale Approved</th>
              @endif

              @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
              @else
                <th>Edit</th>
                <th>Delete</th>
              @endif
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>SL.</th>
              <th>Date</th>
              <th>Client Code</th>
              <th>Client Name</th>
              <th>Payment Mode</th>
              <th>Paid Amount</th>
              <th>Gateway Charge %</th>
              <th>Gateway Charge</th>
              <th>Total Received</th>
              <th>Money Receipt Reference</th>
              <th>Collector</th>
              <th>Bank Deposit Reference</th>
              <th>Cheque Clearing Date</th>
              <th>Cheque Clearing Status</th>

              @if($user->user_type == 'management' || $user->user_type == 'sales')
                <th>Status</th>
              @else
                <!-- Do nothing -->
              @endif

              @if($user->user_type == 'audit')
                <th>Management Approved</th>
                <th>Sale Approved</th>
              @endif

              @if($user->user_type == 'management')
                <th>Sale Approved</th>
              @endif

              @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
              @else
                <th>Edit</th>
                <th>Delete</th>
              @endif
            </tr>
          </tfoot>
          <tbody>
            @foreach($all_payment_received as $payment_received)
              <tr>
                <td>{{ $payment_received->id }}</td>
                <td>{{ $payment_received->date }}</td>
                <td>
                    @foreach($payment_received->clients as $client)
                      {{ $client->party_id }}
                    @endforeach
                </td>
                <td>
                   @foreach($payment_received->clients as $client)
                      {{ $client->party_name }}
                    @endforeach
                </td>
                <td>
                   @foreach($payment_received->payment_methods as $payment_method)
                      {{ $payment_method->method }}
                    @endforeach
                </td>
                <td>{{ number_format($payment_received->paid_amount) }}</td>
                <td>{{ $payment_received->gc_percentage }}%</td>
                <td>{{ $payment_received->gc }}</td>
                <td>{{ number_format($payment_received->total_received, 2) }}</td>
                <td>{{ $payment_received->money_receipt_ref }}</td>
                <td>
                   @foreach($payment_received->collectors as $collector)
                      {{ $collector->name }}
                    @endforeach
                </td>
                <td>{{ $payment_received->bd_reference }}</td>
                <td>{{ $payment_received->cheque_clearing_date }}</td>
                <td>{{ $payment_received->cheque_clearing_status }}</td>

                <!-- Management Approval -->
                @if($user->user_type == 'management')
                  @if($payment_received->management_approval == -1)
                    <td>
                      {{ link_to_route('payment_received.management.approval','Approve', [$payment_received->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('payment_received.management.dissapproval','Dissaprove', [$payment_received->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($payment_received->management_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($payment_received->management_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Sales Approval -->
                @if($user->user_type == 'sales')
                  @if($payment_received->sales_approval == -1)
                    <td>
                      {{ link_to_route('payment_received.sales.approval','Approve', [$payment_received->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('payment_received.sales.dissapproval','Dissaprove', [$payment_received->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($payment_received->sales_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($payment_received->sales_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Showing management and sale approval to audit -->
                @if($user->user_type == 'audit')
                  @if($payment_received->management_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($payment_received->management_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif

                  @if($payment_received->sales_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($payment_received->sales_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif

                <!-- Showing sale approval to management -->
                @if($user->user_type == 'management')
                  @if($payment_received->sales_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($payment_received->sales_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif
                
                @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
                @else
                  <td>{{ link_to_route('payment_received.edit','Edit', [$payment_received->id], ['class' => 'btn btn-primary']) }}</td>
                  <td>
                      {!! Form::open(array('route'=>['payment_received.destroy', $payment_received->id], 'method'=>'DELETE')) !!}
                    
                      {!! Form::button('Delete', ['class'=>'btn btn-danger', 'type'=>'submit']) !!}

                      {!! Form::close() !!}
                </td>
                @endif
              </tr>
              @endforeach  
          </tbody>
        </table>

        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h2>Create Payment Received</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

			  <div class="modal-body">
                {!! Form::open(['route'=>'payment_received.store', 'files'=>true]) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            {!! Form::label('date', 'Date:') !!}
                            {!! Form::date('date', Carbon\Carbon::today()->format('Y-m-d'), ['class'=>'form-control', 'readonly']) !!}
                          </div>  
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group">
                            {!! Form::label('client_code', 'Client Code') !!}
                            <br>
                            {!! Form::select('client_code', $clients->pluck('party_id', 'id'), null, ['class'=>'form-control', 'id'=>'clientCode', 'style'=>'width:350px', 'onchange'=>'checkClientName(this)']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('paid_amount', 'Paid Amount:') !!}
                            {!! Form::text('paid_amount', null, ['class'=>'form-control', 'required']) !!}
                          </div>  

                          <div class="form-group">
                            {!! Form::label('gc_percentage', 'Gateway Charge %:') !!}
                            {!! Form::text('gc_percentage', 0, ['class'=>'form-control', 'readonly']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('money_receipt_ref', 'Money Receipt Reference:') !!}
                            {!! Form::text('money_receipt_ref', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('bd_reference', 'Bank Deposit Reference:') !!}
                            {!! Form::text('bd_reference', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('collector', 'Collector:') !!}
                            {!! Form::select('collector', $collectors->pluck('name', 'id'), null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('cheque_clearing_date', 'Cheque Clearing Date:') !!}
                            {!! Form::date('cheque_clearing_date', null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('client_name', 'Client Name') !!}
                            <br>
                            {!! Form::select('client_name', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control', 'id'=>'clientName', 'style'=>'width:350px', 'onchange'=>'checkClientCode(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('payment_mode', 'Payment Mode:') !!}
                            {!! Form::select('payment_mode', $payment_methods->pluck('method', 'id'), null, ['class'=>'form-control', 'onchange'=>'checkPaymentMethod(this)']) !!}
                          </div>  

                          <div class="form-group">
                            {!! Form::label('gc', 'Gateway Charge:') !!}
                            {!! Form::text('gc', 0, ['class'=>'form-control', 'readonly']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('total_received', 'Total Received:') !!}
                            {!! Form::text('total_received', null, ['class'=>'form-control', 'required', 'readonly']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('bd_reference_attatchment', 'Bank Deposit Reference Attatchement:') !!}
                            {!! Form::file('bd_reference_attatchment', ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('cheque_clearing_status', 'Cheque Clearing Status:') !!}
                            {!! Form::select('cheque_clearing_status', ['No Status'=>'No Status', 'Cleared'=>'Cleared', 'Due'=>'Due'], null, ['class'=>'form-control']) !!}
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

@section('footer_scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    $("#clientCode").select2({
        placeholder: 'Select a Client ID',
        allowClear: true,
        data: [{
            id: -1,
            text: '',
            selected: 'selected',
            search: '',
            hidden: true
        }]
    });

    $("#clientName").select2({
        placeholder: 'Select a Client Name',
        allowClear: true,
        data: [{
            id: -1,
            text: '',
            selected: 'selected',
            search: '',
            hidden: true
        }]
    });

    function checkClientCode(elem) {
        var client_id = elem.value;
        var op_cn = "";
        var op_hr = "";

        $.ajax({
            type: 'get',
            url: '{!!URL::to('findClient')!!}',
            data: {
                'id': client_id
            },
            success: function(data) {
                op_cn += '<option value="' + data.party_id + '">' + data.party_code + '</option>';
                op_hr += '<option value="' + data.collector_id + '">' + data.collector_name + '</option>';
                document.getElementById('clientCode').innerHTML = op_cn;
                document.getElementById('collector').innerHTML = op_hr;
                party_type_id = data.party_type_id;
            },
            error: function() {

            }
        });
    }

    function checkClientName(elem) {
        var client_id = elem.value;
        var op_cc = "";
        var op_hr = "";

        $.ajax({
            type: 'get',
            url: '{!!URL::to('findClient')!!}',
            data: {
                'id': client_id
            },
            success: function(data) {

                op_cc += '<option value="' + data.party_id + '">' + data.party_name + '</option>';
                op_hr += '<option value="' + data.collector_id + '">' + data.collector_name + '</option>';
                document.getElementById('clientName').innerHTML = op_cc;
                document.getElementById('collector').innerHTML = op_hr;
                party_type_id = data.party_type_id;
            },
            error: function() {

            }
        });
    }

    function checkPaymentMethod(elem) {
        var payment_method_id = elem.value;
        var paid_amount = document.getElementById('paid_amount').value;
        var gateway_charge;

        $.ajax({
            type: 'get',
            url: '{!!URL::to('findGatewayCharge')!!}',
            data: {
                'id': payment_method_id
            },
            success: function(data) {
                document.getElementById('gc_percentage').value = data[0].gateway_charge;
                gateway_charge = document.getElementById('gc').value = (paid_amount * data[0].gateway_charge) / 100;
                document.getElementById('total_received').value = paid_amount - gateway_charge;

            },
            error: function() {

            }
        });
    }
</script>

@endsection
