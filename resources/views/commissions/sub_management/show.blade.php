@extends('layouts.dashboard')

@section('content')
  <div class="container">
  <h2>{{$party_name->type}}</h2>          
  <table class="table">
    <thead>
      <tr>
        <th>Product Types</th>
        <th>Commission %</th>
        @if($user->user_type == 'audit')
          <th>Status</th>
          <th>sub_management Approved</th>
        @endif
        @if($user->user_type == 'sub_management')
          <th>Status</th>
          <th>Audit Approved</th>
          <th>Edit</th>
          <th>Delete</th>
        @endif
      </tr>
    </thead>
    <tbody>
        @foreach($product_type_data as $product_type)
          <tr>
            <td>{{ $product_type->type }}</td>
            <td>{{ $product_type->commission_percentage }}</td>

            <!-- Audit Approaval -->
            @if($user->user_type == 'audit')
              @if($product_type->audit_approval == -1)
                <td>
                    {{ link_to_route('commissions.audit.approval','Approve', ['id_party' => $id, 'id_product' => $product_type->product_types_id], ['class' => 'btn btn-warning btn-sm btn-width']) }}

                    {{ link_to_route('commissions.audit.dissapproval','Dissaprove', ['id_party' => $id, 'id_product' => $product_type->product_types_id], ['class' => 'btn btn-secondary btn-sm btn-width']) }}
                </td>
                @elseif($product_type->audit_approval == 1)
                  <td><p class="text-success font-weight-bold">Approved</p></td>
                @elseif($product_type->audit_approval == 0)
                  <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
                @endif
              @else
              <!-- Do nothing -->
              @endif

              <!-- sub_management Approaval -->
            @if($user->user_type == 'sub_management')
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
              @else
              <!-- Do nothing -->
              @endif

            <!-- Show sub_management the Audit Approval -->
            @if($user->user_type == 'audit')
              @if($product_type->management_approval == 1)
                <td><p class="text-success font-weight-bold">Approved</p></td>
              @elseif($product_type->management_approval == -1)
                <td><p class="text-info font-weight-bold">Decision Pending</p></td>
              @else
                <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
              @endif
            @endif

            <!-- Show Audit the sub_management Approval -->
            @if($user->user_type == 'sub_management')
              @if($product_type->audit_approval == 1)
                <td><p class="text-success font-weight-bold">Approved</p></td>
              @elseif($product_type->audit_approval == -1)
                <td><p class="text-info font-weight-bold">Decision Pending</p></td>
              @else
                <td><p class="text-danger font-weight-bold">Dissapproved!</p></td>
              @endif
            @endif

            <!-- Edit/Delete -->
            @if($user->user_type == 'sub_management')
              <td>{{ link_to_route('commissions.edit.active', 'Edit', ['id_party' => $id, 'id_product' => $product_type->product_types_id], ['class'=>'btn btn-primary']) }}</td>               
              <td>
              {{ link_to_route('commissions.delete.active', 'Delete', ['id_party' => $id, 'id_product' => $product_type->product_types_id], ['class'=>'btn btn-danger']) }}
              </td>
            @endif

          </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endsection
