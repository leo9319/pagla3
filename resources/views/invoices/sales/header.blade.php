<header>

	<div class="row">

		<div class="col-md-2">

			<img src="{{ asset('images/bdgovt-logo.png') }}" alt="logo" height="115" width="115">

		</div>

		<div class="col-md-8">

			<div class="text-center line-space">

				<p>
					গণপ্রজাতন্ত্রী বাংলাদেশ সরকার <br>
				    <b>জাতীয় রাজস্ব বোর্ড</b> <br>
					<b>কর চালানপত্র </b> <br>
					<b>[বিধি ৪০ এরউপ-বিধি (১) এরদফা (গ) ও দফা (চ) দ্রষ্টব্য]</b> <br>
				</p>

				<table id="company-address">
					<tr>
						<td>নিবন্ধিত ব্যক্তির নাম:</td>
						<td><b>Purple Algorithm Ltd.</b></td>
					</tr>
					<tr>
						<td>নিবন্ধিত ব্যক্তির বিআইএন:</td>
						<td><b>001041032-0101</b></td>
					</tr>
					<tr>
						<td>চালানপত্রইস্যু ও ঠিকানা:</td>
						<td><b>House# 2 (1st Floor), Road No. 4, Baridhara, Block-J,Dhaka-1212</b></td>
					</tr>
				</table>

				<br>
				 
			</div>

		</div>
		<div class="col-md-2">

			<div class="text-right" id="index">
				মূসক - ৬,৩
			</div>

		</div>
	</div>

	<div class="row">

		<div class="col-md-6">

			<p>
				ক্রেতার নাম: <b>{{ $sale->client->party_name }}</b><br>
				ক্রেতার বিএনআই: <b>{{ $sale->client->bin }}</b><br>
				সরবরাহের গন্তব্যস্থল: <b>{{ $sale->client->address }}</b>
			</p>

		</div>

		<div class="col-md-6">

			<p>
				চালানপত্র নম্বর: <b>{{ $sale->invoice_no }}</b><br>
				ইস্যুর তারিখ: <b>{{ Carbon\Carbon::parse($sale->date)->format('jS M, Y') }}</b><br>
				ইস্যুর সময়: <b>{{ Carbon\Carbon::parse($sale->updated_at)->format('h:i a') }}</b>
			</p>

		</div>

	</div>

</header>