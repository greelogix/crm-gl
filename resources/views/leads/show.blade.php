
    @extends('layouts.app')

    @section('content')
   
    <div class="container mt-5 px-5">
        <!-- Page Heading -->
        <div class="row mb-4">
            <div class="col-4 position-absolute">
                <a href="{{ route('leads.index') }}" class="btn btn-link">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="col-12 text-center">
                <h2 class="text-lead" style="font-size: 24px; font-weight: bold;">Lead Detail</h2>
            </div>
        </div>
    
        <!-- Lead Details Card -->
        <div class="card shadow-sm" style="border-radius: 8px;">
            <div class="card-body">
                <!-- Row 1: Client Name and Proposal Name -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="font-weight-bold" style="font-size: 14px;">Client Name</label>
                        <input type="text" class="form-control" style="font-size: 14px;" value="{{ $showlead->client_name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold" style="font-size: 14px;">Proposal Name</label>
                        <input type="text" class="form-control" style="font-size: 14px;" value="{{ $showlead->proposal_name }}" readonly>
                    </div>
                </div>
    
                <!-- Row 2: Connects Spent and Per Hour Rate -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="font-weight-bold" style="font-size: 14px;">Connects Spent</label>
                        <input type="text" class="form-control" style="font-size: 14px;" value="{{ $showlead->connects_spent }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold" style="font-size: 14px;">Per Hour Rate</label>
                        <input type="text" class="form-control" style="font-size: 14px;" value="{{ $showlead->rate_type }} ({{ $showlead->rate_value }})" readonly>
                    </div>
                </div>
    
                <!-- Row 3: Proposal Link and Proposal Date -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="font-weight-bold" style="font-size: 14px;">Proposal Link</label>
                        <input type="text" class="form-control" style="font-size: 14px;" value="{{ $showlead->proposal_link }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold" style="font-size: 14px;">Proposal Date</label>
                        <input type="text" class="form-control" style="font-size: 14px;" value="{{ $showlead->proposal_date }}" readonly>
                    </div>
                </div>
    
                <!-- Status Dropdown -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form action="{{route('negotiation.store')}}" method="POST" id="form-status">
                            @csrf
                            <div class="form-group col-md-6" id="negotiation_sub_options">
                                <input type="hidden" name="lead_id" value="{{$showlead->id}}">
                                <label for="negotiation_option" class="font-weight-bold" style="font-size: 14px;">Status</label>
                                <select class="form-control required @error('negotiation_status') is-invalid @enderror" id="negotiation_option" name="negotiation_status" style="width: 200%;">
                                    <option value="" style="font-size: 14px;">Select Option</option>
                                    <option value="WBS" style="font-size: 14px;" {{ ($showlead->negotiationstatus->negotiation_status ?? '') == 'WBS' ? 'selected' : '' }}>WBS</option>
                                    <option value="Call" style="font-size: 14px;" {{ ($showlead->negotiationstatus->negotiation_status ?? '') == 'Call' ? 'selected' : '' }}>Call</option>
                                    <option value="Discussion" style="font-size: 14px;" {{ ($showlead->negotiationstatus->negotiation_status ?? '') == 'Discussion' ? 'selected' : '' }}>Discussion</option>
                                </select>
                                @error('negotiation_option')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
    
                            @if(!empty($showlead->negotiationstatus->negotiation_status))
                                <div class="form-group col-md-6 mt-3" id="negotiation_sub_options_content">
                                    <label for="negotiation_sub_option" class="font-weight-bold" id="select-negotiation" style="font-size: 14px;">{{$showlead->negotiationstatus->negotiation_status ?? 'Negotiation Outcome'}}</label>
                                    <select class="form-control" id="negotiation_sub_option" name="negotiation_sub_status" style="width: 200%;">
                                        <option value="" style="font-size: 14px;">Select Outcome</option>
                                        <option value="Won" style="font-size: 14px;" {{ old('negotiation_sub_status', $showlead->negotiationstatus->negotiation_sub_status) == 'Won' ? 'selected' : '' }}>Won</option>
                                        <option value="Loss" style="font-size: 14px;" {{ old('negotiation_sub_status', $showlead->negotiationstatus->negotiation_sub_status) == 'Loss' ? 'selected' : '' }}>Loss</option>
                                    </select>
                                </div>
                            @endif
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h5 class="font-weight-bold text-lead" style="font-size: 16px;">Follow Up</h5>
                        @php $followUps = $showlead->negotiationstatus->followUps ?? [] @endphp
                        @if (count($followUps) > 0)
                            @foreach ($followUps as $index => $followUp)
                                <div class="mb-3">
                                    <label class="font-weight-bold" style="font-size: 14px;">Proposal Date</label>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="mb-0" style="font-size: 14px;">{{ $index + 1 }}. {{ $followUp->negotiation_status }}</p>
                                        @if ($followUp->status == 0 && \Carbon\Carbon::parse($followUp->created_at)->diffInHours(\Carbon\Carbon::now()) >= 48)
                                            <button class="btn btn-sm btn-outline-danger" style="font-size: 12px;width: 95px;">Incomplete</button>
                                        @elseif($followUp->status == 0)
                                            <button class="btn btn-sm btn-outline-primary mark-read-btn" style="font-size: 12px;" data-id="{{ $followUp->id }}">Mark as Read</button>
                                        @elseif($followUp->status == 1)
                                            <button class="btn btn-sm btn-outline-success" style="font-size: 12px; width: 95px;">Complete</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p style="font-size: 14px;">No Follow Up</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@push('scripts')
<script>
$(document).ready(function () {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#negotiation_option').on('change', function () {
            var selectedOption = $(this).val();
            var formAction = '{{ route("negotiation.store") }}';
            $('#form-status').attr('action', formAction); 
            var $selectNegotiationLabel = $('#select-negotiation');
            $selectNegotiationLabel.text(selectedOption);
            $('#form-status').submit();
        });

        $('#negotiation_sub_option').on('change', function () {
            var formAction = '{{ route("negotiation.updateSubStatus") }}';
            $('#form-status').attr('action', formAction); 
            $('#form-status').submit();
        });


    $('.mark-read-btn').on('click', function() {
        var followUpId = $(this).data('id');
        $.ajax({
            url: '/follow-up/' + followUpId + '/mark-read',
            type: 'PUT',
            success: function(response) {
                if (response.success) {
                    $('#follow-up-' + followUpId + ' p').html('Complete');
                    $('#follow-up-' + followUpId + ' .mark-read-btn').hide();
                    toastr.success('successfully');
                }
                location.reload();
            },
            error: function(xhr, status, error) {
                toastr.error('Please fill all required fields!', error);
            }
        });
    });

        @if(Session::has('success-message'))
            toastr.success("{{ Session::get('success-message') }}");
        @endif
});
</script>