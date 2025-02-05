
@extends('layouts.app')

@section('content')
<div class="mb-5 pb-3 d-flex justify-content-between position-relative" style="top: 35px;">
    <div class="">
        <h5 class="" style="font-size: large;">Available Connects : {{$remainingConnects)}}</h5>
    </div>
    <div>
        <button class="btn btn-purple add-cuctomer create-connect shadow-none"  data-bs-toggle="modal" data-bs-target="#ConnectModal" style="font-size: small;">Add Connects</button>
    </div>
</div>
{{-- <div class="filters-container mb-3 d-flex gap-3 justify-content-end position-relative" style="top: 35px;">
        <input type="search" id="custom-search" class="form-control w-auto shadow-none" placeholder="Search">
</div> --}}

<table id="customerTable" class="table align-middle w-100 mt-5">
    <thead class="table-active">
        <tr style="font-size: small; background-color: #f8f9fa;">
            <th></th>
            <th>Sr.</th>
            <th>Name</th>
            <th>Weak Date</th>
            <th>Total Price</th>
            <th>Total Connects</th>
            <th>Total Use Connects</th>
            <th>Remaining Connects</th>
            <th>Action</th>
        </tr>
    </thead>
   
    <div class="toggle-row">
        <tbody class="" id="accordionExample">
            @php $weekNumber = 1; @endphp
            @foreach ($groupedByWeekConnects as $week => $connects)
            <tr style="font-size: small;" class="row-proposal toggle-row table-active" data-toggle="collapseweek-{{ Str::slug($week) }}">
                <td class="up-arrow"><i class="fa-sharp fa-solid fa-angle-down"></i></td>
                <td>{{ $weekNumber++ }}</td>
                <td>{{ Auth::user()->name }}</td>
                <td>{{ $week }}</td>
                <td>${{ $connects->sum('price') }}</td>
                {{-- <td>{{ $connects->sum('connects_buy') }}</td>
                <td>
                    @php
                        $weekLeads = $groupedByWeekLeads[$week] ?? collect();
                    @endphp
                    {{ $weekLeads->filter(fn($lead) => is_numeric($lead['connects_spent']))->sum('connects_spent') }}
                </td> --}}
                <td>{{ $weeklyData[$week]['total_buy'] }}</td>
                <td>{{ $weeklyData[$week]['total_spent'] }}</td>
                <td>{{ $weeklyData[$week]['carry_forward'] }}</td>
                <td class="action-icons">
                    <button class="btn add-more-btn create-connect" data-bs-toggle="modal" data-bs-target="#ConnectModal">
                        Add More
                    </button>
                </td>
                <tbody id="collapseweek-{{ Str::slug($week) }}" class="collapse">
                    <tr style="font-size: small; background-color: #f8f9fa;">
                        <th></th>
                        <th>Sr.</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Connects</th>
                        {{-- <th>Connects Use</th> --}}
                        <th>Action</th>
                    </tr>
                    {{-- @foreach ($connects->groupBy('date') as $date => $dailyConnects)
                    @php
                        $dailyConnectsByUser = $dailyConnects->groupBy('user_id');
                    @endphp
                
                    @foreach ($dailyConnectsByUser as $userId => $userConnects)
                        <tr style="font-size: small;" class="row-proposal">
                            <td></td>
                            <td>{{ $loop->parent->iteration }}</td>
                            <td>{{ $userConnects->first()->user->name ?? 'N/A' }}</td>
                            <td>{{ $date }}</td>
                            <td>${{ $userConnects->sum('price') }}</td>
                            <td>{{ $userConnects->sum('connects_buy') }}</td>
                            <td>
                                @php
                                    $dailyLeads = $weekLeads->where('created_at', '>=', \Carbon\Carbon::parse($date)->startOfDay())
                                                            ->where('created_at', '<=', \Carbon\Carbon::parse($date)->endOfDay())
                                                            ->where('user_id', $userId);
                
                                    $dailyLeadsFiltered = $dailyLeads->filter(fn($lead) => is_numeric($lead['connects_spent']));
                                @endphp
                                {{ $dailyLeadsFiltered->sum('connects_spent') }}
                            </td>

                            <td class="action-icons">
                                <a href="" data-bs-toggle="tooltip" title="Delete Connect">
                                    <i class="fa-regular fa-trash-can" style="font-size: medium;"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach --}}
                    @foreach ($connects as $connect)
                    <tr style="font-size: small; background-color: #f8f9fa;">
                        <td></td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $connect->user->name ?? 'N/A' }}</td>
                        <td>{{ $connect->date }}</td>
                        <td>${{ $connect->price }}</td>
                        <td>{{ $connect->connects_buy }}</td>
                        {{-- <td>
                            @php
                                $dailyLeads = $groupedByWeekLeads[$week] ?? collect();
                                $dailyLeadsFiltered = $dailyLeads
                                    ->where('created_at', '>=', \Carbon\Carbon::parse($connect->date)->startOfDay())
                                    ->where('created_at', '<=', \Carbon\Carbon::parse($connect->date)->endOfDay())
                                    ->where('user_id', $connect->user_id)
                                    ->filter(fn($lead) => is_numeric($lead['connects_spent']));
                            @endphp
                            {{ $dailyLeadsFiltered->sum('connects_spent') }}
                        </td> --}}
                        <td class="action-icons">
                            <a href="{{ route('connect.destroy', $connect->id) }}" data-bs-toggle="tooltip" title="Delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $connect->id }}').submit();">
                                <i class="fa-regular fa-trash-can" style="font-size: medium;"></i>
                            </a>
            
                            <a href="{{ route('connect.edit', $connect->id) }}" class="cursor-pointer ms-1 edit-connect" data-bs-toggle="modal" data-bs-target="#ConnectModal" data-id="{{ $connect->id }}" data-bs-toggle="tooltip" title="Edit">
                                <i class="fa fa-pencil" style="font-size: small;"></i>
                            </a>
            
                            <form id="delete-form-{{ $connect->id }}" action="{{ route('connect.destroy', $connect->id) }}" method="POST" style="display: none;">
                                @csrf
                               @method('DELETE') 
                            </form>
                        </td>
                        
                    </tr>
                @endforeach
                </tbody>
            </tr>
            @endforeach
        </tbody>
    </div>
</table>


 <!-- Modal -->
 <div class="modal fade" id="ConnectModal" tabindex="-1" aria-labelledby="ConnectModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="ConnectModalLabel" style="font-size: medium; color: #7f56d">Add New Connect</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <form id="connectform" action="{{ route('connect.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" style="font-size: small;">Name</label>
                                <input type="text" class="form-control shadow-none required @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date" style="font-size: small;">Date</label>
                                <input type="date" class="form-control shadow-none required @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                @error('proposal_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <label for="price" style="font-size: small;">Price</label>
                                <input type="text" class="form-control shadow-none required @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="connects_buy" style="font-size: small;">Connects</label>
                                <input type="text" class="form-control shadow-none required @error('connects_buy') is-invalid @enderror" id="connects_buy" name="connects_buy" value="{{ old('connects_buy') }}">
                                @error('connects_buy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" id="btn-submit" class="btn btn-purple btn-block shadow-none" style="font-size: small;">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
 $(document).ready(function() {
        var table = $('#customerTable').DataTable({
            paging: true,
            searching: true,
            lengthChange: true,
            ordering: true,
        });
       

 $('#customerTable_length select').removeClass('form-select form-select-sm');

    $('body').on('submit', '#connectform', function (e) {
        e.preventDefault();

        let isValid = true;

        $('.required').each(function () {
            if ($(this).val().trim() === "") {
                $(this).css('border', '1px solid red');
                isValid = false;
            } else {
                $(this).css('border', '');
            }
        });

        if (!isValid) {
            toastr.error('Please fill all required fields!');
            return;
        }
        this.submit();
    });

    $('body').on('click', '.create-connect', function(){
        $('#ConnectModalLabel').text('Add New Connect'); 
        $('#btn-submit').text('Submit');
        $('.rate-input').hide();
        $('#connectform')[0].reset();
    });


    $('body').on('click', '.edit-connect', function(){
        var connectId = $(this).data('id');
        $.ajax({
            url: '/connect/' + connectId + '/edit',
            type: 'GET',
            success: function(response) {
                $('#connectform')[0].reset();
                $('#name').val(response.connect.name);
                $('#date').val(response.connect.date);
                $('#price').val(response.connect.price);
                $('#connects_buy').val(response.connect.connects_buy);
                $('#connectform').attr('action', '/connect/' + connectId); 
                $('#connectform').append('<input type="hidden" name="_method" value="PUT">'); 
                $('#ConnectModalLabel').text('Update Connect'); 
                $('#btn-submit').text('Submit');
                $('#ConnectModal').modal('show');
            },
            error: function(xhr, status, error) {
                toastr.error('Error fetching lead data:', error);
            }
        });
    });

    $('body').on('input', '.required', function () {
        $(this).css('border', '');
        $(this).removeClass('is-invalid');
    });

    $('#LeadModal').on('hidden.bs.modal', function () {
            $('#connectform')[0].reset();
            $('.required').css('border', '');
            $('.required').removeClass('is-invalid');

   });

   $('.toggle-row').on('click', function (e) {
    e.preventDefault();
    const $this = $(this);
    const collapseEle = $(`#${$this.data('toggle')}`);
    const icon = $this.find('i');
    collapseEle.toggle();
    icon.toggleClass('fa-angle-down fa-angle-up');
  });

});

</script>
@endpush
