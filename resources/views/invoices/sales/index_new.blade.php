@extends('layouts.master') 

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i>Sales
        <button 
            type="button" 
            class="btn btn-success pull-right" 
            data-toggle="modal" 
            data-target="#myModal"
        >Create Sales</button>
    </div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <sale-table></sale-table>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2>Create Sales</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        {!! Form::open(['route' => 'sales.store', 'autocomplete'=>'off']) !!}
                        <div class="container-fluid">
                            <div class="row">
                                <div class="form-group col-md-6">

                                    {{-- hidden fields --}} 
                                    {!! Form::hidden('party_vat', null, ['id'=>'party-vat']) !!}

                                    <div class="form-group">
                                        {!! Form::label('date', 'Date') !!} 
                                        {!! Form::date('date', Carbon\Carbon::today()->format('Y-m-d'), ['class'=>'form-control', 'readonly']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('client_code', 'Client Code') !!}
                                        <br> 
                                        {!! Form::select('client_id', $clients->pluck('party_id', 'id'), null, ['class'=>'form-control select2', 'id'=>'clientCode', 'style'=>'width:350px', 'onchange'=>'checkClientCode(this)']) !!}
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('invoice_no', 'Invoice No') !!} 
                                        {!! Form::text('invoice_no', $invoice_id, ['class'=>'form-control', 'readonly']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('client_name', 'Client Name') !!}
                                        <br> 
                                        {!! Form::select('client_id', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control select2', 'id'=>'clientName', 'style'=>'width:350px', 'onchange'=>'checkClientName(this)']) !!}
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('current_sr_id', 'Current SR:') !!} 
                                        {!! Form::text('current_sr_id', null, ['class'=>'form-control readonly', 'placeholder'=>'Make sure the client has a sales person assigned to that zone', 'required']) !!}
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div id="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! Form::label('number_of_products', 'Number of Products:') !!}
                                                <input class="form-control" type="text" id="number_of_products">
                                                <a href="javascript:void()" class="btn btn-info btn-block" id="product-button" onclick="addProduct()" style="margin-bottom: 10px;">Add Products</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('total_sales_before_vat', 'Total Amount Before VAT', ['class' => 'font-weight-bold']) !!} 
                                                {!! Form::text('total_sales_before_vat', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'total-amount-before-vat', 'required']) !!}

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('total_sales_after_vat', 'Total Amount After VAT', ['class' => 'font-weight-bold']) !!} 
                                                {!! Form::text('total_sales_after_vat', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'total-amount-after-vat', 'required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-default btn-block" onclick="totalAmount()">Calculate Total Amount</button>

                                    <div class="box">
                                        <p>Previous Balance: <span id="previous-balance"></span></p>
                                        <p>Balance including this invoice: <span id="balance-including-invoice"></span></p>
                                    </div>

                                </div>
                                

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('remarks', 'Remarks') !!} 
                                        {!! Form::textarea('remarks', null, ['class'=>'form-control', 'size'=>'30x3']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="container-fluid">
                            {{--
                            <button type="submit" class="btn btn-success btn-block" onClick="this.form.submit(); this.disabled=true; this.value='Sending…';" disabled="disabled">Save</button> --}}

                            <button type="submit" id="submit-button" class="btn btn-success btn-block" disabled="disabled">Save</button>

                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>

                <div class="modal-footer">
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('footer_scripts')

<script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@endsection


