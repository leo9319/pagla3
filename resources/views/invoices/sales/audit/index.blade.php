@extends('layouts.dashboard') 

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> Sales @if(Auth::user()->user_type == 'sales' || Auth::user()->user_type == 'audit' || Auth::user()->user_type == 'hr')
        <!-- Do Not show anything -->
        @else
        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create Sales</button>
        @endif

    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Date</th>
                        <th>Invoice ID</th>
                        <th>Client Code</th>
                        <th>Client Name</th>
                        <th>Sales (Before Vat)</th>
                        <th>Sales (After Vat)</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Management Approved</th>
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>SL.</th>
                        <th>Date</th>
                        <th>Invoice ID</th>
                        <th>Client Code</th>
                        <th>Client Name</th>
                        <th>Sales (Before Vat)</th>
                        <th>Sales (After Vat)</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Management Approved</th>
                        <th>Invoice</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ Carbon\Carbon::parse($sale->date)->format('d-m-y') }}</td>
                        <td><a href="{{ route('sales.preview', ['sale'=>$sale->id]) }}">{{ $sale->invoice_no }}</a></td>
                        <td>{{ $sale->client->party_id }}</td>
                        <td>{{ $sale->client->party_name }}</td>
                        <td>{{ number_format((float)$sale->amount_before_vat_after_discount, 2) }}</td>
                        <td>{{ number_format((float)$sale->amount_after_vat_and_discount, 2) }}</td>
                        <td>{{ $sale->remarks }}</td>
                        @if($sale->audit_approval == -1)
                        <td>
                            {{ link_to_route('sales.audit.approval','Approve', [$sale->id], ['class' => 'btn btn-warning btn-sm btn-width']) }} 
                            {{ link_to_route('sales.audit.dissapproval','Dissaprove', [$sale->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                        </td>
                        @elseif($sale->audit_approval == 1)
                        <td>
                            <p class="text-success font-weight-bold">Approved</p>
                        </td>
                        @elseif($sale->audit_approval == 0)
                        <td>
                            <p class="text-danger font-weight-bold">Dissapproved!</p>
                        </td>
                        @endif 

                        <!-- Showing management approval to audit -->

                        @if($sale->management_approval == 1)
                        <td class="text-center">
                            <p class="text-success font-weight-bold">Approved</p>
                        </td>
                        @elseif($sale->management_approval == -1)
                        <td class="text-center">
                            <p class="text-info font-weight-bold">Decision Pending</p>
                        </td>
                        @else
                        <td class="text-center">
                            <p class="text-danger font-weight-bold">Dissapproved!</p>
                        </td>
                        @endif 


                        @if($sale->management_approval == 1 && $sale->audit_approval == 1)
                        <td><a href="{{ route('sales.date', ['id' => $sale->id]) }}">Generate Invoice</a></td>
                        @else
                        <td>
                            <p class="text-danger font-weight-bold">Approval Pending!</p>
                        </td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
