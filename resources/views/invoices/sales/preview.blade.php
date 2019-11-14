@extends('layouts.dashboard') 

@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-10 col-offset-1">

            <div class="panel panel-default">

                <div class="panel-heading"><h3>Preview Sales</h3></div>

                <hr>

                <div class="panel-body">

                    {!! Form::model($sales, array('route'=>['sales.update', $sales->id], 'method'=>'PUT')) !!}

                    <div class="container-fluid">

                        <div class="row">

                            <div class="form-group col-md-6">

                                <div class="form-group">
                                    {!! Form::label('date', 'Date') !!} 
                                    {!! Form::date('date', null, ['class'=>'form-control', 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('client_code', 'Client Code') !!} 
                                    {!! Form::text('client_code', $sales->client->party_id, ['class'=>'form-control', 'disabled']) !!}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('invoice_no', 'Invoice No') !!} 
                                    {!! Form::text('invoice_no', null, ['class'=>'form-control', 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('client_name', 'Client Name') !!} 
                                    {!! Form::text('client_name', $sales->client->party_name, ['class'=>'form-control', 'disabled']) !!}
                                </div>

                            </div>

                            <?php $x=1; ?>

                            @foreach($sales_products as $sales_product) 
                                @foreach($sales_product->products as $product) 
                                  @foreach($product->product_types as $product_type)

                            <div class="col-md-12">
                                <br>
                                <h4>Products Details</h4>
                                <hr>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('product_code', 'Product Code') !!} 
                                    {!! Form::text('product_code[]', $product->product_code, ['class'=>'form-control', 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('product_type', 'Product Type') !!} 
                                    {!! Form::text('product_type[]', $product_type->type, ['class'=>'form-control', 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('price_per_unit_before_discount', 'Price/Unit (Before Discount)') !!} 
                                    {!! Form::text('price_per_unit_before_discount[]', ($sales_product->price_per_unit + $sales_product->discount), ['class'=>'form-control', 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('price_per_unit_after_discount', 'Price/Unit (After Discount)') !!} 
                                    {!! Form:: text("price_per_unit_after_discount[]", $sales_product->price_per_unit, ["class"=>"form-control readonly", "readonly"]) !!}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('product_name', 'Product Name') !!} 
                                    {!! Form::text('product_name[]', $product->product_name, ['class'=>'form-control', 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('brand', 'Brand') !!} 
                                    {!! Form::text('brand[]', $product->brand, ['class'=>'form-control', 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form:: label("discount", "Discount") !!} 
                                    {!! Form:: number("discount[]", $sales_product->discount, ["class"=>"form-control", 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form:: label("quantity", "Quantity") !!} 
                                    {!! Form:: text("quantity[]", $sales_product->quantity, ["class"=>"form-control", "placeholder"=>"Enter Quantity", "readonly"]) !!}
                                </div>

                            </div>

                            <div class="col-md-12">

                              <?php

                                  $total_before_vat = $sales_product->price_per_unit * $sales_product->quantity;
                                  $toal_after_vat = $total_before_vat + ($total_before_vat * $sales->vat/100);

                              ?>

                              <div class="form-group">
                                  {!! Form:: label("total_before_vat", "Total Before VAT") !!} 
                                  {!! Form:: text("total_before_vat[]", $total_before_vat, ["class"=>"form-control", "readonly"]) !!}
                              </div>

                              <div class="form-group">
                                  {!! Form:: label("vat", "Vat %") !!} 
                                  {!! Form:: text("vat[]", $sales->vat, ["class"=>"form-control", "id"=>"vat-#", "readonly"]) !!}
                              </div>

                              <div class="form-group">
                                  {!! Form:: label("total_after_vat", "Total After VAT") !!} 
                                  {!! Form:: text("total_after_vat[]", $toal_after_vat, ["class"=>"form-control", "readonly"]) !!}
                              </div>

                              <div class="form-group">
                                  {!! Form::label('remark', 'Remark') !!} 
                                  {!! Form::text('remark[]', $sales_product->remark, ['class'=>'form-control', 'readonly']) !!}
                              </div>

                            </div>

                            <?php $x++; ?>

                                @endforeach 
                              @endforeach 
                            @endforeach

                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('amount_before_discount', 'Total Amount Before VAT', ['class' => 'font-weight-bold']) !!} 
                                    {!! Form::text('amount_after_discount', $sales->getTotal('sales without vat'), ['class'=>'form-control form-control-lg', 'disabled']) !!}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('amount_after_discount', 'Total Amount After VAT', ['class' => 'font-weight-bold']) !!}
                                    {!! Form::text('amount_after_discount', $sales->getTotal('sales with vat'), ['class'=>'form-control form-control-lg', 'disabled']) !!}
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">
                                    {!! Form::label('remarks', 'Remarks') !!} 
                                    {!! Form::textarea('remarks', null, ['class'=>'form-control', 'size'=>'30x3', 'readonly']) !!}
                                </div>

                            </div>

                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection