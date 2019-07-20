@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Edit Inventory</h3></div>
				<hr>
				{!! Form::model($inventories, array('route'=>['inventories.update', $inventories->id], 'method'=>'PUT')) !!}
				<div class="panel-body">
					<div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('product_id', 'Product ID:') !!}
                            <br>
                            {!! Form::select('product_id', $products->pluck('product_code', 'id'), null, ['class'=>'form-control', 'id'=>'productid', 'onchange'=>'check(this)']) !!}
                            
                          </div>

                          <div class="form-group">
                            {!! Form::label('brand', 'Brand:') !!}
                            {!! Form::text('brand', null, ['class'=>'form-control readonly', 'id'=>'productBrand']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('quantity', 'Quantity:') !!}
                            {!! Form::text('quantity', null, ['class'=>'form-control']) !!}
                          </div>


                          <div class="form-group">
                            {!! Form::label('wholesale_rate', 'Wholesale Rate:') !!}
                            {!! Form::text('wholesale_rate', null, ['class'=>'form-control']) !!}
                          </div>  

                          <div class="form-group">
                            {!! Form::label('mrp', 'MRP:') !!}
                            {!! Form::text('mrp', null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('product_name', 'Product Name:') !!}
                            {!! Form::select('product_name', $products->pluck('product_name', 'id'), null, ['class'=>'form-control', 'id'=>'productName', 'onchange'=>'check2(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_type', 'Product Type:') !!}
                            {!! Form::text('product_type', null, ['class'=>'form-control readonly', 'id'=>'productType']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('cost', 'Cost:') !!}
                            {!! Form::text('cost', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('batch_code', 'Batch Code:') !!}
                            {!! Form::text('batch_code', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('expiry_date', 'Expiry Date:') !!}
                            {!! Form::date('expiry_date', null, ['class'=>'form-control']) !!}
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
                        <div class="col-md-12">
				            {!! Form::submit('Submit', ['class'=>'btn btn-success btn-block']) !!}
			            </div>
                        {!! Form::close() !!}
                      </div>
                  </div>
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