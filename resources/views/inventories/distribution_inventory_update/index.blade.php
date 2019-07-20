@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Distributor Inventory Update
      @if($user->user_type == 'sales'  || $user->user_type == 'audit' || $user->user_type == 'hr')
      @else
        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create Distributor Inventory Update</button></a>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Client Code</th>
              <th>Client Name</th>
              <th>Product Code</th>
              <th>Product Name</th>
              <th>Brand</th>
              <th>Product Type</th>
              <th>Price/Unit</th>
              <th>Commission %</th>
              <th>Price/Unit After Commission</th>
              <th>Quantity</th>
              <th>Total Commission</th>
              <th>Total Before Commission</th>
              <th>Current Inventory Value After Commission</th>
              <th>Remarks</th>

              @if($user->user_type == 'management' || $user->user_type == 'audit')
                <th>Status</th>
              @else
                <!-- Do nothing -->
              @endif

              @if($user->user_type == 'audit')
                <th>Management Approved</th>
              @endif

              @if($user->user_type == 'management')
                <th>Audit Approved</th>
              @endif

              @if($user->user_type == 'sales'  || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
              @else
                <th>Edit</th>
                <th>Delete</th>
              @endif
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Client Code</th>
              <th>Client Name</th>
              <th>Product Code</th>
              <th>Product Name</th>
              <th>Brand</th>
              <th>Product Type</th>
              <th>Price/Unit</th>
              <th>Commission %</th>
              <th>Price/Unit After Commission</th>
              <th>Quantity</th>
              <th>Total Commission</th>
              <th>Total Before Commission</th>
              <th>Current Inventory Value After Commission</th>
              <th>Remarks</th>

              @if($user->user_type == 'management' || $user->user_type == 'audit')
                <th>Status</th>
              @else
                <!-- Do nothing -->
              @endif

              @if($user->user_type == 'audit')
                <th>Management Approved</th>
              @endif

              @if($user->user_type == 'management')
                <th>Audit Approved</th>
              @endif

              @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
              @else
                <th>Edit</th>
                <th>Delete</th>
              @endif
            </tr>
          </tfoot>
          <tbody> 	
            @foreach($distributor_inventory_updates as $distributor_inventory_update)
              <tr>
                <td>
                    @foreach($distributor_inventory_update->clients as $client)
                      {{ $client->party_id }}
                    @endforeach
                </td>
                <td>
                    @foreach($distributor_inventory_update->clients as $client)
                      {{ $client->party_name }}
                    @endforeach
                </td>
                <td>
                    @foreach($distributor_inventory_update->products as $product)
                      {{ $product->product_code }}
                    @endforeach
                </td>
                <td>
                    @foreach($distributor_inventory_update->products as $product)
                      {{ $product->product_name }}
                    @endforeach
                </td>
                <td>{{ $distributor_inventory_update->brand }}</td>
                <td>{{ $distributor_inventory_update->product_type }}</td>
                <td>{{ $distributor_inventory_update->ppu }}</td>
                <td>{{ $distributor_inventory_update->commission_percentage }}%</td>
                <td>{{ $distributor_inventory_update->ppu_after_commission }}</td>
                <td>{{ $distributor_inventory_update->quantity }}</td>
                <td>{{ number_format($distributor_inventory_update->total_commission,2) }}</td>
                <td>{{ number_format($distributor_inventory_update->total_before_commission,2) }}</td>
                <td>{{ number_format($distributor_inventory_update->CIVAC,2) }}</td>
                <td>{{ $distributor_inventory_update->remarks }}</td>

                <!-- Management Approval -->
                @if($user->user_type == 'management')
                  @if($distributor_inventory_update->management_approval == -1)
                    <td>
                      {{ link_to_route('distribution.management.approval','Approve', [$distributor_inventory_update->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('distribution.management.dissapproval','Dissaprove', [$distributor_inventory_update->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($distributor_inventory_update->management_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($distributor_inventory_update->management_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Audit Approval -->
                @if($user->user_type == 'audit')
                  @if($distributor_inventory_update->audit_approval == -1)
                    <td>
                      {{ link_to_route('distribution.audit.approval','Approve', [$distributor_inventory_update->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('distribution.audit.dissapproval','Dissaprove', [$distributor_inventory_update->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($distributor_inventory_update->audit_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($distributor_inventory_update->audit_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Showing management approval to audit -->
                @if($user->user_type == 'audit')
                  @if($distributor_inventory_update->management_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved!</p></td>
                  @elseif($distributor_inventory_update->management_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif

                <!-- Showing audit approval to management -->
                @if($user->user_type == 'management')
                  @if($distributor_inventory_update->audit_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved!</p></td>
                  @elseif($distributor_inventory_update->audit_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif

                @if($user->user_type == 'sales'  || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr')
                @else
                  <td>{{ link_to_route('distribution.edit','Edit', [$distributor_inventory_update->id], ['class' => 'btn btn-primary']) }}</td>
                <td>
                    {!! Form::open(array('route'=>['distribution.destroy', $distributor_inventory_update->id], 'method'=>'DELETE')) !!}
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
                <h2>Distributor Inventory Update</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

			  <div class="modal-body">
                {!! Form::open(['route'=>'distribution.store']) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('client_code', 'Client Code') !!}
                            <br>
                            {!! Form::select('client_code', $clients->pluck('party_id', 'id'), null, ['class'=>'form-control', 'id'=>'clientCode', 'style'=>'width:350px', 'onchange'=>'checkClientCode(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_code', 'Product Code') !!}
                            {!! Form::select('product_code', $products->pluck('product_code', 'id'), null, ['class'=>'form-control', 'id'=>'productid', 'style'=>'width:350px', 'onchange'=>'check(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_type', 'Product Type:') !!}
                            {!! Form::text('product_type', null, ['class'=>'form-control readonly', 'id'=>'productType', 'required']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('ppu', 'Price/Unit:') !!}
                            {!! Form::text('ppu', null, ['class'=>'form-control', 'id'=>'price_per_unit']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('client_name', 'Client Name') !!}
                            <br>
                            {!! Form::select('client_name', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control', 'id'=>'clientName', 'style'=>'width:350px', 'onchange'=>'checkClientName(this)']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('product_name', 'Product Name:') !!}
                            {!! Form::select('product_name', $products->pluck('product_name', 'id'), null, ['class'=>'form-control', 'id'=>'productName', 'style'=>'width:350px', 'onchange'=>'check2(this)']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('brand', 'Brand:') !!}
                            {!! Form::text('brand', null, ['class'=>'form-control readonly', 'id'=>'productBrand', 'required', 'required']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('quantity', 'Quantity:') !!}
                            {!! Form::text('quantity', 0, ['class'=>'form-control', 'required']) !!}
                          </div>
                          
                        </div>

                        <div class="col-md-12">
                          <h2 class="text-center"><button class="btn btn-success" type="button" onclick="calculateCommission()">Calculate Commission</button></h2>
                          <hr>
                        </div>

                        <div class="form-group col-md-6">
                          <div class="form-group">
                            <h4 class="text-center">Commission Percentage: </h4>
                            <br>
                            {{ Form::number('commission_percentage', null, ['class'=>'form-control', 'id'=>'commission_percentage']) }}
                            <h2 class="text-center"  id="commissionPercentage"></h2>
                          </div>                          
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            {!! Form::label('ppu_after_commission', 'Price Per Unit After Commission:') !!}
                            {!! Form::text('ppu_after_commission', null, ['class'=>'form-control']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('total_commission', 'Total Commission:') !!}
                            {!! Form::text('total_commission', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('total_before_commission', 'Total Before Commission:') !!}
                            {!! Form::text('total_before_commission', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('CIVAC', 'Current Inventory After Commission:') !!}
                            {!! Form::text('CIVAC', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            {!! Form::label('remarks', 'Remarks:') !!}
                            {!! Form::textarea('remarks', null, ['class'=>'form-control', 'size' => '30x3']) !!}
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

    $("#productCode").select2({
            placeholder: 'Select a Client Name', 
            allowClear: true
    });

    $("#productid").select2({
            placeholder: 'Select a Product ID', 
            allowClear: true
    });

    $("#productName").select2({
            placeholder: 'Select a Product Name',
            allowClear: true
    });

    $(".readonly").keydown(function(e){
            e.preventDefault();
    });

    function check(elem) {
      var prod_id = document.getElementById('productid').value;
      var op="";
      var op2="";

      $.ajax({
      type: 'get',
      url: '{!!URL::to('findProductName')!!}',
      data: {'id':prod_id},
      success:function(data){
                
                  op+='<option value="'+data[0].id+'">'+data[0].product_name+'</option>';
                  op2+='<option value="'+data[0].id+'">'+data[0].brand+'</option>';
                  document.getElementById('productName').innerHTML = op;
                  document.getElementById('productBrand').value = data[0].brand;
                  document.getElementById('productType').value = data[0].type;
                  document.getElementById('price_per_unit').value = data[0].wholesale_rate; 
                  product_type_id = data[0].product_type;
                

      },
      error:function(){

      }
    });
  }

  function check2(elem) {
    var prod_name = document.getElementById('productName').value;
    var op3="";
    var op4="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findName')!!}',
      data: {'id':prod_name},
      success:function(data){
        
        op3+='<option value="'+data[0].id+'">'+data[0].product_code+'</option>';
        op4+='<option value="'+data[0].id+'">'+data[0].brand+'</option>';

        console.log(data[0].type); 

        document.getElementById('productid').innerHTML = op3; 
        document.getElementById('productBrand').value = data[0].brand;
        document.getElementById('productType').value = data[0].type; 
        document.getElementById('price_per_unit').value = data[0].wholesale_rate; 
        product_type_id = data[0].product_type;  


  
      },
      error:function(){

      }
    });   
  }

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
        party_type_id = data[0].party_type_id;  
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
        console.log(data[0].party_id);
        op_cc+='<option value="'+data[0].id+'">'+data[0].party_id+'</option>';
        document.getElementById('clientCode').innerHTML = op_cc;   
        party_type_id = data[0].party_type_id;     
      },
      error:function(){

      }
    });   
  }

  function calculateCommission() {
    var PPU = document.getElementById('price_per_unit').value;
    var quantity = document.getElementById('quantity').value;
    var totalBeforeCommission = PPU * quantity; 
    var commission = document.getElementById('commission_percentage').value;
    var totalCommission = (commission * totalBeforeCommission)/100;
    var totalAfterCommission = totalBeforeCommission - totalCommission;
    var ppuAfterCommission = (PPU * commission)/100;
    
    document.getElementById('ppu_after_commission').value = ppuAfterCommission;
    document.getElementById('total_commission').value = totalCommission;  
    document.getElementById('total_before_commission').value = totalBeforeCommission;
    
    document.getElementById('CIVAC').value = totalBeforeCommission - totalCommission; 

    

  }
  </script>
@endsection