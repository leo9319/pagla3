@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

  <div class="row">

      <div class="table-responsive">

        <h2 class="text-center">Offer Types</h2>
        <hr>
        <button type="button" class="btn btn-success pull-right mb-2" data-toggle="modal" data-target="#addOfferType">
          Add Offer Type
        </button>

        <table class="table table-bordered">

              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Date</th>
                  <th scope="col">Offer Type ID</th>
                  <th scope="col">Offer Type Name</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td colspan="2">Larry the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>

        </table>

      </div>


  </div>

</div>

{{-- <div class="modal fade" id="addOfferType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Offer Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open() }}

        <div class="row">

          <div class="col-md-6">

            <div class="form-group">

              {{ Form::label('start_date') }}
                    
              {{ Form::date('start_date', null, ['class'=>'form-control']) }}

            </div>
                  
          </div>
        
          <div class="col-md-6">

            <div class="form-group">

              {{ Form::label('end_date') }}
          
              {{ Form::date('end_date', null, ['class'=>'form-control']) }}

            </div>
                  
          </div>

          <div class="col-md-6">

            <div class="form-group">

              {{ Form::label('brand') }}

              {{ Form::select('brand', $products->pluck('brand', 'brand'), null, ['class'=>'form-control select2', 'style'=>'width:365px', 'multiple']) }}

            </div>
            
          </div>

          <div class="col-md-6">

            <div class="form-group">

              {{ Form::label('product_code') }}

              {{ Form::select('product_code', $products->pluck('product_code', 'id'), null, ['class'=>'form-control select2', 'style'=>'width:365px', 'multiple']) }}

            </div>
            
          </div>

        </div>

        {{ Form::close() }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> --}}


<div class="modal fade" id="addOfferType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Offer Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {{ Form::open() }}

      <div class="modal-body">
        

            <div class="form-group">

              {{ Form::label('offer_type_name') }}
                    
              {{ Form::text('offer_type_name', null, ['class'=>'form-control']) }}

            </div>

        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

      {{ Form::close() }}
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
  
  $(".select2").select2({
      placeholder: 'Select an option', 
      allowClear: true
  });

</script>

@endsection