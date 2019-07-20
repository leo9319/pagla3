<!DOCTYPE html>
<html>
<head>
    <title>Export</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>Purple Algorithm Ltd.</td>
                <td></td>
                <td></td>
                <td></td>
                <td>BILLING STATEMENT</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Date</td>
                <td>{{Carbon\Carbon::today()->format('d-M-y')}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Statement #</td>
                <td>{{$statement_id}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Customer ID:</td>
                <td>{{$client_code}}</td>
            </tr>
            <tr>
                <td>Bill To:</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>{{ $client_name }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Sales</td>
                <td>{{ $sum_of_sales }}</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Return</td>
                <td>{{ $sum_of_return }}</td>
            </tr>
            <tr>
                <td>{{ $client_address }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Collection</td>
                <td>{{ $sum_of_payment_recieved }}</td>
            </tr>
            <tr></tr>
            <tr>
                <td>Your account balance is {{ $balance }} BDT</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <th>Sales</th>
                <th>Sum of Sales</th>
                <th>Return</th>
                <th>Sum of Return</th>
                <th>Collection</th>
                <th>Sum of Collection</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $client_name }}</td>
                <td></td>
                <td>{{ $client_name }}</td>
                <td></td>
                <td>{{ $client_name }}</td>
                <td>Total Amount</td>
            </tr>
            <?php
                $return_data = array();
                $sale_data = array();
                $received_data = array();
            ?>

            @foreach($sales_return_payment_joined as $sales_return_payment_join)
            <tr>
            @if(in_array($sales_return_payment_join->sale_id, $sale_data))
                <td></td>
                <td></td>
            @else 
                <td>{{ $sales_return_payment_join->sales_date }}</td>
                <td>{{ $sales_return_payment_join->sales_amount }}</td>  
            @endif

            <?php
                array_push($sale_data, $sales_return_payment_join->sale_id);
            ?>

            @if(in_array($sales_return_payment_join->return_id, $return_data))
                <td></td>
                <td></td>
            @else 
                <td>{{ $sales_return_payment_join->sales_return_date }}</td>
                <td>{{ $sales_return_payment_join->sales_return_amount }}</td>
            @endif

            <?php 
                array_push($return_data, $sales_return_payment_join->return_id);
            ?>

            @if(in_array($sales_return_payment_join->received_id, $received_data))
                <td></td>
                <td></td>
            @else 
                <td>{{ $sales_return_payment_join->received_date }}</td>
                <td>{{ $sales_return_payment_join->amount_received }}</td>
            @endif

            <?php 
                array_push($received_data, $sales_return_payment_join->received_id);
            ?>
                
            </tr>
            @endforeach
            <tr>
                <td>Grand Total</td>
                <td>{{ $sum_of_sales }}</td>
                <td>Grand Total</td>
                <td>{{ $sum_of_return }}</td>
                <td>Grand Total</td>
                <td>{{ $sum_of_payment_recieved }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>