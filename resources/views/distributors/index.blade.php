@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Distributors

        <a href="#"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Add Distributor</button></a>

      
      <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Date</th>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Brand</th>
              <th>Product Size</th>
              <th>Case Size</th>
              <th>Product Type</th>
              <th>Status</th>
              <th>Audit Approved</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>SL.</th>
              <th>Date</th>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Brand</th>
              <th>Product Size</th>
              <th>Case Size</th>
              <th>Product Type</th>
              <th>Status</th>
              <th>Audit Approved</th>
            </tr>
          </tfoot>
          <tbody>
            
          </tbody>
        </table>

        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h2>Add Products</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
{{-- 
              <div class="modal-body">
                {!! Form::open(array('route'=>'products.store')) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('date', 'Date') !!}
                            {!! Form::date('date', old('date', Carbon\Carbon::today()->format('Y-m-d')), ['class'=>'form-control', 'readonly']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_name', 'Product Name:') !!}
                            {!! Form::text('product_name', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_size', 'Product Size:') !!}
                            {!! Form::text('product_size', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('case_size', 'Case Size:') !!}
                            {!! Form::text('case_size', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('product_code', 'Product Code:') !!}
                            {!! Form::text('product_code', $product_id, ['class'=>'form-control', 'readonly']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('brand', 'Brand:') !!}
                            {!! Form::text('brand', null, ['class'=>'form-control', 'required']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('product_type', 'Product Type:') !!}
                            {!! Form::select('product_type', $product_types, null, ['class'=>'form-control']) !!}
                          </div>

                        </div>
                      </div>
                  </div>

                  <div class="container-fluid">  
                    <button type="submit" class="btn btn-success btn-block">Save</button>
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
                  </div>
                  
                {!! Form::close() !!}
              </div>   --}} 

              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
@endsection