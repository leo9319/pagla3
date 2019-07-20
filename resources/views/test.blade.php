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
            <td>
              
            </td> 
          </tr>
          <tr>
            <td class="text-right font-weight-bold">Address:</td>
            <td></td>
          </tr>
          <tr>
            <td class="text-right font-weight-bold">ATTN:</td>
            <td></td>
          </tr>
          <tr>
            <td class="text-right font-weight-bold">Phone:</td>
            <td></td>
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
              <td></td>
          </tr> 
          <tr>
              <td class="meta-head">Customer ID:</td>
              <td></td>
          </tr>    
        </table>
      </div>  
    </div>
    
    <div class="row">
      <div class="col-md-4">
        <table id="items">
          <tr>
            <th>Sales</th>
            <th>Sum of Sales</th>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
      <div class="col-md-4">
        <table id="items">
          <tr>
            <th>Sales</th>
            <th>Sum of Sales</th>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
      <div class="col-md-4">
        <table id="items">
          <tr>
            <th>Sales</th>
            <th>Sum of Sales</th>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
    </div>
    
  </div>

</body>
</html>