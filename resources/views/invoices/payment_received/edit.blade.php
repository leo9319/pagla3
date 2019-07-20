@extends('layouts.dashboard')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Edit Payment Received</h3></div>
				<hr>

				<div class="panel-body">
					{!! Form::model($all_payment_received, array('route'=>['payment_received.update', $all_payment_received->id], 'method'=>'PUT', 'files'=>true)) !!}
                  <div class="container-fluid">
                      <div class="row">
                        <div class="form-group col-md-6">

                          <div class="form-group">
                            {!! Form::label('client_code', 'Client Code') !!}
                            <br>
                            {!! Form::select('client_code', $clients->pluck('party_id', 'id'), null, ['class'=>'form-control', 'id'=>'clientCode', 'onchange'=>'checkClientCode(this)']) !!}
                          </div> 

                          <div class="form-group">
                            {!! Form::label('payment_mode', 'Payment Mode:') !!}
                            {!! Form::select('payment_mode', $payment_methods->pluck('method', 'id'), null, ['class'=>'form-control', 'onchange'=>'checkPaymentMethod(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('gc_percentage', 'Gateway Charge %:') !!}
                            {!! Form::text('gc_percentage', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('money_receipt_ref', 'Money Receipt Reference:') !!}
                            {!! Form::text('money_receipt_ref', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('bd_reference', 'Bank Deposit Reference:') !!}
                            {!! Form::text('bd_reference', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('collector', 'Collector:') !!}
                            {!! Form::select('collector', $collectors->pluck('name', 'id'), null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('cheque_clearing_date', 'Cheque Clearing Date:') !!}
                            {!! Form::date('cheque_clearing_date', null, ['class'=>'form-control']) !!}
                          </div>

                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('client_name', 'Client Name') !!}
                            <br>
                            {!! Form::select('client_name', $clients->pluck('party_name', 'id'), null, ['class'=>'form-control', 'id'=>'clientName', 'onchange'=>'checkClientName(this)']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('paid_amount', 'Paid Amount:') !!}
                            {!! Form::text('paid_amount', null, ['class'=>'form-control']) !!}
                          </div>  

                          <div class="form-group">
                            {!! Form::label('gc', 'Gateway Charge:') !!}
                            {!! Form::text('gc', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('total_received', 'Total Received:') !!}
                            {!! Form::text('total_received', null, ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('bd_reference_attatchment', 'Bank Deposit Reference Attatchement:') !!}
                            {!! Form::file('bd_reference_attatchment', ['class'=>'form-control']) !!}
                          </div>

                          <div class="form-group">
                            {!! Form::label('cheque_clearing_status', 'Cheque Clearing Status:') !!}
                            {!! Form::select('cheque_clearing_status', ['Cleared'=>'Cleared', 'Due'=>'Due'], null, ['class'=>'form-control']) !!}
                          </div>
                          
                        </div>
                        <div class="col-md-12">
                            {!! Form::submit('Update', ['class'=>'btn btn-success btn-block']) !!}
                        </div>
                      </div>
                  </div>
                  
                {!! Form::close() !!}
              	</div>
						
					
			</div>
		</div>

			@if ( count( $errors ) > 0 )
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif

		</div>	
	</div>
</div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script type="text/javascript">
    $("#clientCode").select2({
            placeholder: 'Select a Client ID', 
            allowClear: true
        });

    $("#clientName").select2({
            placeholder: 'Select a Client Name', 
            allowClear: true
        });

    function checkClientCode(elem) {
    var client_id = document.getElementById('clientCode').value;
    var op_cn="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findClientName')!!}',
      data: {'id':client_id},
      success:function(data){
        op_cn+='<option value="'+data[0].id+'">'+data[0].party_name+'</option>';
        document.getElementById('clientName').innerHTML = op_cn;    
        party_type_id = data[0].party_type_id;  
      },
      error:function(){

      }
    });   
  }

  function checkClientName(elem) {
    var client_id = document.getElementById('clientName').value;
    var op_cc="";

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findClientCode')!!}',
      data: {'id':client_id},
      success:function(data){
        console.log(data[0].party_id);
        op_cc+='<option value="'+data[0].id+'">'+data[0].party_id+'</option>';
        document.getElementById('clientCode').innerHTML = op_cc;   
        party_type_id = data[0].party_type_id;     
      },
      error:function(){

      }
    });   
  }

  function checkPaymentMethod(elem) {
    var payment_method_id = document.getElementById('payment_mode').value;
    var paid_amount = document.getElementById('paid_amount').value;
    var gateway_charge;

    $.ajax({
      type: 'get',
      url: '{!!URL::to('findGatewayCharge')!!}',
      data: {'id':payment_method_id},
      success:function(data){
        document.getElementById('gc_percentage').value = data[0].gateway_charge;
        gateway_charge = document.getElementById('gc').value = (paid_amount * data[0].gateway_charge)/100;  
        document.getElementById('total_received').value = paid_amount - gateway_charge;  


      },
      error:function(){

      }
    });   
  }

  
  </script>

@endsection