@extends('layouts.app')

@section('content')
<div class="mb-2 mt-5 mt-sm-3 mb-sm-4  d-flex justify-content-between position-relative">
    <div class="">
        <h5 class="" style="font-size: large;">Customer List</h5>
    </div>
    <div>
        <button class="btn btn-purple add-cuctomer create-lead shadow-none"  data-bs-toggle="modal" data-bs-target="#LeadModal" style="font-size: small;">Add Propsoal</button>
    </div>
</div>
<div class="container d-flex justify-content-end perposal-main gap-2 p-2 bg-light position-relative" style="top: 20px;">
    <form method="GET" action="{{ route('leads.index') }}" id="filterForm" class="d-flex gap-2">
        @csrf
        <span style="position: absolute;bottom: 35px;font-size: smaller;">Start date</span> <input 
        type="date" 
        name="start_date" id="start_date"
        value="{{ request('start_date') }}" 
        class="form-control form-control-sm shadow-none" 
        onchange="document.getElementById('filterForm').submit();">
        <span style="    position: absolute;right: 428px;bottom: 35px;font-size: smaller;">End date</span> <input 
            type="date" 
            name="end_date" id="end_date"
            value="{{ request('end_date') }}" 
            class="form-control form-control-sm shadow-none" 
            onchange="document.getElementById('filterForm').submit();">    
        <select 
            name="status_lead" 
            class="form-select form-select-sm shadow-none" 
            onchange="document.getElementById('filterForm').submit();">
            <option value="">Select</option>
            <option value="0">All</option>
            <option value="1" {{ request('status_lead') == '1' ? 'selected' : '' }}>Leads</option>
        </select>
    </form>
    <input 
        type="search" 
        id="custom-search" 
        class="form-control form-control-sm" 
        placeholder="Search" style="width: 200px">
    <!-- Filter Button -->
    <button class="btn btn-sm btn-outline-primary shadow-none">
        <i class="bi bi-funnel"></i>
    </button>
</div>

<table id="customerTable" class="table table-bordered align-middle" style="width:100%">
    <thead class="table-light">
        <tr style="font-size: small;">
            {{-- <th><input type="checkbox" id="select-all"></th> --}}
            <th >#</th>
            <th>Client Name</th>
            <th>Tech Stack</th>
            <th>Connects Spent</th>
            <th>Status</th>
            <th>Proposal Name</th>
            <th>Country</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leads as $index=>$lead)
        <tr style="font-size: small; " class="row-proposal cursor-pointer {{$lead->status==1 ? 'table-secondary' : ''}}" data-lead-id="{{ $lead->id }}" data-bs-toggle="tooltip" title="Click hire to Create Lead">
            {{-- <td> --}}
                {{-- <input type="checkbox" class="select-checkbox" data-lead-id="{{ $lead->id }}" data-bs-toggle="tooltip" title="Check Create Lead"> --}}
                <a href="{{ route('leads.show', $lead->id) }}" class="checked-link-{{ $lead->id }}" style="display:none;"></a>
            {{-- </td> --}}
            <td>{{ $index+1}}</td>
            <td>{{$lead->client_name}}</td>
            <td>{{ $lead->tech_stack }}</td>
            <td>{{ $lead->connects_spent }}</td>
            <td>{{ $lead->negotiationstatus->negotiation_status ?? 'N\A' }}</td>
            <td>{{ $lead->proposal_name }}</td>
            <td>{{ $lead->country }}</td>
            <td class="action-icons">
                <a href="{{ route('leads.destroy', $lead->id) }}" data-bs-toggle="tooltip" title="Delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $lead->id }}').submit();">
                    <i class="fa-regular fa-trash-can" style="font-size: medium;"></i>
                </a>

                <a href="{{ route('leads.edit', $lead->id) }}" class="cursor-pointer ms-1 edit-lead" data-bs-toggle="modal" data-bs-target="#LeadModal" data-id="{{ $lead->id }}" data-bs-toggle="tooltip" title="Edit">
                    <i class="fa fa-pencil" style="font-size: small;"></i>
                </a>

                <form id="delete-form-{{ $lead->id }}" action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display: none;">
                    @csrf
                   @method('DELETE') 
                </form>

                <a href="{{ route('leads.show', $lead->id) }}" class="cursor-pointer ms-1 generate-lead" data-bs-toggle="tooltip" title="Generate Lead">
                    @if ($lead->status == 0)
                        <i class="fa fa-plus-circle" style="font-size: small;"></i>
                    @else
                        <i class="fa-solid fa-eye" style="font-size: small;"></i>
                    @endif
                </a>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

 <!-- Modal -->
 <div class="modal fade" id="LeadModal" tabindex="-1" aria-labelledby="LeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="LeadModalLabel" style="font-size: medium; color: #7f56d">Create Proposal</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="leadForm" action="{{ route('leads.store') }}" method="POST"> 
                @csrf
                <input type="hidden" name="user_id" value="{{Auth::id()}}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="client_name" style="font-size: small;">Client Name</label>
                        <input type="text" class="form-control required shadow-none @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name') }}">
                        @error('client_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tech_stack" style="font-size: small;">Tech Stack</label>
                        <input type="text" class="form-control required shadow-none @error('tech_stack') is-invalid @enderror" id="tech_stack" name="tech_stack" value="{{ old('tech_stack') }}">
                        @error('tech_stack')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="connects_spent" style="font-size: small;">Connects Spent</label>
                        <input type="text" class="form-control required shadow-none @error('connects_spent') is-invalid @enderror" id="connects_spent" name="connects_spent" value="{{ old('connects_spent') }}">
                        @error('connects_spent')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="rate_type" style="font-size: small;">Per Hour Rate</label>
                        <select class="form-control required shadow-none @error('rate_type') is-invalid @enderror" id="rate_type" name="rate_type">
                            <option value="">Select Rate</option>
                            <option value="Fixed">Fixed</option>
                            <option value="hourly">hourly</option>
                        </select>
                        @error('rate_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="form-group col-md-6 rate-input" id="rate_input_field" style="display: none;">
                            <label for="rate_value" style="font-size: small;">Enter Rate</label>
                            <input type="number" class="form-control required shadow-none @error('rate_value') is-invalid @enderror" id="rate_value" name="rate_value" value="{{ old('rate_value') }}">
                            @error('rate_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="proposal_name" style="font-size: small;">Proposal Name</label>
                        <input type="text" class="form-control required shadow-none @error('proposal_name') is-invalid @enderror" id="proposal_name" name="proposal_name" value="{{ old('proposal_name') }}">
                        @error('proposal_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="proposal_link" style="font-size: small;">Proposal Link</label>
                        <input type="url" class="form-control required shadow-none @error('proposal_link') is-invalid @enderror" id="proposal_link" name="proposal_link" value="{{ old('proposal_link') }}">
                        @error('proposal_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="country" style="font-size: small;">Country</label>
                        <input type="text" class="form-control required shadow-none @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}">
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="proposal_date" style="font-size: small;">Proposal Date</label>
                        <input type="date" class="form-control required shadow-none @error('proposal_date') is-invalid @enderror" id="proposal_date" name="proposal_date" value="{{ old('proposal_date') }}">
                        @error('proposal_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" id="btn-submit" class="btn btn-purple btn-block shadow-none" style="font-size: small;">Create Propsoal</button>
                </div>
            </form>
            
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
        ordering: true
    });

    $('#custom-search').on('keyup', function () {
        table.search(this.value).draw();
    });

    $('#customerTable_length select').removeClass('form-select form-select-sm');

    $('body').on('submit', '#leadForm', function (e) {
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

    $('#rate_type').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'Fixed' || selectedValue === 'hourly') {
                $('#rate_input_field').show();
            } else {
                $('#rate_input_field').hide();
            }
    });

    // $('.row-proposal').click(function() {
    //     var leadId = $(this).data('lead-id');
    //     var $link = $('.checked-link-' + leadId);
    //     $link.attr('href', '/leads/' + leadId);
    //     $link[0].click();
    //     // if ($(this).prop('checked')) {
    //     //     $link.attr('href', '/leads/' + leadId);
    //     // $link[0].click();
    //     // } else {
    //     //     console.log('Checkbox is unchecked');
    //     // }
    // });

    $('body').on('click', '.create-lead', function(){
        $('#LeadModalLabel').text('Create Proposal'); 
        $('#btn-submit').text('Submit');
        $('.rate-input').hide();
        $('#leadForm')[0].reset();
    });

    $('body').on('input', '.required', function () {
        $(this).css('border', '');
        $(this).removeClass('is-invalid');
    });

    $('body').on('click', '.edit-lead', function(){
        var leadId = $(this).data('id');
        $('.rate-input').show();
        $.ajax({
            url: '/leads/' + leadId + '/edit',
            type: 'GET',
            success: function(response) {
                $('#leadForm')[0].reset();
                $('#client_name').val(response.lead.client_name);
                $('#tech_stack').val(response.lead.tech_stack);
                $('#proposal_name').val(response.lead.proposal_name);
                $('#country').val(response.lead.country);
                $('#connects_spent').val(response.lead.connects_spent);
                $('#rate_value').val(response.lead.rate_value);
                $('#rate_type').val(response.lead.rate_type);
                $('#proposal_link').val(response.lead.proposal_link);
                $('#proposal_date').val(response.lead.proposal_date);
                $('#leadForm').attr('action', '/leads/' + leadId); 
                $('#leadForm').append('<input type="hidden" name="_method" value="PUT">'); 
                $('#LeadModalLabel').text('Update Proposal'); 
                $('#btn-submit').text('Submit');
                $('#leadModal').modal('show');
            },
            error: function(xhr, status, error) {
                toastr.error('Error fetching lead data:', error);
            }
        });
    });

    $('#LeadModal').on('hidden.bs.modal', function () {
            $('#leadForm')[0].reset();
            $('.required').css('border', '');
            $('.required').removeClass('is-invalid');
    });

   $('select[name="status_lead"]').change(function() {
            var statusLead = $(this).val();
            var startDate = $('#start_date');
            var endDate = $('#end_date');
            if (statusLead == '0') {
                startDate.val('');
                endDate.val('');
            }
            $('#filterForm').submit();
        });
});
</script>
@endpush


