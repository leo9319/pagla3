<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />	
	<title>Sales Return Invoice</title>
	<link rel='stylesheet' type='text/css' href="{{asset('css/style.css')}}" />
	<link rel='stylesheet' type='text/css' href="{{asset('css/print.css')}}" media="print" />
	<script type='text/javascript' src="{{asset('js/jquery-1.3.2.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('js/example.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">

</head>
<body>
	<div id="page-wrap">
		<div id="header">RETURN INVOICE</div>

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
				    	@foreach($sales_return->clients as $client)
                			{{$client->party_name}}
                		@endforeach
                	</td> 
				  </tr>
				  <tr>
				    <td class="text-right font-weight-bold">Client ID:</td>
				    <td>
				    	@foreach($sales_return->clients as $client)
                			{{$client->party_id}}
                		@endforeach
                	</td> 
				  </tr>
				  <tr>
				    <td class="text-right font-weight-bold">Address:</td>
				    <td>
                    	@foreach($sales_return->clients as $client)
                			{{$client->address}}
                		@endforeach
                	</td>
				  </tr>
				  <tr>
				    <td class="text-right font-weight-bold">ATTN:</td>
				    <td>
                    	@foreach($sales_return->clients as $client)
                			{{$client->contact_person}}
                		@endforeach
                	</td>
				  </tr>
				  <tr>
				    <td class="text-right font-weight-bold">Phone:</td>
				    <td>
                		@foreach($sales_return->clients as $client)
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
	                    <td>{{ $sales_return->date }}</td>
	                </tr>
	                <tr>
	                    <td class="meta-head">Invoice #</td>
	                    <td>{{ $sales_return->invoice_no }}</td>
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
		      <th>Commission/Discount Amount</th>
		      <th>Price after commission</th>
		      <th>Qty In Pcs</th>
		      <th>Total In TK (Before Commission)</th>
		      <th>Total In TK (After Commission)</th>
		      <th>Remark</th>
		  </tr>
		  	<?php $counter = 1; ?>
		  	@foreach($sales_return->sales_returns_products as $sales_returns_product)
		  		@foreach($sales_returns_product->products as $product)
		  		<tr>
			      <td>{{ $counter }}</td>
			      <td>{{$product->product_code}}</td>
			      <td colspan="4">{{$product->product_name}}</td>
			      <td colspan="2">{{$product->product_size}}</td>
			      <td>{{$sales_returns_product->price_per_unit}}</td>
			      <td>{{$sales_returns_product->commission_percentage}}%</td>
			      <td>{{ ($sales_returns_product->price_per_unit * $sales_returns_product->commission_percentage)/100 }}</td>
			      <td>{{ ($sales_returns_product->price_per_unit - ($sales_returns_product->price_per_unit * $sales_returns_product->commission_percentage)/100) }}</td>
			      <td>{{ $sales_returns_product->quantity }}</td>
			      <td>{{ number_format((($sales_returns_product->price_per_unit) * ($sales_returns_product->quantity))) }}</td>
			      <td>{{ number_format((($sales_returns_product->price_per_unit - ($sales_returns_product->price_per_unit * $sales_returns_product->commission_percentage)/100) * ($sales_returns_product->quantity))) }}</td>
			      <td>{{ $sales_returns_product->remark }}</td>
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
		    	<div class="font-weight-bold">
		    		<?php $total_before_commission = 0; ?>
		    		@foreach($sales_return->sales_returns_products as $sales_returns_product)
		    			 <?php $total_before_commission += ($sales_returns_product->price_per_unit) * ($sales_returns_product->quantity); ?>
		    		@endforeach
		    		{{ number_format($total_before_commission) }}
		    	</div>
		    </td>
		    <td colspan="1">
		    	<div class="font-weight-bold">
		    		<?php $total_after_commission = 0; ?>
	    			@foreach($sales_return->sales_returns_products as $sales_returns_product)
		    			<?php $total_after_commission += (($sales_returns_product->price_per_unit - ($sales_returns_product->price_per_unit * $sales_returns_product->commission_percentage)/100) * ($sales_returns_product->quantity)); ?>
	    			@endforeach
	    			{{ number_format($total_after_commission) }}
    			</div>
		    </td>
		    <td colspan="1"></td>
		  </tr>
		  <tr>
		      <td colspan="8" class="blank"></td>
		      <td colspan="2" class="">Discount <b>({{$sales_return->discount_percentage}}%)</b></td>
		      <td>{{ number_format(($sales_return->total_sales_return) - ($sales_return->amount_after_discount)) }}</td>
		      <td colspan="2"></td>
		      <td></td>
		      <td class="font-weight-bold">{{ number_format($sales_return->amount_after_discount) }}</td>
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
		      <td colspan="5" class="">Total dues/advances including current sales return</td>
		      <td></td>
		      <td>
		      	{{ ($dues_including_current_return < 0) ? '('. number_format(abs($dues_including_current_return)) .')': number_format(abs($dues_including_current_return))}}
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