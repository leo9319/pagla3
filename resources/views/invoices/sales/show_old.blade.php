<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />	
	<title>Customer Invoice</title>
	<link rel='stylesheet' type='text/css' href="{{asset('css/style.css')}}" />
	<link rel='stylesheet' type='text/css' href="{{asset('css/print.css')}}" media="print" />
	<script type='text/javascript' src="{{asset('js/jquery-1.3.2.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('js/example.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
	<!-- <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet"> -->

</head>
<body>
	<div id="page-wrap">
		<div id="header">INVOICE</div>

		<div id="identity">
        <div id="address">
        	<div id="company-name">Purple Algorithm Ltd.</div> 
        	<div>Baridhara DOHS</div> 
        	<div>Road No. 10, House# 516 (2nd Floor)</div> 
        	<div>Dhaka-1212, Bangladesh</div>
		</div>
			<div id="logo">
				<img src="{{asset('images/logo.png')}}" alt="logo" height="115" width="115"/>
			</div>
		</div>
		
		<div style="clear:both"></div>

		<div class="row">
			<div class="col-md-6">
				<table class="borderless">
				  <tr>
				    <td class="text-right font-weight-bold">To:</td>
				    <td>
				    	@foreach($sale->clients as $client)
                			{{$client->party_name}}
                		@endforeach
                	</td> 
				  </tr>
				  <tr>
				    <td class="text-right font-weight-bold">Client ID:</td>
				    <td>
				    	@foreach($sale->clients as $client)
                			{{$client->party_id}}
                		@endforeach
                	</td> 
				  </tr>
				  <tr>
				    <td class="text-right font-weight-bold">Address:</td>
				    <td>
                    	@foreach($sale->clients as $client)
                			{{$client->address}}
                		@endforeach
                	</td>
				  </tr>
				  <tr>
				    <td class="text-right font-weight-bold">ATTN:</td>
				    <td>
                    	@foreach($sale->clients as $client)
                			{{$client->contact_person}}
                		@endforeach
                	</td>
				  </tr>
				  <tr>
				    <td class="text-right font-weight-bold">Phone:</td>
				    <td>
                		@foreach($sale->clients as $client)
                			{{$client->owner_number}}
                		@endforeach
                	</td>
				  </tr>
				</table>
			</div>
			<div class="col-md-6">
				<table id="meta">
					<tr>
	                    <td class="meta-head">Date</td>
	                    <td>{{ $sale->date }}</td>
	                </tr>
	                <tr>
	                    <td class="meta-head">Invoice #</td>
	                    <td>{{ $sale->invoice_no }}</td>
	                </tr>    
            	</table>
			</div>	
		</div>
		
		<table id="items">
		  <tr>
		  	  <th>SL.</th>
		      <th>Product Code</th>
		      <th colspan="4">Product Description</th>
		      <th colspan="2">Size</th>
		      <th>Trade Price/Pcs</th>
		      <th>Commission %</th>
		      <th>Commission/Discount</th>
		      <th>Price after commission</th>
		      <th>Qty In Pcs</th>
		      <th>Total In TK (Before Commission)</th>
		      <th>Total In TK (After Commission)</th>
		      <th>Remark</th>
		  </tr>
		  	<?php $counter = 1; ?>
		  	@foreach($sale->sale_products as $sale_product)
		  		@foreach($sale_product->products as $product)
		  		<tr>
			      <td>{{ $counter }}</td>
			      <td>{{$product->product_code}}</td>
			      <td colspan="4">{{$product->product_name}}</td>
			      <td colspan="2">{{$product->product_size}}</td>
			      <td>{{$sale_product->price_per_unit}}</td>
			      <td>{{$sale_product->commission_percentage}}%</td>
			      <td>{{ ($sale_product->price_per_unit * $sale_product->commission_percentage)/100 }}</td>
			      <td>{{ ($sale_product->price_per_unit - ($sale_product->price_per_unit * $sale_product->commission_percentage)/100) }}</td>
			      <td>{{ $sale_product->quantity }}</td>
			      <td>{{ number_format((($sale_product->price_per_unit) * ($sale_product->quantity))) }}</td>
			      <td>{{ number_format((($sale_product->price_per_unit - ($sale_product->price_per_unit * $sale_product->commission_percentage)/100) * ($sale_product->quantity))) }}</td>
			      <td>{{ $sale_product->remark }}</td>
		        </tr> 
		        <?php $counter++; ?>
		      @endforeach
	        @endforeach
		  
		  <tr id="hiderow">
		    <td colspan="1"></td>
		    <td colspan="7"><div class="text-center font-weight-bold">Total</div></td>
		    <td colspan="1"></td>
		    <td colspan="1"></td>
		    <td colspan="1"></td>
		    <td colspan="1"></td>
		    <td colspan="1"></td>
		    <td colspan="1">
		    	<div>
		    		<?php $total_before_commission = 0; ?>
		    		@foreach($sale->sale_products as $sale_product)
		    			 <?php $total_before_commission += ($sale_product->price_per_unit) * ($sale_product->quantity); ?>
		    		@endforeach
		    		{{ number_format($total_before_commission) }}
		    	</div>
		    </td>
		    <td colspan="1">
		    	<div>
		    		<?php $total_after_commission = 0; ?>
	    			@foreach($sale->sale_products as $sale_product)
		    			<?php $total_after_commission += (($sale_product->price_per_unit - ($sale_product->price_per_unit * $sale_product->commission_percentage)/100) * ($sale_product->quantity)); ?>
	    			@endforeach
	    			{{ number_format($total_after_commission) }}
    			</div>
		    </td>
		    <td colspan="1"></td>
		  </tr>
		  <tr>
		      <td colspan="8" class="blank"></td>
		      <td colspan="2" class="">Discount <b>({{$sale->discount_percentage}}%)</b></td>
		      <td>{{ number_format(($sale->total_sales) - ($sale->amount_after_discount)) }}</td>
		      <td colspan="2"></td>
		      <td></td>
		      <td class="font-weight-bold">{{ number_format($sale->amount_after_discount) }}</td>
		      <td></td>
		  </tr>
		  <tr>
		      <td colspan="8" class="blank"></td>
		      <td colspan="5" class="">Balance on [{{ Carbon\Carbon::parse($due_till_date)->subDays(1)->format('j F Y') }}] (Advances/Dues)</td>
		      <td></td>
		      <td>
		      	{{ ($overall_due < 0) ? '('. number_format(abs($overall_due)) .')': number_format(abs($overall_due))}}
		      </td>
		      <td></td>
		  </tr>
		  <tr>
		      <td colspan="8" class="blank"></td>
		      <td colspan="5" class="">Total dues including current sale</td>
		      <td></td>
		      <td>
		      	{{ ($dues_including_current_sale < 0) ? '('. number_format(abs($dues_including_current_sale)) .')': number_format(abs($dues_including_current_sale))}}
		      </td>
		      <td></td>
		  </tr>
		</table>
		<div id="terms">
		  <div>If you have any questions concerning this invoice, contact us @ 01929000400.</div>
		</div>
		<div id="clearance">
			<div class="row">
				<span class="col-md-4 font-weight-bold"><u>Inventory Department</u></span>
				<span class="col-md-4 font-weight-bold"><u>Accounts Department</u></span>
				<span class="col-md-4 font-weight-bold text-right"><u>Received By</u></span>
			</div>
		</div>
	</div>

</body>
</html>