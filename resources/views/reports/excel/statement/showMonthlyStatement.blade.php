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
    <div id="header">Monthly Statement</div>

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
            <td>{{ $party->party_name }}</td> 
          </tr>
          <tr>
            <td class="text-right font-weight-bold">Address:</td>
            <td>{{ $party->address }}</td>
          </tr>
          <tr>
            <td class="text-right font-weight-bold">ATTN:</td>
            <td>{{ $party->contact_person }}</td>
          </tr>
          <tr>
            <td class="text-right font-weight-bold">Phone:</td>
            <td>{{ $party->owner_number }}</td>
          </tr>
        </table>
      </div>
      <div class="col-md-6">
        <table id="meta">
          <tr>
              <td class="meta-head">Date:</td>
              <td>{{\Carbon\Carbon::now()->format('d-M-y')}}</td>
          </tr>
          <tr>
              <td class="meta-head">Statement #</td>
              <td>{{ $statement_id }}</td>
          </tr> 
          <tr>
              <td class="meta-head">Customer ID:</td>
              <td>{{ $party->party_id }}</td>
          </tr>    
        </table>
      </div>  
    </div>

    <p class="mt-4">
      <table>
          <tr>
              <td style="background-color: #eeeeee">Balance on {{ $last_date_last_month->format('jS F, Y') }}:</td>
              <td><b>{{ number_format($balanceOnLastDayLastMonth) }}</b></td>
          </tr>
          <tr>
              <td style="background-color: #eeeeee">Current Month's Balance</td>
              <td><b>{{ number_format($balanceOfCurrentDateRange) }}</b></td>
          </tr> 
          <tr>
              <td style="background-color: #eeeeee">Balance including current month:</td>
              <td><b>{{ number_format($balanceIncludingThisDateRange) }}</b></td>
          </tr>    
        </table>
    </p>
    
    <div class="row">
      <div class="col-md-3">
        <table id="items">
          <tr>
            <th>Sales</th>
            <th>Sum of Sales</th>
          </tr>
          @foreach($sales as $sale)
          <tr>
            <td>{{ Carbon\Carbon::parse($sale->date)->format('d-M-y') }}</td>
            <td>{{ number_format($sale->amount_after_discount + (float)$sale->amount_after_vat_and_discount) }}</td>
          </tr>
          @endforeach
          <tr>
            <td><b>Grand Total</b></td>
            <td><b>{{ number_format($sales->sum('amount_after_discount') + (float)$sales->sum('amount_after_vat_and_discount')) }}</b></td>
          </tr>
        </table>
      </div>
      <div class="col-md-3">
        <table id="items">
          <tr>
            <th>Returns</th>
            <th>Sum of returns</th>
          </tr>
          @foreach($returns as $return)
          <tr>
            <td>{{ Carbon\Carbon::parse($return->date)->format('d-M-y') }}</td>
            <td>{{ number_format($return->amount_after_discount) }}</td>
          </tr>
          @endforeach
          <tr>
            <td><b>Grand Total</b></td>
            <td><b>{{ number_format($returns->sum('amount_after_discount')) }}</b></td>
          </tr>
        </table>
      </div>
      <div class="col-md-3">
        <table id="items">
          <tr>
            <th>Collection</th>
            <th>Sum of Collection</th>
          </tr>
          @foreach($collections as $collection)
          <tr>
            <td>{{ Carbon\Carbon::parse($collection->date)->format('d-M-y') }}</td>
            <td>{{ number_format($collection->paid_amount) }}</td>
          </tr>
          @endforeach
          <tr>
            <td><b>Grand Total</b></td>
            <td><b>{{ number_format($collections->sum('paid_amount')) }}</b></td>
          </tr>
        </table>
      </div>
      <div class="col-md-3">
        <table id="items">
          <tr>
            <th>Adjustments</th>
            <th>Sum of adjustments</th>
          </tr>
          @foreach($adjustments as $adjustment)
          <tr>
            <td>{{ Carbon\Carbon::parse($adjustment->created_at)->format('d-M-y') }}</td>
            <td>{{ number_format($adjustment->amount) }}</td>
          </tr>
          @endforeach
          <tr>
            <td><b>Grand Total</b></td>
            <td><b>{{ number_format($adjustments->sum('amount')) }}</b></td>
          </tr>
        </table>
      </div>
    </div>
    
  </div>

</body>
</html>