@extends('layouts.dashboard')

@section('content')
  <div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Inventory Input
      @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'hr')
      <!-- Do Not show anything -->
      @else
        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Add to Inventory</button></a>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SL</th>
              <th>Product Code</th>
              <th>Product Name</th>
              <th>Brand</th>
              <th>Product Type</th>
              <th>Quantity</th>
              <th>Expiry date</th>
              <th>Cost</th>
              <th>DLP</th>
              <th>TP</th>
              <th>MRP</th>
              <th>Batch Code</th>
              <th>Status</th>
              <th>Audit Approved</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>SL</th>
              <th>Product Code</th>
              <th>Product Name</th>
              <th>Brand</th>
              <th>Product Type</th>
              <th>Quantity</th>
              <th>Expiry date</th>
              <th>Cost</th>
              <th>DLP</th>
              <th>TP</th>
              <th>MRP</th>
              <th>Batch Code</th>
              <th>Status</th>
              <th>Audit Approved</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($inventories as $inventory)
              <tr>
                <td>{{ $inventory->id }}</td>
                <td>
                    @foreach($inventory->product_ids as $product_id)
                      {{ $product_id->product_code }}
                    @endforeach
                </td>
                <td>
                  @foreach($inventory->product_ids as $product_names)
                      {{ $product_names->product_name }}
                    @endforeach
                </td>
                <td>{{ $inventory->brand }}</td>
                <td>{{ $inventory->product_type }}</td>
                <td>{{ $inventory->quantity }}</td>
                <td>{{ $inventory->expiry_date }}</td>
                <td>{{ $inventory->cost }}</td>
                <td>{{ $inventory->dlp }}</td>
                <td>{{ $inventory->wholesale_rate }}</td>
                <td>{{ $inventory->mrp }}</td>     
                <td>{{ $inventory->batch_code }}</td>

                <!-- Management Approval -->

                @if($inventory->management_approval == -1)
                  <td>
                      {{ link_to_route('inventories.management.approval','Approve', [$inventory->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('inventories.management.dissapproval','Dissaprove', [$inventory->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                  </td>
                @elseif($inventory->management_approval == 1)
                  <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($inventory->management_approval == 0)
                  <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                @endif

                {{-- End of Management Approval --}}


                <!-- Status of audit approval to management -->

                @if($inventory->audit_approval == 1)
                  <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                @elseif($inventory->audit_approval == -1)
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
                <h2>Add Inventory</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

        <div class="modal-body">
                {!! Form::open() !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('product_id', 'Product Code:') !!}
                            <br>
                            {!! Form::select('product_id', $products->pluck('product_code', 'id'), null, ['class'=>'form-control', 'id'=>'productid', 'style'=>'width:350px', 'onchange'=>'check(this)']) !!}
                            
                          </div>

                          <div class="form-group">
                            {!! Form::label('brand', 'Brand:') !!}
                            {!! Form::text('brand', null, ['class'=>'form-control readonly', 'id'=>'productBrand', 'style'=>'width:350px', 'required']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('quantity', 'Quantity:') !!}
                            {!! Form::text('quantity', null, ['class'=>'form-control', 'required']) !!}
                          </div>


                          <div class="form-group">
                            {!! Form::label('wholesale_rate', 'Wholesale Rate:') !!}
                            {!! Form::text('wholesale_rate', null, ['class'=>'form-control', 'required']) !!}
                          </div>  

                          <div class="form-group">
                            {!! Form::label('mrp', 'MRP:') !!}
                            {!! Form::text('mrp', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('product_name', 'Product Name:') !!}
                            {!! Form::select('product_name', $products->pluck('product_name', 'id'), null, ['class'=>'form-control', 'id'=>'productName', 'style'=>'width:350px', 'onchange'=>'check2(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_type', 'Product Type:') !!}
                            {!! Form::text('product_type', null, ['class'=>'form-control readonly', 'id'=>'productType', 'required']) !!}
                          </div>
                          @if($user->user_type == 'warehouse')
                          <!-- Show nothing -->
                          @else
                          <div class="form-group">
                            {!! Form::label('cost', 'Cost:') !!}
                            {!! Form::text('cost', null, ['class'=>'form-control', 'required']) !!}
                          </div>
                          @endif

                          <div class="form-group">
                            {!! Form::label('batch_code', 'Batch Code:') !!}
                            {!! Form::text('batch_code', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('expiry_date', 'Expiry Date:') !!}
                            {!! Form::date('expiry_date', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                        </div>

                        <div class="col-md-12">
                          <h2>Special Offer</h2>
                          <hr>
                        </div>
                        
                        <div class="form-group col-md-6">
                          
                          <div class="form-group">
                            {!! Form::label('offer_start', 'Offer Start:') !!}
                            {!! Form::date('offer_start', null, ['class'=>'form-control']) !!}
                          </div>
                          <div class="form-group">
                            {!! Form::label('offer_end', 'Offer End:') !!}
                            {!! Form::date('offer_end', null, ['class'=>'form-control']) !!}
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('offer_rate', 'Offer Rate:') !!}
                            {!! Form::number('offer_rate', null, ['class'=>'form-control']) !!}
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

      console.log(prod_id);

      $.ajax({
      type: 'get',
      url: '{!!URL::to('findProductNameForInventory')!!}',
      data: {'id':prod_id},
      success:function(data){
                
                  op+='<option value="'+data[0].id+'">'+data[0].product_name+'</option>';
                  op2+='<option value="'+data[0].id+'">'+data[0].brand+'</option>';
                  document.getElementById('productName').innerHTML = op;
                  document.getElementById('productBrand').value = data[0].brand;
                  document.getElementById('productType').value = data[0].type;
                

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
      url: '{!!URL::to('findNameForInventory')!!}',
      data: {'id':prod_name},
      success:function(data){

        console.log(data[0].product_id);
        
        op3+='<option value="'+data[0].id+'">'+data[0].product_code+'</option>';
        op4+='<option value="'+data[0].id+'">'+data[0].brand+'</option>';

        document.getElementById('productid').innerHTML = op3; 
        document.getElementById('productBrand').value = data[0].brand;
        document.getElementById('productType').value = data[0].type;         
  
      },
      error:function(){

      }
    });   
  }
</script>
@endsection