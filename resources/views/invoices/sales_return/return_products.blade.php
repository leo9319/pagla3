@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Sales Return Products</h3>
				</div>
				<hr>

				<div class="panel-body">
					{!! Form::open(['route'=>'sales_return.store', 'method'=>'POST']) !!}
					<div class="container-fluid">
                		<div class="row">
                  			<div class="col-md-6">
                  				<div class="form-group">
									{!! Form::label('date', 'Date:') !!}
									{!! Form::date('date', Carbon\Carbon::today()->format('Y-m-d'), ['class'=>'form-control', 'readonly']) !!}
			                    </div>

								<div class="form-group">
									{!! Form::label('client_code', 'Client Code:') !!}
									{!! Form::text('client_code', $client_code, ['class'=>'form-control', 'readonly']) !!}
								</div> 
			                </div>

			                <div class="col-md-6">
			                	<div class="form-group">
			                      {!! Form::label('invoice_no', 'Return Invoice No:') !!}
			                      {!! Form::text('invoice_no', $return_invoice_id, ['class'=>'form-control', 'readonly']) !!}
			                    </div>

			                    <div class="form-group">
									{!! Form::label('client_name', 'Client Name:') !!}
									{!! Form::text('client_name', $client_name, ['class'=>'form-control', 'readonly']) !!}
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
									{!! Form::text('product_code[]', $product->product_code, ['class'=>'form-control', 'readonly']) !!}
								</div>
								<div class="form-group">
									{!! Form::label('product_type', 'Product Type:') !!}
									{!! Form::text('product_type[]', $product_type->type, ['class'=>'form-control', 'readonly']) !!}
								</div>
								<div class="form-group">
									{!! Form::label('price_per_unit', 'Price/Unit:') !!}
									{!! Form::text('price_per_unit[]', $sales_product->price_per_unit, ['class'=>'form-control', "id"=>"productPrice-$x", 'readonly']) !!}
								</div>
								<div class="form-group">
									{!! Form::label('total_before_commission', 'Total Before Commisison:') !!}
									{!! Form::text('total_before_commission[]', null, ['class'=>'form-control', "id"=>"totalBeforeCommission-$x", 'readonly']) !!}
								</div>
								<div class="form-group">
									{!! Form::label('bill_after_commission', 'Bill After Commisison:') !!}
									{!! Form::text('bill_after_commission[]', null, ['class'=>'form-control', "id"=>"billAfterCommission-$x", 'readonly']) !!}
								</div>
			                </div>

							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('product_name', 'Product Name:') !!}
									{!! Form::text('product_name[]', $product->product_name, ['class'=>'form-control', 'readonly']) !!}
								</div>
								<div class="form-group">
									{!! Form::label('brand', 'Brand:') !!}
									{!! Form::text('brand[]', $product->brand, ['class'=>'form-control', 'readonly']) !!}
								</div>
								<div class="form-group">
									{!! Form::label('quantity', 'Quantity:') !!}
									{!! Form::number('quantity[]', 0, ['class'=>'form-control', "id"=>"quantity-$x", 'min'=>0,'max'=>$sales_product->quantity]) !!}
								</div>
								<div class="form-group">
									{!! Form::label('commission', 'Commission %:') !!}
									{!! Form::text('commission[]', $sales_product->commission_percentage, ['class'=>'form-control', "id"=>"commission-percentage-$x", 'readonly']) !!}
								</div>
								<div class="form-group">
									{!! Form::label('total_commission', 'Total Commisison:') !!}
									{!! Form::text('total_commission[]', null, ['class'=>'form-control', "id"=>"totalCommission-$x", 'readonly']) !!}
								</div>
							</div>

							<!-- Hidden Fields -->
									{!! Form::hidden('present_sr_id', $sales_product->present_sr_id) !!}
									{!! Form::hidden('client_id', $client_id) !!}
									{!! Form::hidden('product_id[]', $product->id) !!}

							<div class="col-md-12">
								<div class="form-group">
									{!! Form::label('remark', 'Remark:') !!}
									{!! Form::text('remark[]', $sales_product->remark, ['class'=>'form-control']) !!}
								</div>

								<!-- Hidden Field -->
								<div class="form-group">
									{!! Form::hidden('sales_invoice', $sales_product->sales_invoice) !!}
								</div>
							</div>

							<div class="col-md-12 mt-3">
								<a href="javascript:void()" class="btn btn-warning btn-block" id="commission" onclick="calculateCommission(<?= $x; ?>)">Calculate Total and Commission
								</a>
							</div>

								<?php $x++; ?>
		                	@endforeach 
		                @endforeach
	                @endforeach
			                <div class="container-fluid">
								<div class="mb-3">
									<button type="button" class="btn btn-default mt-4" onclick="totalAmount()">Calculate Net Total</button>
								</div>

								<div class="form-group">
									{!! Form::label('total_sales_return', 'Total Amount:', ['class' => 'font-weight-bold readonly']) !!}
									{!! Form::text('total_sales_return', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'totalAmountID', 'required']) !!}
								</div>
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
		                        
							<div class="container-fluid"">
								<div class="form-group">
									<button type="button" class="btn btn-default" onclick="totalAmountAfterDiscount()">Calculate Amount After Discount</button>
								</div>

								<div class="form-group">
									{!! Form::label('amount_after_discount', 'Total Amount After Discount:', ['class' => 'font-weight-bold']) !!}
									{!! Form::text('amount_after_discount', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'after-discount', 'size'=>'30x3', 'required']) !!}
								</div>

								<div class="form-group">
									{!! Form::label('remarks', 'Remark:') !!}
									{!! Form::textarea('remarks', null, ['class'=>'form-control', 'size'=>'30x3']) !!}
								</div>

								<div class="form-group">
									{!! Form::submit('Submit', ['class'=>'btn btn-success btn-block']) !!}
								</div>
							</div>
			            </div>
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var total_amount = [];

	function calculateCommission(x) {
	    var price_per_unit = document.getElementById('productPrice-' + x).value;
	    var quantity = document.getElementById('quantity-' + x).value;
	    var totalBeforeCommission = document.getElementById('totalBeforeCommission-' + x).value = price_per_unit * quantity;
	    var commission_percentage = document.getElementById('commission-percentage-' + x).value;
	    var commissionAmount = (totalBeforeCommission * commission_percentage)/100;

		document.getElementById('billAfterCommission-' + x).value = totalBeforeCommission - commissionAmount;
	    document.getElementById('totalCommission-' + x).value = commissionAmount;
	    total_amount[x-1] = totalBeforeCommission - commissionAmount;
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

  	$(".readonly").keydown(function(e){
        e.preventDefault();
    });

</script>

@endsection