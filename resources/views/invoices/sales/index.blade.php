@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Sales
      @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'hr')
      <!-- Do Not show anything -->
      @else
        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create Sales</button></a>
      @endif
      
    </div>
    <div class="card-body">

      @if($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif 

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Date</th>
              <th>Invoice ID</th>
              <th>Client Code</th>
              <th>Client Name</th>
              <th>Total Sale</th>
              <th>Discount Percentage</th>
              <th>Amount After Discount</th>
              <th>Sales Person</th>
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

              <th>Invoice</th>

              @if($user->user_type == 'management')
                <th>Credit Limit Status</th>
              @endif

              @if($user->user_type == 'sales' || $user->user_type == 'audit'  || $user->user_type == 'warehouse' || $user->user_type == 'hr')
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
              <th>Invoice ID</th>
              <th>Client Code</th>
              <th>Client Name</th>
              <th>Total Sale</th>
              <th>Discount Percentage</th>
              <th>Amount After Discount</th>
              <th>Sales Person</th>
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

              <th>Invoice</th>

              @if($user->user_type == 'management')
                <th>Credit Limit Status</th>
              @endif

              @if($user->user_type == 'sales' || $user->user_type == 'audit'  || $user->user_type == 'warehouse' || $user->user_type == 'hr')
              @else
                <th>Edit</th>
                <th>Delete</th>
              @endif
            </tr>
          </tfoot>
          <tbody>
            @foreach($sales as $sale)
              <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->date }}</td>
                <td><a href="{{ route('sales.preview', ['sale'=>$sale->id]) }}">{{ $sale->invoice_no }}</a></td>
                <td>
                    @foreach($sale->clients as $client)
                      {{ $client->party_id }}
                    @endforeach
                </td>
                <td>
                   @foreach($sale->clients as $client)
                      {{ $client->party_name }}
                    @endforeach
                </td>
                <td>{{ number_format($sale->total_sales, 2) }}</td>
                @if(isset($sale->discount_percentage) && $sale->discount_percentage != NULL)
                <td>{{ $sale->discount_percentage }}%</td>
                @else
                <td></td>
                @endif
                <td>{{ number_format($sale->amount_after_discount) }}</td>
                <td>{{ $sale->present_sr_id }}</td>
                <td>{{ $sale->remarks }}</td>

                <!-- Management Approval -->
                @if($user->user_type == 'management')
                  @if($sale->management_approval == -1)
                    <td>
                      {{ link_to_route('sales.management.approval','Approve', [$sale->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('sales.management.dissapproval','Dissaprove', [$sale->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($sale->management_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($sale->management_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Audit Approval -->
                @if($user->user_type == 'audit')
                  @if($sale->audit_approval == -1)
                    <td>
                      {{ link_to_route('sales.audit.approval','Approve', [$sale->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('sales.audit.dissapproval','Dissaprove', [$sale->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>
                  @elseif($sale->audit_approval == 1)
                    <td><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($sale->audit_approval == 0)
                    <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @else
                  <!-- Do nothing -->
                @endif

                <!-- Showing management approval to audit -->
                @if($user->user_type == 'audit')
                  @if($sale->management_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($sale->management_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif

                <!-- Showing audit approval to management -->
                @if($user->user_type == 'management')
                  @if($sale->audit_approval == 1)
                    <td class="text-center"><p class="text-success font-weight-bold">Approved</p></td>
                  @elseif($sale->audit_approval == -1)
                    <td class="text-center"><p class="text-info font-weight-bold">Decision Pending</p></td>
                  @else
                    <td class="text-center"><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                  @endif
                @endif

                @if($sale->management_approval == 1 && $sale->audit_approval == 1)
                  <td><a href="{{ route('sales.date', ['id' => $sale->id]) }}">Generate Invoice</a></td>
                @else
                  <td><p class="text-danger font-weight-bold">Approval Pending!</p></td>
                @endif

                @if($user->user_type == 'management')
                  @if($sale->management_approval == -1)
                  <?php 
                      $sum_total_sales = 0; 
                      $sum_total_sales_return = 0;
                      $sum_payment_received_without_cheque = 0;
                      $sum_payment_received_with_cheque = 0;
                  ?>
                  @foreach($sale->clients as $client)
                    <!-- These are all the dues -->
                    @foreach($client->sales as $client_sale)
                      <?php            
                          $sum_total_sales += $client_sale->amount_after_discount; 
                      ?>
                    @endforeach
                    <!-- Let us find all the sales return -->
                    @foreach($client->sales_return as $client_sales_return)
                      <?php            
                          $sum_total_sales_return += $client_sales_return->amount_after_discount; 
                      ?>
                    @endforeach
                    <!-- Let us find the payment received without cheque -->
                    @foreach($client->payments_received_without_cheque as $payment_received_without_cheque)
                      <?php            
                          $sum_payment_received_without_cheque += $payment_received_without_cheque->total_received; 
                      ?>
                    @endforeach
                    <!-- Let us find the payment received with cheque -->
                    @foreach($client->payments_received_with_cheque as $payment_received_with_cheque)
                      <?php            
                          $sum_payment_received_with_cheque += $payment_received_with_cheque->total_received; 
                      ?>
                    @endforeach

                        <?php
                            $limit_so_far = $sum_total_sales - $sum_total_sales_return - $sum_payment_received_without_cheque - $sum_payment_received_with_cheque + $sale->amount_after_discount;

                            if ($limit_so_far > $client->credit_limit) {
                                echo '<td class="text-center"><p class="text-danger font-weight-bold">Credit Limit Exceeded!</p></td>';
                            }
                            else {
                              echo "<td>". number_format($limit_so_far). "</td>";

                            }
                        ?>

                  @endforeach
                  @else
                    <td></td>
                  @endif
                @endif

                @if($user->user_type == 'sales' || $user->user_type == 'audit'  || $user->user_type == 'warehouse' || $user->user_type == 'hr')
                @else
                <td>{{ link_to_route('sales.edit','Edit', [$sale->id], ['class' => 'btn btn-primary']) }}</td>
                <td>
                    {!! Form::open(['route'=>['sales.destroy', $sale->id], 'method'=>'DELETE']) !!}

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
                <h2>Create Sales</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

        <div class="modal-body">
                {!! Form::open(['route' => 'sales.store', 'autocomplete'=>'off']) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('date', 'Date') !!}
                            {!! Form::date('date', Carbon\Carbon::today()->format('Y-m-d'), ['class'=>'form-control', 'readonly']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('client_code', 'Client Code') !!}
                            <br>
                            {!! Form::select('client_id', $clients->pluck('party_id', 'id'), null, ['class'=>'form-control select2', 'id'=>'clientCode', 'style'=>'width:350px', 'onchange'=>'checkClientCode(this)']) !!}
                          </div>     

                            {!! Form::hidden('present_sr_id', null, ['id'=>'clientSR']) !!}
                            
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('invoice_no', 'Invoice No') !!}
                            {!! Form::text('invoice_no', $invoice_id, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('client_name', 'Client Name') !!}
                            <br>
                            {!! Form::select('client_id', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control select2', 'id'=>'clientName', 'style'=>'width:350px', 'onchange'=>'checkClientName(this)']) !!}
                          </div>  

                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            {!! Form::label('current_sr_id', 'Current SR:') !!}
                            {!! Form::text('current_sr_id', null, ['class'=>'form-control readonly', 'placeholder'=>'Make sure the client has a sales person assigned to that zone', 'required']) !!}
                          </div>
                        </div>

                        <div class="container-fluid">                      
                          <div id="container">
                            <div class="row">
                              <div class="col-md-12">
                                {!! Form::label('current_sr_id', 'Number of Products:') !!}
                                <input class="form-control" type="text" id="number_of_products">
                                <a href="javascript:void()" class="btn btn-info btn-block" id="product-button" onclick="addProduct()" style="margin-bottom: 10px;">Add Products</a>
                              </div>
                            </div>
                          </div>  
                        </div>

                        <div class="container-fluid" style="padding-bottom: 20px;">
                          <div style="padding-bottom: 20px;">
                            <button type="button" class="btn btn-default" onclick="totalAmount()">Calculate Total Amount</button>
                          </div>
                          
                          {!! Form::label('total_sales', 'Total Amount:', ['class' => 'font-weight-bold']) !!}
                          {!! Form::text('total_sales', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'total-amount', 'size'=>'30x3', 'required']) !!}

                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('discount_percentage', 'Discount %:') !!}
                            {!! Form::text('discount_percentage', null, ['class'=>'form-control', 'id' => 'discount-percentage', 'size'=>'30x3']) !!}
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('discount_amount', 'Discount Amount:') !!}
                            {!! Form::text('discount_amount', null, ['class'=>'form-control', 'id'=>'discount-amount', 'size'=>'30x3']) !!}
                          </div>
                        </div>
                        
                        <div class="container-fluid" style="padding-bottom: 20px;">
                          <div style="padding-top:20px; padding-bottom: 20px;">
                            <button type="button" class="btn btn-default" onclick="totalAmountAfterDiscount()">Calculate Amount After Discount</button>
                          </div>

                          {!! Form::label('amount_after_discount', 'Total Amount After Discount:', ['class' => 'font-weight-bold']) !!}
                          {!! Form::text('amount_after_discount', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'after-discount', 'size'=>'30x3', 'required']) !!}
                        </div>

                      
                        <div class="col-md-12">
                          <div class="form-group">
                            {!! Form::label('remarks', 'Remarks') !!}
                            {!! Form::textarea('remarks', null, ['class'=>'form-control', 'size'=>'30x3']) !!}
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="container-fluid">  
                    <button type="submit" class="btn btn-success btn-block" onClick="this.form.submit(); this.disabled=true; this.value='Sending…';">Save</button>
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

@if($errors->any())
  <?php echo "<script type='text/javascript'>alert('There is not enough quantity in the stock!');</script>"; ?>
@endif

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script type="text/javascript"> 
    var maxRows = 100;
    var x = 0;    
    var party_type_id;
    var party_type_name;
    var product_type_id;
    var commissionPerc;
    var product_type_id = [];    
    var total_amount = []; 
    let removeIndex = [];

    function addProduct() {
      var numberOfProducts = document.getElementById('number_of_products');

      if(numberOfProducts.value == '') {
        alert('Please enter the number of products!');
        numberOfProducts.style.borderColor = "red";
      }
      else {
        numberOfProducts.classList.add('readonly');
        document.getElementById('product-button').onclick = "#";
        
        for (var i = 0; i < numberOfProducts.value; i++) {

          var html = '<div><div class="row"><div class="col-md-6"><div class="form-group">{!! Form:: hidden("inventory_id[]", null, ["id"=>"inventory-id-#"]) !!}{!! Form::label("product_code", "Product Code") !!}{!! Form::select("product_code[]", $products->pluck("product_code", "id"), null, ["class"=>"form-control select2", "id"=>"productid-#", "style"=>"width:350px", "onchange"=>"check(this, #)"]) !!}</div><div class="form-group">{!! Form::label("product_type", "Product Types") !!}{!! Form::text("product_type[]", null, ["class"=>"form-control readonly", "id"=>"productType-#"]) !!}</div><div class="form-group">{!! Form::label("price_per_unit", "Price/Unit") !!}{!! Form::text("price_per_unit[]", null, ["class"=>"form-control readonly", "id"=>"productPrice-#", "required"]) !!}</div></div><div class="col-md-6"><div class="form-group">{!! Form::label("product_name", "Product Name:") !!}{!! Form::select("product_name[]", $products->pluck("product_name", "id"), null, ["class"=>"form-control select2", "id"=>"productName-#", "style"=>"width:350px", "onchange"=>"check2(this, #)"]) !!}</div><div class="form-group">{!! Form::label("brand", "Brand") !!}{!! Form::text("brand[]", null, ["class"=>"form-control readonly", "id"=>"productBrand-#"]) !!}</div><div class="form-group">{!! Form::label("quantity", "Quantity:") !!}{!! Form::text("quantity[]", null, ["class"=>"form-control", "placeholder"=>"Enter Quantity", "id"=>"quantity-#", "required"]) !!}</div></div><div class="col-md-12">{!! Form::label("total", "Total:") !!}{!! Form::text("total[]", null, ["class"=>"form-control", "id"=>"total-#"]) !!}</div><div class="col-md-12">{!! Form::label("discount", "Discount:") !!}{!! Form::number("discount[]", null, ["class"=>"form-control", "id"=>"discount-#", "onchange"=>"discount(this, #)"]) !!}</div><div class="col-md-12">{!! Form::label("amount_after_product_discount", "Amount After Discount:") !!}{!! Form::text("amount_after_product_discount[]", null, ["class"=>"form-control", "id"=>"amount-after-product-discount-#", "readonly"]) !!}</div><div class="col-md-12">{!! Form::label("remark", "Remark:") !!}{!! Form::text("remark[]", null, ["class"=>"form-control", "id"=>"remark-#"]) !!}</div></div><br><a href="javascript:void()" class="btn btn-warning btn-block" id="commission" onclick="calculateCommission(#)">Calculate Total</a><br><a href="javascript:void()" class="btn btn-danger btn-block" id="remove" name="#">Remove Product</a><br><br></div>';

            html = html.replace(/#/g, x);

            $('#container').append(html);
            x++;

            $(".select2").select2({
              placeholder: 'Select a value', 
              allowClear: true
            });

            $(".readonly").keydown(function(e){
              e.preventDefault();
            });
        }
      } 
    }


    $('#container').on('click', '#remove', function(e){
        $(this).parent('div').remove();
        removeIndex.push(Number(this.name));
        document.getElementById('total-amount').value = '';
    });


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

  function check(elem, x) {
    var prod_id = elem.value;
    var op="";
    // var op2="";

    $.ajax({
    type: 'get',
    url: '{!!URL::to('findProductName')!!}',
    data: {'id':prod_id},
      success:function(data){

        op+='<option value="'+data.product_id+'">'+data.product_name+'</option>';
        // op2+='<option value="'+data[0].id+'">'+data[0].brand+'</option>';
        document.getElementById('productName-' + x).innerHTML = op;
        document.getElementById('productType-' + x).value = data.product_type;
        document.getElementById('productBrand-' + x).value = data.brand;

        if (party_type_name == 'New distributor with SR' || party_type_name == 'Distributor with SR' || party_type_name == 'Distributor without SR') {
          document.getElementById('productPrice-' + x).value = data.dlp;
        }
        else if(party_type_name == 'Wholesaler inside Dhaka' || party_type_name == 'Wholesaler outside Dhaka' || party_type_name == 'Central' || party_type_name == 'Corporate' || party_type_name == 'Shop in shop (SIS)') {
          document.getElementById('productPrice-' + x).value = data.wholesale_rate;
        }
        else {
          document.getElementById('productPrice-' + x).value = data.mrp;
        }

        document.getElementById('quantity-' + x).placeholder = data.quantity + " units available";

        product_type_id[x] = data.product_type;
      },
      error:function(){

      }
    });
  }

  function check2(elem, x) {
    var prod_id = elem.value;
    var op3="";
    var op4="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findProductName')!!}',
      data: {'id':prod_id},
      success:function(data){

        
        op3+='<option value="'+data.product_id+'">'+data.product_code+'</option>';
        document.getElementById('productid-' + x).innerHTML = op3; 
        document.getElementById('productType-' + x).value = data.product_type;
        document.getElementById('productBrand-' + x).value = data.brand;

        if (party_type_name == 'New distributor with SR' || party_type_name == 'Distributor with SR' || party_type_name == 'Distributor without SR') {
          document.getElementById('productPrice-' + x).value = data.dlp;
        }
        else if(party_type_name == 'Wholesaler inside Dhaka' || party_type_name == 'Wholesaler outside Dhaka') {
          document.getElementById('productPrice-' + x).value = data.wholesale_rate;
        }
        else {
          document.getElementById('productPrice-' + x).value = data.mrp;
        }

        document.getElementById('quantity-' + x).placeholder = data.quantity + " units available";
        
        product_type_id[x] = data.product_type;        
      },
      error:function(){

      }
    });   
  }

  function checkClientCode(elem) {
    var arr  = document.getElementsByName('bill_after_commission[]');
    var arr2 = document.getElementsByName('price_per_unit[]');
    var arr3 = document.getElementsByName('product_type[]');
    var arr4 = document.getElementsByName('brand[]');

    document.getElementById('current_sr_id').value = '';
    
    for(var i=0; i<arr.length;i++){
            $(arr[i]).val('');  
            $(arr2[i]).val('');  
            $(arr3[i]).val('');  
            $(arr4[i]).val('');  
    }

    var client_id = document.getElementById('clientCode').value;
    var op_cn="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findClientName')!!}',
      data: {'id':client_id},
      success:function(data){
        op_cn+='<option value="'+data[0].id+'">'+data[0].party_name+'</option>';
        document.getElementById('clientName').innerHTML = op_cn;   
        document.getElementById('clientSR').value = data[0].hr_id;
        document.getElementById('current_sr_id').value = data[0].hr_name;
        party_type_id = data[0].party_type_id;  
        party_type_name = data[0].type;
      },
      error:function(){

      }
    });  

    document.getElementById('total-amount').value = ''; 
  }

  function checkClientName(elem) {
    var arr = document.getElementsByName('bill_after_commission[]');
    var arr2 = document.getElementsByName('price_per_unit[]');
    var arr3 = document.getElementsByName('product_type[]');
    var arr4 = document.getElementsByName('brand[]');

    document.getElementById('current_sr_id').value = '';
    
    for(var i=0; i<arr.length;i++){
            $(arr[i]).val('');  
            $(arr2[i]).val('');  
            $(arr3[i]).val('');  
            $(arr4[i]).val('');  
    }

    var client_id = document.getElementById('clientName').value;
    var op_cc="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findClientCode')!!}',
      data: {'id':client_id},
      success:function(data){
        op_cc+='<option value="'+data[0].id+'">'+data[0].party_id+'</option>';
        document.getElementById('clientCode').innerHTML = op_cc;  
        document.getElementById('clientSR').value = data[0].hr_id;
        document.getElementById('current_sr_id').value = data[0].hr_name;
        party_type_id = data[0].party_type_id; 
        party_type_name = data[0].type;
      },
      error:function(){

      }
    });   

    document.getElementById('total-amount').value = '';
  }

  function calculateCommission(x) {

    var price_per_unit          = document.getElementById('productPrice-' + x);
    var quantity                = document.getElementById('quantity-' + x);
    var total                   = document.getElementById('total-' + x);
    var discount                = document.getElementById('discount-' + x);
    var amount_after_discount   = document.getElementById('amount-after-product-discount-' + x);
    
    total.value                 = price_per_unit.value * quantity.value;
    amount_after_discount.value = total.value - discount.value;


    document.getElementById('total-amount').value = '';
    
  }

  function totalAmount() {
    var notFilled = false;
    var sum = 0;
    var arr = document.getElementsByName('amount_after_product_discount[]');

    for(var i=0; i<arr.length;i++){
        if(isNaN(arr[i].value) || arr[i].value == "") {
            $(arr[i]).val('').css( "border-color", "red" );
            notFilled = true;
        }
    }

    if(notFilled) {
      alert('Please fill out the Highlighted');
    }
    else {
      for (var i = 0; i < arr.length; i++) {
        if(removeIndex.includes(i)) {
           continue; 
         }
          sum += parseFloat(arr[i].value);
          document.getElementById('total-amount').value = sum;    
      }
    }
  }

  function totalAmountAfterDiscount() {
    var discount_amount = document.getElementById('discount-amount');
    var discount_percentage = document.getElementById('discount-percentage');
    var after_discount = document.getElementById('after-discount');
    var total_amount = document.getElementById('total-amount');
    var discount_amount_on_percentage;

    if (discount_percentage.value == "") {
      // alert('Percentage is empty');
      after_discount.value = total_amount.value - discount_amount.value;
      discount_percentage.value = ((discount_amount.value/total_amount.value) * 100).toFixed(2);
    }
    else if (discount_amount.value == ""){
      // alert('Amount is empty');
      discount_amount_on_percentage = (discount_percentage.value * total_amount.value)/100;
      discount_amount.value = discount_amount_on_percentage;
      after_discount.value = total_amount.value - discount_amount_on_percentage;
    }

    else {
      alert('Clear both fields and enter either Percentage OR Amount!');
    } 
  }

  function discount(elem, number) {
    document.getElementById('amount-after-product-discount-' + number).value = '';
  }

  </script> 
@endsection