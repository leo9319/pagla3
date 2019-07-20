@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading text-center"><h3>Edit Distribution Inventory</h3></div>
				<hr>

				<div class="panel-body">
					{!! Form::model($distributor_inventory_update, array('route'=>['distribution.update', $distributor_inventory_update->id], 'method'=>'PUT')) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('client_code', 'Client Code') !!}
                            <br>
                            {!! Form::select('client_code', $clients->pluck('party_id', 'id'), null, ['class'=>'form-control', 'id'=>'clientCode', 'onchange'=>'checkClientCode(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_code', 'Product Code') !!}
                            {!! Form::select('product_code', $products->pluck('product_code', 'id'), null, ['class'=>'form-control', 'id'=>'productid', 'onchange'=>'check(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_type', 'Product Type') !!}
                            {!! Form::text('product_type', null, ['class'=>'form-control', 'id'=>'productType']) !!}
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
                            {!! Form::select('client_name', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control', 'id'=>'clientName', 'onchange'=>'checkClientName(this)']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('product_name', 'Product Name:') !!}
                            {!! Form::select('product_name', $products->pluck('product_name', 'id'), null, ['class'=>'form-control', 'id'=>'productName', 'onchange'=>'check2(this)']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('brand', 'Brand:') !!}
                            {!! Form::text('brand', null, ['class'=>'form-control', 'id'=>'productBrand']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('quantity', 'Quantity:') !!}
                            {!! Form::text('quantity', null, ['class'=>'form-control']) !!}
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
                            {!! Form::text('CIVAC', null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            {!! Form::label('remarks', 'Remarks:') !!}
                            {!! Form::textarea('remarks', null, ['class'=>'form-control', 'size' => '30x3']) !!}
                          </div>

                          <div class="form-group">
                          	{!! Form::submit('Update', ['class'=>'btn btn-success btn-block']) !!}
                          </div>
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

		</div>	
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script type="text/javascript">
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