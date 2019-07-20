@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Edit Sales</h3></div>
				<hr>

				<div class="panel-body">
					{!! Form::model($sales, array('route'=>['sales.update', $sales->id], 'method'=>'PUT')) !!}
            <div class="container-fluid">
                <div class="row">
                  <div class="form-group col-md-6">

                    <div class="form-group">
                      {!! Form::label('date', 'Date') !!}
                      {!! Form::date('date', null, ['class'=>'form-control', 'readonly']) !!}
                    </div>

                    <div class="form-group">
                      {!! Form::label('client_code', 'Client Code') !!}
                      <br>
                      {!! Form::select('client_code', $clients->pluck('party_id', 'id'), $sales->client_id, ['class'=>'form-control select2', 'id'=>'clientCode', 'onchange'=>'checkClientCode(this)', 'disabled' => true]) !!}
                    </div>         

                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('invoice_no', 'Invoice No') !!}
                      {!! Form::text('invoice_no', null, ['class'=>'form-control', 'readonly']) !!}
                    </div>

                    <div class="form-group">
                      {!! Form::label('client_name', 'Client Name') !!}
                      <br>
                      {!! Form::select('client_name', $clients->pluck('party_name', 'id'), $sales->client_id, ['class'=>'form-control select2', 'id'=>'clientName', 'onchange'=>'checkClientName(this)', 'disabled' => true]) !!}

                      {!! Form::hidden('client_id', $sales->client_id, ['id'=>'clientID']) !!}
                    </div>
                  </div>

                  <?php $x=1; ?>
                  @foreach($sales_products as $sales_product)
                    @foreach($sales_product->products as $product)
                      @foreach($product->product_types as $product_type)

                    <div class="col-md-12"><br><h4>Products Details: </h4><hr></div>

                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('product_code', 'Product Code:') !!}
                      {!! Form::select('product_code[]', $products->pluck('product_code', 'id'), $product->id, ['class'=>'form-control select2', "id"=>"productid-$x", "onchange"=>"check(this, $x)", 'disabled' => true]) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('product_type', 'Product Type:') !!}
                      {!! Form::text('product_type[]', $product_type->type, ['class'=>'form-control', "id"=>"productType-$x", 'readonly']) !!}
                      {{ Form::hidden('invisible', $product_type->id, ["id"=>"productTypeId-$x"]) }}
                    </div>
                    <div class="form-group">
                      {!! Form::label('price_per_unit', 'Price/Unit:') !!}
                      {!! Form::text('price_per_unit[]', $sales_product->price_per_unit, ['class'=>'form-control', "id"=>"productPrice-$x", "required", 'readonly']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('total_before_commission', 'Total Before Commisison:') !!}
                      {!! Form::text('total_before_commission[]', null, ['class'=>'form-control', "id"=>"totalBeforeCommission-$x", 'readonly', 'readonly']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('bill_after_commission', 'Bill After Commisison:') !!}
                      {!! Form::text('bill_after_commission[]', null, ['class'=>'form-control readonly', "id"=>"billAfterCommission-$x", 'required', 'readonly']) !!}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('product_name', 'Product Name:') !!}
                      {!! Form::select('product_name[]', $products->pluck('product_name', 'id'), $product->id, ['class'=>'form-control select2', "id"=>"productName-$x", "onchange"=>"check2(this, $x)", 'disabled' => true]) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('brand', 'Brand:') !!}
                      {!! Form::text('brand[]', $product->brand, ['class'=>'form-control', "id"=>"productBrand-$x", 'readonly']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('quantity', 'Quantity:') !!}
                      {!! Form::text('quantity[]', $sales_product->quantity, ['class'=>'form-control', "id"=>"quantity-$x", 'readonly']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('commission', 'Commission %:') !!}
                      {!! Form::text('commission[]', null, ['class'=>'form-control', "id"=>"commission-$x", 'readonly']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('total_commission', 'Total Commisison:') !!}
                      {!! Form::text('total_commission[]', null, ['class'=>'form-control', "id"=>"totalCommission-$x", 'readonly']) !!}
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('remark', 'Remark:') !!}
                      {!! Form::text('remark[]', $sales_product->remark, ['class'=>'form-control', 'readonly']) !!}
                    </div>
                    <br>
                    <a href="javascript:void()" class="btn btn-warning btn-block" id="commission" onclick="calculateCommission(<?= $x; ?>)">Calculate Total and Commission</a>
                  </div>
                       <?php $x++; ?>
                      @endforeach
                    @endforeach
                  @endforeach


                  <div class="container-fluid" style="padding-bottom: 20px; padding-top: 20px;">
                    <button type="button" class="btn btn-default" onclick="totalAmount()">Calculate Net Total</button>
                    <h4 class="pull-right" id="total-amount" style="visibility: hidden;"></h4>
                    <br><br>
                    {!! Form::label('total_sales', 'Total Amount:', ['class' => 'font-weight-bold readonly']) !!}
                    {!! Form::text('total_sales', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'totalAmountID', 'required']) !!}
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

                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('remarks', 'Previous Due:') !!}
                      {!! Form::text('remarks', abs($overall_due), ['class'=>'form-control', 'readonly']) !!}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('remarks', 'Current Due:') !!}
                      {!! Form::text('remarks', abs($dues_including_current_sale), ['class'=>'form-control', 'readonly']) !!}
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      {!! Form::label('remarks', 'Remarks') !!}
                      {!! Form::textarea('remarks', null, ['class'=>'form-control', 'size'=>'30x3', 'readonly']) !!}
                    </div>
                  </div>

                  <!-- Hidden fileds -->

                  <!-- {!! Form::hidden('total_sales', null, ['id'=>'totalSales']) !!} -->

                  <div class="col-md-12">

  			          </div>
                </div>
            </div>    
                {!! Form::close() !!}
        	</div>			
			</div>
		</div>

			@if ( count( $errors ) > 0 )
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif

      <!-- Get the party_type_id -->
      @foreach($sales->clients as $client)
        <?php $client_type_id = $client->party_type_id; ?>
        @foreach($client->clients as $client_type)
          <?php $client_type_name = $client_type->type; ?>
        @endforeach
      @endforeach

		</div>	
	</div>
</div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script type="text/javascript"> 
    var party_type_id = <?php echo $client_type_id; ?>;
    var party_type_name = <?php echo json_encode($client_type_name); ?>;
    var product_type_id = [];
    var total_amount = [];
    var commissionPerc;

    for (var i = 1; i <= <?php echo $x-1; ?>; i++) { 
        product_type_id[i] = document.getElementById('productTypeId-' + i).value;
    }

    $("#clientCode").select2({
            placeholder: 'Select a Client ID', 
            allowClear: true
        });

    $("#clientName").select2({
            placeholder: 'Select a Client Name', 
            allowClear: true
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

    $(".select2").select2({
            placeholder: 'Select a value', 
            allowClear: true
        });

    $(".readonly").keydown(function(e){
        e.preventDefault();
    });


  function check(elem, x) {
    var prod_id = elem.value;
    var op="";
    var op2="";

    $.ajax({
    type: 'get',
    url: '{!!URL::to('findProductName')!!}',
    data: {'id':prod_id},
      success:function(data){

        op+='<option value="'+data[0].id+'">'+data[0].product_name+'</option>';
        op2+='<option value="'+data[0].id+'">'+data[0].brand+'</option>';
        document.getElementById('productName-' + x).innerHTML = op;
        document.getElementById('productType-' + x).value = data[0].type;
        document.getElementById('productBrand-' + x).value = data[0].brand;
        if (party_type_name == 'Online on MRP') {
          document.getElementById('productPrice-' + x).value = data[0].mrp;
        }
        else {
          document.getElementById('productPrice-' + x).value = data[0].wholesale_rate;
        }
        product_type_id[x] = data[0].product_type;
      },
      error:function(){

      }
    });
  }

  function check2(elem, x) {
    var prod_name = elem.value;
    var op3="";
    var op4="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findName')!!}',
      data: {'id':prod_name},
      success:function(data){
        
        op3+='<option value="'+data[0].id+'">'+data[0].product_code+'</option>';
        op4+='<option value="'+data[0].id+'">'+data[0].brand+'</option>';
        document.getElementById('productid-' + x).innerHTML = op3; 
        document.getElementById('productType-' + x).value = data[0].type;
        document.getElementById('productBrand-' + x).value = data[0].brand;

        if (party_type_name == 'Online on MRP') {
          document.getElementById('productPrice-' + x).value = data[0].mrp;
        }
        else {
          document.getElementById('productPrice-' + x).value = data[0].wholesale_rate;
        }

        document.getElementById('totalBeforeCommission-' + x).value = '';
        document.getElementById('commission-' + x).value = '';
        document.getElementById('billAfterCommission-' + x).value = '';
        document.getElementById('totalCommission-' + x).value = '';
        
        product_type_id[x] = data[0].product_type;         
      },
      error:function(){

      }
    });   
  }

  function checkClientCode(elem) {
    var arr = document.getElementsByName('product_type[]');
    var arr2 = document.getElementsByName('brand[]');
    var arr3 = document.getElementsByName('price_per_unit[]');
    var arr4 = document.getElementsByName('bill_after_commission[]');
    
    for(var i=0; i<arr.length;i++){
            $(arr[i]).val('');  
            $(arr2[i]).val('');  
            $(arr3[i]).val('');  
            $(arr4[i]).val('');  
    }

    document.getElementById('totalAmountID').value = '';
    
    var client_id = elem.value;
    var op_cn="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findClientName')!!}',
      data: {'id':client_id},
      success:function(data){
        op_cn+='<option value="'+data[0].id+'">'+data[0].party_name+'</option>';
        document.getElementById('clientName').innerHTML = op_cn;    
        document.getElementById('clientID').value = data[0].id;    
        party_type_id = data[0].party_type_id;  
        party_type_name = data[0].type;
      },
      error:function(){

      }
    });   
  }

  function checkClientName(elem) {
    var arr = document.getElementsByName('product_type[]');
    var arr2 = document.getElementsByName('brand[]');
    var arr3 = document.getElementsByName('price_per_unit[]');
    var arr4 = document.getElementsByName('bill_after_commission[]');
    
    for(var i=0; i<arr.length;i++){
            $(arr[i]).val('');  
            $(arr2[i]).val('');  
            $(arr3[i]).val('');  
            $(arr4[i]).val('');  
    }

    document.getElementById('totalAmountID').value = '';

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
        document.getElementById('clientID').value = data[0].id; 
        party_type_id = data[0].party_type_id; 
        party_type_name = data[0].type;    
      },
      error:function(){

      }
    });   
  }

  function calculateCommission(x) {
    var price_per_unit = document.getElementById('productPrice-' + x).value;
    var quantity = document.getElementById('quantity-' + x).value;
    var totalBeforeCommission = document.getElementById('totalBeforeCommission-' + x).value = price_per_unit * quantity;

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findCommission')!!}',
      data: {'party_types_id':party_type_id,'product_types_id':product_type_id[x]},
      success:function(data){
        if (data.length > 0) {
          var commissionAmount = (totalBeforeCommission * data[0].commission_percentage)/100;
          document.getElementById('commission-' + x).value = data[0].commission_percentage;
          
        }
        else {
          var commissionAmount = 0;
          document.getElementById('commission-' + x).value = 0;
        }

        document.getElementById('billAfterCommission-' + x).value = totalBeforeCommission - commissionAmount;
          document.getElementById('totalCommission-' + x).value = commissionAmount;
          total_amount[x-1] = totalBeforeCommission - commissionAmount;
        
         
      },
      error:function(){

      }
    });  
  }

  function totalAmount() {
    var sum = 0;
    var notFilled = false;

    var arr = document.getElementsByName('bill_after_commission[]');

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
      for (var i = 0; i < total_amount.length; i++) {
        sum += total_amount[i];
        document.getElementById('totalAmountID').value = sum.toFixed(2);

      }
    }
  }

  function totalAmountAfterDiscount() {
    var discount_amount = document.getElementById('discount-amount');
    var discount_percentage = document.getElementById('discount-percentage');
    var after_discount = document.getElementById('after-discount');
    var total_amount = document.getElementById('totalAmountID');
    var discount_amount_on_percentage;

    if (discount_percentage.value == "") {
      // alert('Percentage is empty');
      after_discount.value = total_amount.value - discount_amount.value;
      discount_percentage.value = (discount_amount.value/total_amount.value) * 100;

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
  
  </script>

@endsection