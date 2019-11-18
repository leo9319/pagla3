<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/government.css')}}">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<style type="text/css">
		td {
		  font-size: 14px;
		}
	</style>
</head>
<body>

	<?php $i = 0; ?>

	@for ($j = 0; $j < $pages; $j++)

	<div id="page-wrap">
		
		@include('invoices.sales.header')

		<div id="main-table">
			<table class="table-sm table-bordered mt-4 mb-3" width="100%">
				  <thead>
				    <tr>
				      <th scope="col">ক্রমিক</th>
				      <th scope="col" style="width: 40%">পণ্য বা সেবার বর্ণনা (প্রযোজ্যক্ ষেত্রে ব্যান্ড নামসহ)</th>
				      <th scope="col">সরবরাহের একক</th>
				      <th scope="col">পরিমাণ</th>
				      <th scope="col">একক মূল্য<sup>১</sup> (টাকার) </th>
				      <th scope="col">মোট মূল্য<sup>১</sup> (টাকার)</th>
				      <th scope="col">সম্পূরক শূল্কের পরিমাণ (টাকায়) </th>
				      <th scope="col">মূল্য সংযোজন করের হার/ সুনির্দিষ্ট কর</th>
				      <th scope="col">মূল্ যসংযোজন কর/ সুনির্দিষ্ট কর এর পরিমাণ (টাকায়)</th>
				      <th scope="col">সকল প্রকার শুল্ক ও করসহ মূল্য</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php  $break = 0 ?>
		
				  	@while($i < count($sale->sale_products))
		
				    <tr>
				      <td>{{ $i + 1 }}</td>
				      <td style="width: 40%">{{ $sale->sale_products[$i]->product->product_name }}</td>
				      <td>1</td>
				      <td>{{ $quantity = $sale->sale_products[$i]->quantity }}</td>
				      <td>{{ number_format(($ppu = $sale->sale_products[$i]->price_per_unit), 2) }}</td>
				      <td>{{ number_format(($total = ($quantity * $ppu)), 2) }}</td>
				      <td></td>
				      <td>{{ $sale->vat ?? 0 }}%</td>
				      <td>{{ number_format(($vat = $quantity * $ppu * $sale->vat/100), 2) }}</td>
				      <td>{{ number_format(($vat + $total), 2) }}</td>
				    </tr>
		
				    <?php 
				    	$i++;
				    	$break++ 
			    	?>
		
			    	@if($break == $max_products)
						<?php break; ?>
				    @endif
		
		
				    @endwhile
		
				    @if($pages - $j == 1)
		
				    	@if($pages == 1)
				    		<?php 
				    			$number_of_products = count($sale->sale_products);
				    			$rows = $max_products -  $number_of_products;
			    			?>
		
		    			@else
							<?php
								$number_of_products = count($sale->sale_products);
								$extra_products = $number_of_products - $max_products*($pages - 1);
		
								$rows = $max_products - $extra_products;
							?>
		
				    	@endif
		
				    	@for ($k = 0; $k < $rows-1; $k++)
		
				    	<tr>
				    		<td>{{$number_of_products + $k + 1 }}</td>
				    		<td></td>
				    		<td></td>
				    		<td></td>
				    		<td></td>
				    		<td></td>
				    		<td></td>
				    		<td></td>
				    		<td></td>
				    		<td></td>
				    	</tr>
		
				    	@endfor

				    	<tr>
				    		<td colspan="5" class="text-right">সর্বমোট:</td>
				    		<td>{{ number_format($sale->getTotal('sales without vat'), 2) }}</td>
				    		<td>0</td>
				    		<td></td>
				    		<td>{{ number_format($sale->getTotal('vat'), 2) }}</td>
				    		<td>{{ number_format($sale->getTotal('sales with vat'), 2) }}</td>
				    	</tr>
		
		
				    @endif
				    
				  </tbody>
				</table>
			</div>

		<br>

		@include('invoices.sales.footer')

	</div>

	@endfor

</body>
</html>