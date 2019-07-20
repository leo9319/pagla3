@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Sales Return
      @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'hr')
      <!-- Do Not show anything -->
      @else
        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create Sales Return</button></a>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Date</th>
              <th>Sales Invoice</th>
              <th>Invoice ID</th>
              <th>Client Code</th>
              <th>Client Name</th>
              <th>Total Sales Returns</th>
              <th>Discount Percentage</th>
              <th>Amount After Discount</th>
              <th>Remarks</th>

              @if($user->user_type == 'sub_management' || $user->user_type == 'audit')
                <th>Status</th>
              @else
                <!-- Do nothing -->
              @endif

              @if($user->user_type == 'audit')
                <th>sub_management Approved</th>
              @endif

              @if($user->user_type == 'sub_management')
                <th>Audit Approved</th>
              @endif

              <th>Invoice</th>
              @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
              <!-- Do Not show anything -->
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
              <th>Sales Invoice</th>
              <th>Invoice ID</th>
              <th>Client Code</th>
              <th>Client Name</th>
              <th>Total Sales Returns</th>
              <th>Discount Percentage</th>
              <th>Amount After Discount</th>
              <th>Remarks</th>

              @if($user->user_type == 'sub_management' || $user->user_type == 'audit')
                <th>Status</th>
              @else
                <!-- Do nothing -->
              @endif

              @if($user->user_type == 'audit')
                <th>sub_management Approved</th>
              @endif

              @if($user->user_type == 'sub_management')
                <th>Audit Approved</th>
              @endif

              <th>Invoice</th>
              @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
              <!-- Do Not show anything -->
              @else
                <th>Edit</th>
                <th>Delete</th>
              @endif
            </tr>
          </tfoot>
          <tbody>
            @foreach($sales_returns as $sales_return)
              <tr>
                <td>{{ $sales_return->id }}</td>
                <td>{{ $sales_return->date }}</td>
                <td>{{ $sales_return->sales_invoice }}</td>
                <td>{{ $sales_return->invoice_no }}</td>
                <td>
                    @foreach($sales_return->clients as $client)
                      {{ $client->party_id }}
                    @endforeach
                </td>
                <td>
                   @foreach($sales_return->clients as $client)
                      {{ $client->party_name }}
                    @endforeach
                </td>
                <td>{{ number_format($sales_return->total_sales_return, 2) }}</td>
                <td>{{ $sales_return->discount_percentage }}%</td>
                <td>{{ number_format($sales_return->amount_after_discount, 2) }}</td>
                <td>{{ $sales_return->remarks }}</td>

                <!-- sub_management Approval -->
                @if($user->user_type == 'sub_management')
                  @if($sales_return->management_approval == -1)
                    <td>
                      {{ link_to_route('sales_return.management.approval','Approve', [$sales_return->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('sales_return.management.dissapproval','Dissaprove', [$sales_return->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($sales_return->management_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($sales_return->management_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Audit Approval -->
                @if($user->user_type == 'audit')
                  @if($sales_return->audit_approval == -1)
                    <td>
                      {{ link_to_route('sales_return.audit.approval','Approve', [$sales_return->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('sales_return.audit.dissapproval','Dissaprove', [$sales_return->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($sales_return->audit_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($sales_return->audit_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Showing sub_management approval to audits -->
                @if($user->user_type == 'audit')
                  @if($sales_return->management_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($sales_return->management_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif

                <!-- Showing audit approval to sub_management -->
                @if($user->user_type == 'sub_management')
                  @if($sales_return->audit_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($sales_return->audit_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif

                @if($sales_return->management_approval == 1 && $sales_return->audit_approval == 1)
                  <td><a href="{{ route('sales_return.date', ['id' => $sales_return->id]) }}">Generate Invoice</a></td>
                @else
                  <td><p class="text-danger font-weight-bold">Approval Pending!</p></td>
                @endif

                @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
                <!-- Do Not show anything -->
                @else
                  <td>{{ link_to_route('sales_return.edit','Edit', [$sales_return->id], ['class' => 'btn btn-primary']) }}</td>
                  <td>
                      {!! Form::open(array('route'=>['sales_return.destroy', $sales_return->id], 'method'=>'DELETE')) !!}
                    
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
                <h2>Create Sales Return Invoice</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

        <div class="modal-body">
                {!! Form::open(['route' => 'sales_return.products']) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">
                          <div class="form-group">
                            {!! Form::label('client_code', 'Client Code') !!}
                            <br>
                            {!! Form::select('client_id', $clients->pluck('party_id', 'id'), null, ['class'=>'form-control select2', 'id'=>'clientCode', 'style'=>'width:350px', 'onchange'=>'checkClientCode(this)']) !!}
                          </div>        

                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('client_name', 'Client Name') !!}
                            <br>
                            {!! Form::select('client_id', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control select2', 'id'=>'clientName', 'style'=>'width:350px', 'onchange'=>'checkClientName(this)']) !!}
                          </div> 
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            {!! Form::label('sales_invoice', 'Choose from the sales invoices:') !!}
                            {!! Form::select('sales_invoice', [-1 => 'None Selected'], null, ['class'=>'form-control', 'id'=>'sales-invoices']) !!}
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="container-fluid">  
                    <button type="submit" class="btn btn-success btn-block">Next</button>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script type="text/javascript"> 

    $("#clientCode").select2({
            placeholder: 'Select a Client ID', 
            allowClear: true,
            data: [{id: -1,
                    text: '',
                    selected: 'selected',
                    search:'',
                    hidden:true}]
    });

    $("#clientName").select2({
            placeholder: 'Select a Client Name', 
            allowClear: true,
            data: [{id: -1,
                    text: '',
                    selected: 'selected',
                    search:'',
                    hidden:true}]
    });

    $(".readonly").keydown(function(e){
        e.preventDefault();
    });

  function checkClientCode(elem) {
    var client_id = document.getElementById('clientCode').value;
    var op_cn="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findClientName')!!}',
      data: {'id':client_id},
      success:function(data){
        op_cn+='<option value="'+data[0].id+'">'+data[0].party_name+'</option>';
        document.getElementById('clientName').innerHTML = op_cn;    
        getSalesInvoices(client_id);
      },
      error:function(){

      }
    });  
  }

  function checkClientName(elem) {
    var client_id = document.getElementById('clientName').value;
    var op_cc="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findClientCode')!!}',
      data: {'id':client_id},
      success:function(data){
        op_cc+='<option value="'+data[0].id+'">'+data[0].party_id+'</option>';
        document.getElementById('clientCode').innerHTML = op_cc;   
        getSalesInvoices(client_id);
      },
      error:function(){

      }
    });   
  }

  function getSalesInvoices(client_id) {
    var op_si="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findSalesInvoices')!!}',
      data: {'id':client_id},
      success:function(data){
        if (data.length > 0) {
          for (var i = 0; i < data.length; i++) {
            op_si+='<option value="'+data[i].id+'">'+data[i].invoice_no+'</option>';
            document.getElementById('sales-invoices').innerHTML = op_si;  
          }
        }
        else {
          op_si = '<option value="-1">No Invoices Found!</option>';
          document.getElementById('sales-invoices').innerHTML = op_si;  
        }
      },
      error:function(){

      }
    });   
  }

  </script> 
@endsection