<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/government.css')}}">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

	<?php $i = 0; ?>

	@for ($j = 0; $j < $pages; $j++)

	<div id="page-wrap">
		
		@include('header')

		<table class="table-sm table-bordered mt-4 mb-3" width="100%">
		  <thead>
		    <tr>
		      <th scope="col">ক্রমিক</th>
		      <th scope="col">পণ্য বা সেবার বর্ণনা (প্রযোজ্যক্ ষেত্রে ব্যান্ড নামসহ)</th>
		      <th scope="col">সরবরাহের একক</th>
		      <th scope="col">পরিমাণ</th>
		      <th scope="col">একক মূল্য (টাকার) </th>
		      <th scope="col">মোট মূল্য (টাকার)</th>
		      <th scope="col">সম্পূরক শূল্কের পরিমাণ (টাকায়) </th>
		      <th scope="col">মূল্য সংযোজন করের হার/ সুনির্দিষ্ট কর</th>
		      <th scope="col">মূল্ যসংযোজন কর/ সুনির্দিষ্ট কর এর পরিমাণ (টাকায়)</th>
		      <th scope="col">সকল প্রকার শুল্ক ও করসহ মূল্য</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php  $break = 0 ?>

		  	@while($i < count($sales))

		    <tr>
		      <th scope="row">{{ $i + 1 }}</th>
		      <td>{{ $sales[$i]['product_id'] }}</td>
		      <td>{{ $sales[$i]['idk'] }}</td>
		      <td>{{ $sales[$i]['quantity'] }}</td>
		      <td>{{ $sales[$i]['price'] }}</td>
		      <td></td>
		      <td>{{ $sales[$i]['total'] }}</td>
		      <td>{{ $sales[$i]['vat'] }}%</td>
		      <td>{{ $sales[$i]['price_2'] }}</td>
		      <td>{{ $sales[$i]['net_total'] }}</td>
		    </tr>

		    <?php 
		    	$i++;
		    	$break++ 
	    	?>

		    @if($break == 26)
				<?php break; ?>
		    @endif

		    @endwhile
		    
		  </tbody>
		</table>

		@include('footer')

	</div>

	@endfor

</body>
</html>