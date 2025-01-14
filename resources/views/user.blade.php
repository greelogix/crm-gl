@if(Auth::user()->role == 'admin')
@extends('layouts.app')

@section('content')
<div class=" mb-3 d-flex justify-content-between position-relative" style="top: 35px;">
    <div class="">
        <h5 class="" style="font-size: large;">User List</h5>
    </div>
    <div class="d-none">
        <button class="btn btn-purple add-cuctomer create-lead"  data-bs-toggle="modal" data-bs-target="#LeadModal" style="font-size: small;">Create Customer</button>
    </div>
</div>
<div class="filters-container mb-3 d-flex gap-3 justify-content-end position-relative" style="top: 35px;"> 
  <input type="search" id="custom-search" class="form-control w-auto" placeholder="Search">
</div>
<table id="customerTable" class="table table-bordered align-middle" style="width:100%">
    <thead class="table-light">
        <tr style="font-size: small;">
            <th >#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index=>$user)
        <tr style="font-size: small; " class="row-proposal cursor-pointer">
            <td>{{ $index+1}}</td>
            <td><img src="{{ $user->image ? Storage::url($user->image) : asset('logo/default-profile.jpg') }}" 
                class="rounded-circle border" style="width: 40px;" 
                alt="Profile Image"></td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{!! $user ? '<span class="status-pill">Active</span>' : '<span class="status-pend">Inactive</span>' !!}</td>
            <td class="action-icons">
                <a href="" data-bs-toggle="tooltip" title="Delete">
                    <i class="fa-regular fa-trash-can" style="font-size: medium;"></i>
                </a>

                <a href="" class="cursor-pointer ms-1 edit-lead" data-bs-toggle="tooltip" title="Edit">
                    <i class="fa fa-pencil" style="font-size: medium;"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
@push('scripts')
<script>
$(document).ready(function() {

    var table = $('#customerTable').DataTable({
        paging: true,
        searching: true,
        lengthChange: true,
        ordering: true
    });

    $('#custom-search').on('keyup', function () {
        table.search(this.value).draw();
    });
});

</script>
@endpush
@endif


