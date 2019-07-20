@extends('layouts.dashboard')

@section('content')

<div class="card mb-3">

  <div class="card-header">

    <i class="fa fa-table"></i> Adjustment History

  </div>

  <div class="card-body">

    <div class="table-responsive">

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

        <thead>

          <tr>
            <th>Date</th>
            <th>Client ID</th>
            <th>Client Name</th>
            <th>Amount</th>
            <th>Adjusted By</th>
            <th>Reference</th>
            <th>Attatchment</th>

            @if(Auth::user()->user_type == 'management')
            <th>Action</th>
            <th>Sales Approved</th>
            <th>Warehouse Approved</th>
            @endif

            @if(Auth::user()->user_type == 'sales')
            <th>Management Approved</th>
            <th>Warehouse Approved</th>
            <th>Action</th>
            @endif


            @if(Auth::user()->user_type != 'warehouse')
            @if(Auth::user()->user_type != 'audit')
            @if(Auth::user()->user_type != 'sales')
            <th>Action</th>
            @endif
            @endif
            @endif

            @if(Auth::user()->user_type == 'warehouse')
            <th>Management Approved</th>
            <th>Sales Approved</th>
            <th>Action</th>
            @endif

            @if(Auth::user()->user_type == 'audit')
            <th>Management Approved</th>
            <th>Sales Approved</th>
            <th>Warehouse Approved</th>
            @endif

          </tr>

        </thead>

        <tfoot>

          <tr>
            <th>Date</th>
            <th>Client ID</th>
            <th>Client Name</th>
            <th>Amount</th>
            <th>Adjusted By</th>
            <th>Reference</th>
            <th>Attatchment</th>

            @if(Auth::user()->user_type == 'management')
            <th>Action</th>
            <th>Sales Approved</th>
            <th>Warehouse Approved</th>
            @endif

            @if(Auth::user()->user_type == 'sales')
            <th>Management Approved</th>
            <th>Warehouse Approved</th>
            <th>Action</th>
            @endif

            @if(Auth::user()->user_type != 'warehouse')
            @if(Auth::user()->user_type != 'audit')
            @if(Auth::user()->user_type != 'sales')
            <th>Action</th>
            @endif
            @endif
            @endif

            @if(Auth::user()->user_type == 'warehouse')
            <th>Management Approved</th>
            <th>Sales Approved</th>
            <th>Action</th>
            @endif

            @if(Auth::user()->user_type == 'audit')
            <th>Management Approved</th>
            <th>Sales Approved</th>
            <th>Warehouse Approved</th>
            @endif
          </tr>

        </tfoot>

        <tbody>

        	  @foreach($adjustment_histories as $adjustment_history)
              <tr>
                <td>{{ Carbon\Carbon::parse($adjustment_history->created_at)->format('d-m-Y') }}</td>

                <td>{{ App\Party::find($adjustment_history->client_id) ? App\Party::find($adjustment_history->client_id)->party_id : 'N/A' }}</td>

                <td>{{ App\Party::find($adjustment_history->client_id) ? App\Party::find($adjustment_history->client_id)->party_name : 'N/A' }}</td>


                <td>{{ number_format($adjustment_history->amount) }}</td>
                <td>{{ App\User::find($adjustment_history->user_id) ? App\User::find($adjustment_history->user_id)->name : 'N/A' }}</td>

                <td>{{ $adjustment_history->reference }}</td>


                @if($adjustment_history->reference_attatchment)

	                <td>
	                	<a href="{{ route('adjust-balance.download', $adjustment_history->reference_attatchment) }}">View File</a>
	                </td>

                @else

                  <td></td>

                @endif

                @if(Auth::user()->user_type == 'management')

                  @if($adjustment_history->management_approval == -1)

                    <td>
                        {{ link_to_route('adjust-balance.approval','Approve', [1, $adjustment_history->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                        {{ link_to_route('adjust-balance.approval','Dissaprove', [0, $adjustment_history->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>

                    @elseif($adjustment_history->management_approval == 1)

                    <td class="text-success font-weight-bold">Approved</td>

                    @else 

                    <td class="text-danger font-weight-bold">Disapproved</td>

                  @endif

                  @if($adjustment_history->sales_approval == -1)

                    <td class="text-warning font-weight-bold">Decision Pending</td>

                  @elseif($adjustment_history->sales_approval == 1)

                    <td class="text-success font-weight-bold">Approved</td>

                  @elseif($adjustment_history->sales_approval == 0)

                    <td class="text-danger font-weight-bold">Disapproved</td>

                  @endif

                  @if($adjustment_history->warehouse_approval == -1)

                    <td class="text-warning font-weight-bold">Decision Pending</td>

                  @elseif($adjustment_history->warehouse_approval == 1)

                    <td class="text-success font-weight-bold">Approved</td>

                  @elseif($adjustment_history->warehouse_approval == 0)

                    <td class="text-danger font-weight-bold">Disapproved</td>

                  @endif

                @endif

                @if(Auth::user()->user_type == 'sales')

                  @if($adjustment_history->management_approval == 1)
                  
                    <td class="text-success font-weight-bold">Approved</td>

                  @elseif($adjustment_history->management_approval == 0)

                    <td class="text-danger font-weight-bold">Disapproved</td>

                  @else 

                    <td class="text-warning font-weight-bold">Decision Pending</td>

                  @endif

                  @if($adjustment_history->warehouse_approval == 1)
                  
                    <td class="text-success font-weight-bold">Approved</td>

                  @elseif($adjustment_history->warehouse_approval == 0)

                    <td class="text-danger font-weight-bold">Disapproved</td>

                  @else 

                    <td class="text-warning font-weight-bold">Decision Pending</td>

                  @endif

                  @if($adjustment_history->sales_approval == -1)

                    <td>
                        {{ link_to_route('adjust-balance.approval','Approve', [1, $adjustment_history->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                        {{ link_to_route('adjust-balance.approval','Dissaprove', [0, $adjustment_history->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                    </td>

                    @elseif($adjustment_history->sales_approval == 1)

                    <td class="text-success font-weight-bold">Approved</td>

                    @else 

                    <td class="text-danger font-weight-bold">Disapproved</td>

                  @endif

                @endif

                @if(Auth::user()->user_type != 'warehouse')
                @if(Auth::user()->user_type != 'audit')
                @if(Auth::user()->user_type != 'sales')

                <td>
                  @if(Auth::user()->user_type != 'audit')

                	<button href="#" class="btn btn-info btn-sm btn-width" id="edit-balance" onclick="editBalance(this)" name="{{ $adjustment_history->id }}">Edit</button>

                  @endif

                  @if(Auth::user()->user_type == 'superadmin')

                  {!! Form::open(['route'=>['adjust-balance.destroy', $adjustment_history->id], 'method'=>'DELETE']) !!}

                  {!! Form::button('Delete', ['class'=>'btn btn-danger btn-sm btn-width', 'type'=>'submit']) !!}

                  {!! Form::close() !!}

                  @endif
                
                </td>

                @endif
                @endif
                @endif

                @if(Auth::user()->user_type == 'warehouse')

                  @if($adjustment_history->management_approval == 1)
                    <td class="text-success font-weight-bold">Approved</td>
                  @elseif($adjustment_history->management_approval == 0)
                    <td class="text-danger font-weight-bold">Disapproved</td>
                  @else
                    <td class="text-warning font-weight-bold">Decision Pending</td>
                  @endif

                  @if($adjustment_history->sales_approval == 1)
                    <td class="text-success font-weight-bold">Approved</td>
                  @elseif($adjustment_history->sales_approval == 0)
                    <td class="text-danger font-weight-bold">Disapproved</td>
                  @else
                    <td class="text-warning font-weight-bold">Decision Pending</td>
                  @endif

                  @if($adjustment_history->warehouse_approval == -1)
                  <td>
                      {{ link_to_route('adjust-balance.approval','Approve', [1, $adjustment_history->id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                      {{ link_to_route('adjust-balance.approval','Dissaprove', [0, $adjustment_history->id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                  </td>
                  @elseif($adjustment_history->warehouse_approval == 1)
                    <td class="text-success font-weight-bold">Approved</td>
                  @elseif($adjustment_history->warehouse_approval == 0)
                    <td class="text-danger font-weight-bold">Disapproved</td>
                  @endif

                @endif

                @if(Auth::user()->user_type == 'audit')

                  @if($adjustment_history->management_approval == 1)
                    <td class="text-success font-weight-bold">Approved</td>
                  @elseif($adjustment_history->management_approval == 0)
                    <td class="text-danger font-weight-bold">Disapproved</td>
                  @else
                    <td class="text-warning font-weight-bold">Decision Pending</td>
                  @endif

                  @if($adjustment_history->sales_approval == 1)
                    <td class="text-success font-weight-bold">Approved</td>
                  @elseif($adjustment_history->sales_approval == 0)
                    <td class="text-danger font-weight-bold">Disapproved</td>
                  @else
                    <td class="text-warning font-weight-bold">Decision Pending</td>
                  @endif

                  @if($adjustment_history->warehouse_approval == 1)
                    <td class="text-success font-weight-bold">Approved</td>
                  @elseif($adjustment_history->warehouse_approval == 0)
                    <td class="text-danger font-weight-bold">Disapproved</td>
                  @else
                    <td class="text-warning font-weight-bold">Decision Pending</td>
                  @endif
                @endif
                
              </tr>
            @endforeach

        </tbody>

      </table>

    </div>

  </div>

</div>




<!-- Modal -->
<div id="editAdjustment" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

    <div class="modal-header">

      <h3>:: Edit Balance</h3>

      <button type="button" class="close" data-dismiss="modal">&times;</button>

    </div>

    {{ Form::open(['route' => ['adjust-balance.update', 1], 'files' => true]) }}

     {{ method_field('PUT')}}

    <div class="modal-body">

      <table class="table table-condensed">

        <tbody>

          {{ csrf_field() }}

          <input type="hidden" id="balance-id" name="balance_id">

          <tr>
            <td>Amount:</td>
            <td><input type="number" name="amount" id="amount" class="form-control"></td>
          </tr>

          <tr>
            <td>Reference:</td>
            <td><input type="text" name="reference" id="reference" class="form-control"></td>
          </tr>

          <tr>
            <td>Attatchment:</td>
            <td><input type="file" name="reference_attatchment"></td>
          </tr>

        </tbody>

      </table>

    </div>

    <div class="modal-footer">

      <button type="submit" class="btn btn-info">Edit</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    </div>

    {{ Form::close() }}

  </div>

  </div>

</div>

<script>

    function editBalance(elem) {

      var id = elem.name;

      $.ajax({
        type: 'get',
        url: '{!!URL::to('findClientAdjustments')!!}',
        data: {'id':id},
        success:function(data){
          document.getElementById('balance-id').value = data.id;
          document.getElementById('amount').value = data.amount;
          document.getElementById('reference').value = data.reference;
        },
        error:function(){
          alert('failure');
        }
      }); 


      $("#editAdjustment").modal();

    }



</script>

@endsection