<header>

			<div class="row">

				<div class="col-md-3">

					<img src="{{ asset('images/bdgovt-logo.png') }}" alt="logo" height="115" width="115">

				</div>

				<div class="col-md-6">

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
								<td>Purple Algorithm Ltd.</td>
							</tr>
							<tr>
								<td>নিবন্ধিত ব্যক্তির বিআইএন:</td>
								<td></td>
							</tr>
							<tr>
								<td>চালানপত্রইস্যু ও ঠিকানা:</td>
								<td>House-516 (A1), Road-10, Baridhara DOHS, Dhaka-1213</td>
							</tr>
						</table>

						<br>
						 
					</div>

				</div>
				<div class="col-md-3">

					<div class="text-right" id="index">
						মূসক - ৬,৩
					</div>

				</div>
			</div>

			<div class="row">

				<div class="col-md-6">

					<p>
						ক্রেতার নাম: {{ $sale->client->party_name }}<br>
						ক্রেতার বিএনআই: {{ $sale->client->bin }}<br>
						সরবরাহের গন্তব্যস্থল: {{ $sale->client->address }}</p>

				</div>

				<div class="col-md-6">

					<p>
						চালানপত্র নম্বর: {{ $sale->invoice_no }}<br>
						ইস্যুর তারিখ: {{ Carbon\Carbon::parse($sale->date)->format('jS M, Y') }}<br>
						ইস্যুর সময়: {{ Carbon\Carbon::parse($sale->updated_at)->format('h:i a') }}
					</p>

				</div>

			</div>

		</header>