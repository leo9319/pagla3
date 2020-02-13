@extends('layouts.dashboard') 

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> Sales 
        @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'hr')
        <!-- Do Not show anything -->
        @else
        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create Sales</button>
        @endif

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
                        <th>Invoice</th>

                        @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr') 
                        @else
                        <th>Edit</th>
                        <th>Delete</th>
                        @endif

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
                        <th>Invoice</th>

                        @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr') 
                        @else
                        <th>Edit</th>
                        <th>Delete</th>
                        @endif
                        
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

                        <!-- Audit Approval -->
                        @if($user->user_type == 'audit') @if($sale->audit_approval == -1)
                        <td>
                            {{ link_to_route('sales.audit.approval','Approve', [$sale->id], ['class' => 'btn btn-warning btn-sm btn-width']) }} {{ link_to_route('sales.audit.dissapproval','Dissaprove', [$sale->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                        </td>
                        @elseif($sale->audit_approval == 1)
                        <td>
                            <p class="text-success font-weight-bold">Approved</p>
                        </td>
                        @elseif($sale->audit_approval == 0)
                        <td>
                            <p class="text-danger font-weight-bold">Dissapproved!</p>
                        </td>
                        @endif @else
                        <!-- Do nothing -->
                        @endif

                        <!-- Showing management approval to audit -->
                        @if($user->user_type == 'audit') @if($sale->management_approval == 1)
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
                        @endif @endif @if($sale->management_approval == 1 && $sale->audit_approval == 1)
                        <td><a href="{{ route('sales.date', ['id' => $sale->id]) }}">Generate Invoice</a></td>
                        @else
                        <td>
                            <p class="text-danger font-weight-bold">Approval Pending!</p>
                        </td>
                        @endif @if($user->user_type == 'sales' || $user->user_type == 'audit' || $user->user_type == 'warehouse' || $user->user_type == 'hr') @else
                        <td>{{ link_to_route('sales.edit','Edit', [$sale->id], ['class' => 'btn btn-primary']) }}</td>
                        <td>
                            {!! Form::open(['route'=>['sales.destroy', $sale->id], 'method'=>'DELETE']) !!} {!! Form::button('Delete', ['class'=>'btn btn-danger', 'type'=>'submit']) !!} {!! Form::close() !!}
                        </td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>

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
                                            {!! Form::label('date', 'Date') !!} {!! Form::date('date', Carbon\Carbon::today()->format('Y-m-d'), ['class'=>'form-control', 'readonly']) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('client_code', 'Client Code') !!}
                                            <br> {!! Form::select('client_id', $clients->pluck('party_id', 'id'), null, ['class'=>'form-control select2', 'id'=>'clientCode', 'style'=>'width:350px', 'onchange'=>'checkClientCode(this)']) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('invoice_no', 'Invoice No') !!} {!! Form::text('invoice_no', $invoice_id, ['class'=>'form-control']) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('client_name', 'Client Name') !!}
                                            <br> {!! Form::select('client_id', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control select2', 'id'=>'clientName', 'style'=>'width:350px', 'onchange'=>'checkClientName(this)']) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('current_sr_id', 'Current SR:') !!} {!! Form::text('current_sr_id', null, ['class'=>'form-control readonly', 'placeholder'=>'Make sure the client has a sales person assigned to that zone', 'required']) !!}
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

                                                    {!! Form::label('total_sales_before_vat', 'Total Amount Before VAT', ['class' => 'font-weight-bold']) !!} {!! Form::text('total_sales_before_vat', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'total-amount-before-vat', 'required']) !!}

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('total_sales_after_vat', 'Total Amount After VAT', ['class' => 'font-weight-bold']) !!} {!! Form::text('total_sales_after_vat', null, ['class'=>'form-control form-control-lg readonly', 'id'=>'total-amount-after-vat', 'required']) !!}
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
                                            {!! Form::label('remarks', 'Remarks') !!} {!! Form::textarea('remarks', null, ['class'=>'form-control', 'size'=>'30x3']) !!}
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
</div>
<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
</div>

@if($errors->any())
<?php echo "<script type='text/javascript'>alert('There is not enough quantity in the stock!');</script>"; ?>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript">
        var party_type_id;
        var party_type_name;
        var product_type_id;
        var commissionPerc;
        var vat;
        var overall_balance;

        var maxRows = 100;
        var x = 0;
        var product_type_id = [];
        var total_amount = [];
        let removeIndex = [];

        function checkClientCode(elem) {

            var client_id = document.getElementById('clientCode').value;
            var arr2 = document.getElementsByName('price_per_unit_before_discount[]');
            var arr3 = document.getElementsByName('price_per_unit_after_discount[]');
            var arr4 = document.getElementsByName('product_type[]');
            var arr5 = document.getElementsByName('brand[]');

            var op_cn = "";

            document.getElementById('current_sr_id').value = '';

            for (var i = 0; i < arr2.length; i++) {

                $(arr2[i]).val('');
                $(arr3[i]).val('');
                $(arr4[i]).val('');
                $(arr5[i]).val('');

            }

            $.ajax({

                type: 'get',
                url: '{!!URL::to('findClient')!!}',
                data: {'id': client_id },
                success: function(data) {

                    op_cn += '<option value="' + data.party_id + '">' + data.party_name + '</option>';

                    document.getElementById('clientName').innerHTML = op_cn;
                    document.getElementById('current_sr_id').value = data.sr_name;
                    document.getElementById('party-vat').value = data.vat;
                    overall_balance = data.overall_balance.toFixed(2);

                    party_type_id = data.party_type_id;
                    party_type_name = data.party_type_name;
                    vat = data.vat;

                },

                error: function() {

                    alert('The client cant be found!');

                }

            });

            document.getElementById('total-amount-before-vat').value = '';
            document.getElementById('total-amount-after-vat').value = '';
        }

        function checkClientName(elem) {

            var client_id = document.getElementById('clientName').value;
            var arr2 = document.getElementsByName('price_per_unit_before_discount[]');
            var arr3 = document.getElementsByName('price_per_unit_after_discount[]');
            var arr4 = document.getElementsByName('product_type[]');
            var arr5 = document.getElementsByName('brand[]');
            var op_cc = "";

            document.getElementById('current_sr_id').value = '';

            for (var i = 0; i < arr2.length; i++) {

                $(arr2[i]).val('');
                $(arr3[i]).val('');
                $(arr4[i]).val('');
                $(arr5[i]).val('');

            }

            $.ajax({
                type: 'get',
                url: '{!!URL::to('findClient')!!}',
                data: {'id': client_id},
                success: function(data) {

                    op_cc += '<option value="' + data.party_id + '">' + data.party_code + '</option>';

                    document.getElementById('clientCode').innerHTML = op_cc;
                    document.getElementById('current_sr_id').value = data.sr_name;
                    document.getElementById('party-vat').value = data.vat;
                    overall_balance = data.overall_balance.toFixed(2);

                    party_type_id = data.party_type_id;
                    party_type_name = data.party_type_name;
                    vat = data.vat;

                },
                error: function() {

                    alert('The client cant be found!');

                }

            });

            document.getElementById('total-amount-before-vat').value = '';
            document.getElementById('total-amount-after-vat').value = '';
        }

        function addProduct() {

            var numberOfProducts = document.getElementById('number_of_products');

            if (numberOfProducts.value == '') {

                alert('Please enter the number of products!');
                numberOfProducts.style.borderColor = "red";

            } else {

                numberOfProducts.classList.add('readonly');
                document.getElementById('product-button').onclick = "#";

                for (var i = 0; i < numberOfProducts.value; i++) {

                    var html = `<div class="form-group">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> {!! Form:: label("product_code", "Product Code") !!} {!! Form:: select("product_code[]", $products->pluck("product_code", "id"), null, ["class"=>"form-control select2", "id"=>"productid-#", "style"=>"width:350px", "onchange"=>"checkWithProductCode(this, #)"]) !!} 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> {!! Form:: label("product_name", "Product Name") !!} {!! Form:: select("product_name[]", $products->pluck("product_name", "id"), null, ["class"=>"form-control select2", "id"=>"productName-#", "style"=>"width:350px", "onchange"=>"checkWithProductName(this, #)"]) !!} 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> {!! Form:: label("product_type", "Product Types") !!} {!! Form:: text("product_type[]", null, ["class"=>"form-control readonly", "id"=>"productType-#"]) !!} 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> {!! Form:: label("brand", "Brand") !!} {!! Form:: text("brand[]", null, ["class"=>"form-control readonly", "id"=>"productBrand-#"]) !!} 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> {!! Form:: label("price_per_unit_before_discount", "Price/Unit (Before Discount)") !!} {!! Form:: text("price_per_unit_before_discount[]", null, ["class"=>"form-control readonly", "id"=>"productPriceBeforeDiscount-#", "required"]) !!} 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> {!! Form:: label("discount", "Discount") !!} {!! Form:: number("discount[]", null, ["class"=>"form-control", 'step' => '0.01', "id"=>"discount-#", "onchange"=>"discount(this, #)"]) !!} 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> {!! Form:: label("price_per_unit_after_discount", "Price/Unit (After Discount)") !!} {!! Form:: text("price_per_unit_after_discount[]", null, ["class"=>"form-control readonly", "id"=>"productPriceAfterDiscount-#", "required"]) !!} 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> {!! Form:: label("quantity", "Quantity") !!} {!! Form:: text("quantity[]", null, ["class"=>"form-control", "placeholder"=>"Enter Quantity", "id"=>"quantity-#", "required"]) !!} 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"> {!! Form:: label("total_before_vat", "Total Before VAT") !!} {!! Form:: text("total_before_vat[]", null, ["class"=>"form-control", "id"=>"totalBeforeVat-#", "readonly"]) !!} 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"> {!! Form:: label("vat", "Vat %") !!} {!! Form:: text("vat[]", null, ["class"=>"form-control", "id"=>"vat-#", "readonly"]) !!} 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"> {!! Form:: label("total_after_vat", "Total After VAT") !!} {!! Form:: text("total_after_vat[]", null, ["class"=>"form-control", "id"=>"totalAfterVat-#", "readonly"]) !!} 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"> {!! Form:: label("remark", "Remark:") !!} {!! Form:: text("remark[]", null, ["class"=>"form-control", "id"=>"remark-#"]) !!} 
                                </div>
                            </div>
                        </div> 

                        <a href="javascript:void()" class="btn btn-warning btn-block" id="commission" onclick="calculateTotalAmount(#)">Calculate Total</a> <a href="javascript:void()" class="btn btn-danger btn-block" id="remove" name="#">Remove Product</a> 

                    </div>`;

                    html = html.replace(/#/g, x);

                    $('#container').append(html);
                    x++;

                    $(".select2").select2({
                        placeholder: 'Select a value',
                        allowClear: true
                    });

                    $(".readonly").keydown(function(e) {
                        e.preventDefault();
                    });
                }
            }
        }

        $('#container').on('click', '#remove', function(e) {
            $(this).parent('div').remove();
            removeIndex.push(Number(this.name));
            document.getElementById('total-amount').value = '';
        });

        $("#clientCode").select2({
            placeholder: 'Select a Client ID',
            allowClear: true,
            data: [{
                id: -1,
                text: '',
                selected: 'selected',
                search: '',
                hidden: true
            }]
        });

        $("#clientName").select2({
            placeholder: 'Select a Client Name',
            allowClear: true,
            data: [{
                id: -1,
                text: '',
                selected: 'selected',
                search: '',
                hidden: true
            }]
        });

        $(".readonly").keydown(function(e) {
            e.preventDefault();
        });

        function checkWithProductCode(elem, x) {

            var prod_id = elem.value;
            var op = "";

            $.ajax({

                type: 'get',
                url: '{!!URL::to('findProductName')!!}',
                data: {'id': prod_id},
                success: function(data) {

                    var product_price = document.getElementById('productPriceBeforeDiscount-' + x);
                    var total_after_vat = document.getElementById('vat-' + x);

                    op += '<option value="' + data.product_id + '">' + data.product_name + '</option>';

                    document.getElementById('productName-' + x).innerHTML = op;
                    document.getElementById('productType-' + x).value = data.product_type;
                    document.getElementById('productBrand-' + x).value = data.brand;

                    // assigning the Vat

                    total_after_vat.value = vat;

                    // assigning the price

                    if (party_type_name == 'New distributor with SR' || party_type_name == 'Distributor with SR' || party_type_name == 'Distributor without SR') {

                        product_price.value = data.dlp;

                    } else if (party_type_name == 'Wholesaler inside Dhaka' || party_type_name == 'Wholesaler outside Dhaka' || party_type_name == 'Central' || party_type_name == 'Online on wholesale price' ||party_type_name == 'Online' || party_type_name == 'Supershop' || party_type_name == 'Corporate' || party_type_name == 'Shop in shop (SIS)') {

                        product_price.value = data.wholesale_rate;

                    } else {

                        product_price.value = data.mrp;

                    }

                    document.getElementById('quantity-' + x).placeholder = data.quantity + " units available";

                    product_type_id[x] = data.product_type;
                },
                error: function() {

                }
            });
        }

        function checkWithProductName(elem, x) {
            var prod_id = elem.value;
            var op3 = "";
            var op4 = "";

            $.ajax({
                type: 'get',
                url: '{!!URL::to('findProductName')!!}',
                data: {'id': prod_id},
                success: function(data) {

                    var product_price = document.getElementById('productPriceBeforeDiscount-' + x);
                    var total_after_vat = document.getElementById('vat-' + x);

                    op3 += '<option value="' + data.product_id + '">' + data.product_code + '</option>';

                    document.getElementById('productid-' + x).innerHTML = op3;
                    document.getElementById('productType-' + x).value = data.product_type;
                    document.getElementById('productBrand-' + x).value = data.brand;

                    // assigning the Vat

                    if (party_type_name == 'PAL-Ecommerce') {

                        vat = 5;
                        total_after_vat.value = 5;

                    } else {

                        vat = 15;
                        total_after_vat.value = 15;

                    }

                    // assigning the price

                    if (party_type_name == 'New distributor with SR' || party_type_name == 'Distributor with SR' || party_type_name == 'Distributor without SR') {
                        product_price.value = data.dlp;
                    } else if (party_type_name == 'Wholesaler inside Dhaka' || party_type_name == 'Wholesaler outside Dhaka' || party_type_name == 'Central' || party_type_name == 'Online on wholesale price' ||party_type_name == 'Online' || party_type_name == 'Supershop' || party_type_name == 'Corporate' || party_type_name == 'Shop in shop (SIS)') {
                        product_price.value = data.wholesale_rate;
                    } else {
                        product_price.value = data.mrp;
                    }

                    document.getElementById('quantity-' + x).placeholder = data.quantity + " units available";

                    product_type_id[x] = data.product_type;
                },
                error: function() {

                }
            });
        }

        function totalAmount() {

            var notFilled = false;
            var sum_before_vat = 0;
            var sum_after_vat = 0;

            var total_before_vat = document.getElementsByName('total_before_vat[]');
            var total_after_vat = document.getElementsByName('total_after_vat[]');
            var balance_including_current = document.getElementById('balance-including-invoice');

            for (var i = 0; i < total_before_vat.length; i++) {

                if (isNaN(total_before_vat[i].value) || total_before_vat[i].value == "") {
                    $(total_before_vat[i]).val('').css("border-color", "red");
                    notFilled = true;
                }

                if (isNaN(total_after_vat[i].value) || total_after_vat[i].value == "") {
                    $(total_after_vat[i]).val('').css("border-color", "red");
                    notFilled = true;
                }
            }

            if (notFilled) {
                alert('Please fill out the Highlighted');
            } else {
                for (var i = 0; i < total_before_vat.length; i++) {

                    if (removeIndex.includes(i)) {
                        continue;
                    }
                    sum_before_vat += parseFloat(total_before_vat[i].value);
                    sum_after_vat += parseFloat(total_after_vat[i].value);
                }

                document.getElementById('previous-balance').innerHTML = overall_balance;
                document.getElementById('balance-including-invoice').innerHTML = (parseFloat(overall_balance) - parseFloat(sum_after_vat)).toFixed(2);
                document.getElementById('total-amount-before-vat').value = sum_before_vat;
                document.getElementById('total-amount-after-vat').value = sum_after_vat;
                document.getElementById('submit-button').disabled = false;
            }
        }

        function calculateTotalAmount(x) {

            var ppu_before_discount = document.getElementById('productPriceBeforeDiscount-' + x);
            var discount = document.getElementById('discount-' + x);
            var total_before_vat = document.getElementById('totalBeforeVat-' + x);
            var quantity = document.getElementById('quantity-' + x);
            var ppu_after_discount = document.getElementById('productPriceAfterDiscount-' + x);
            var total_after_vat = document.getElementById('totalAfterVat-' + x);

            ppu_after_discount.value = (ppu_before_discount.value - discount.value).toFixed(2);

            total_before_vat.value = ppu_after_discount.value * quantity.value;
            total_after_vat.value = ((parseFloat(total_before_vat.value) * vat) / 100 + parseFloat(total_before_vat.value)).toFixed(2);

            document.getElementById('total-amount').value = '';

        }

        function discount(elem, number) {
            document.getElementById('amount-after-product-discount-' + number).value = '';
        }

        $('#submit-button').click(function() {
            $(this).attr('disabled', 'disabled');
            this.form.submit();
        });
    </script>
    @endsection