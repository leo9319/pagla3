@extends('layouts.dashboard')

@section('content')
  <div class="container">
  <h2>{{$party_name->type}}</h2>          
  <table class="table">
    <thead>
      <tr>
        <th>Product Types</th>
        <th>Commission %</th>
        <th>Status</th>
        <th>Audit Approved</th>
      </tr>
    </thead>
    <tbody>
        @foreach($product_type_data as $product_type)
          <tr>
            <td>{{ $product_type->type }}</td>
            <td>{{ $product_type->commission_percentage }}</td>

            @if($product_type->management_approval == -1)
              <td>
                  {{ link_to_route('commissions.management.approval','Approve', ['id_party' => $id, 'id_product' => $product_type->product_types_id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                  {{ link_to_route('commissions.management.dissapproval','Dissaprove', ['id_party' => $id, 'id_product' => $product_type->product_types_id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
              </td>
            @elseif($product_type->management_approval == 1)
              <td><p class="text-success font-weight-bold">Approved</p></td>
            @elseif($product_type->management_approval == 0)
              <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
            @endif

            <!-- Show Audit the Management Approval -->

            @if($product_type->audit_approval == 1)
              <td><p class="text-success font-weight-bold">Approved</p></td>
            @elseif($product_type->audit_approval == -1)
              <td><p class="text-info font-weight-bold">Decision Pending</p></td>
            @else
              <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
            @endif


          </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endsection
