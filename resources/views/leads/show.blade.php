<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <title>Show Lead</title>
</head>
<body>
    {{-- @extends('layouts.app')

    @section('content') --}}
    <div class="container">
        <div class="row mt-5">
            <div>
                <a href="{{route('leads.index')}}">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="col mb-3">
                <h2 class="text-center text-primary">Leads Details</h2>
            </div>
        </div>
    
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="row mb-3 bg-light pt-3">
                    <div class="form-group col-md-3">
                        <label for="client_name" class="font-weight-bold" style="font-weight: bold;">Client Name</label>
                    </div>
                    <div class="form-group col-md-3">
                        <p id="client_name_details">{{$showlead->client_name}}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="proposal_name" class="font-weight-bold" style="font-weight: bold;">Proposal Name</label>
                    </div>
                    <div class="form-group col-md-3">
                        <p id="proposal_name_details">{{$showlead->proposal_name}}</p>
                    </div>
                </div>
    
                <div class="row mb-3 pt-3">
                    <div class="form-group col-md-3">
                        <label for="connects_spent" class="font-weight-bold" style="font-weight: bold;">Connects Spent</label>
                    </div>
                    <div class="form-group col-md-3">
                        <p id="connects_spent_details">{{$showlead->connects_spent}}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="rate_value" class="font-weight-bold" style="font-weight: bold;">Per Hour Rate</label>
                    </div>
                    <div class="form-group col-md-3">
                        <p id="rate_value">{{ $showlead->rate_type }} {{ '('. $showlead->rate_value .')'}}</p>
                    </div>
                </div>
    
                <div class="row mb-3 bg-light pt-3">
                    <div class="form-group col-md-3">
                        <label for="proposal_link" class="font-weight-bold" style="font-weight: bold;">Proposal Link</label>
                    </div>
                    <div class="form-group col-md-3">
                        <p id="proposal_link_details">{{$showlead->proposal_link}}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="proposal_date" class="font-weight-bold" style="font-weight: bold;">Proposal Date</label>
                    </div>
                    <div class="form-group col-md-3">
                        <p id="proposal_date_details">{{$showlead->proposal_date}}</p>
                    </div>
                </div>
    
                <div class="row mt-3">
                    <div class="col-6">
                        <form action="{{route('negotiation.store')}}" method="POST" id="form-status">
                            @csrf
                            <div class="form-group col-md-6" id="negotiation_sub_options">
                                <input type="hidden" name="lead_id" value="{{$showlead->id}}">
                                <label for="negotiation_option" class="font-weight-bold">Status</label>
                                <select class="form-control required @error('negotiation_status') is-invalid @enderror" id="negotiation_option" name="negotiation_status">
                                    <option value="">Select Option</option>
                                    <option value="WBS" {{ ($showlead->negotiationstatus->negotiation_status ?? '') == 'WBS' ? 'selected' : '' }}>WBS</option>
                                    <option value="Call" {{ ($showlead->negotiationstatus->negotiation_status ?? '') == 'Call' ? 'selected' : '' }}>Call</option>
                                    <option value="Discussion" {{ ($showlead->negotiationstatus->negotiation_status ?? '') == 'Discussion' ? 'selected' : '' }}>Discussion</option>
                                </select>
                                @error('negotiation_option')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
    
                            @if(!empty($showlead->negotiationstatus->negotiation_status))
                                <div class="form-group col-md-6 mt-3" id="negotiation_sub_options_content">
                                    <label for="negotiation_sub_option" class="font-weight-bold" id="select-negotiation">{{$showlead->negotiationstatus->negotiation_status ?? 'Negotiation Outcome'}}</label>
                                    <select class="form-control" id="negotiation_sub_option" name="negotiation_sub_status">
                                        <option value="">Select Outcome</option>
                                        <option value="Won" {{ old('negotiation_sub_status', $showlead->negotiationstatus->negotiation_sub_status) == 'Won' ? 'selected' : '' }}>Won</option>
                                        <option value="Loss" {{ old('negotiation_sub_status', $showlead->negotiationstatus->negotiation_sub_status) == 'Loss' ? 'selected' : '' }}>Loss</option>
                                    </select>
                                </div>
                            @endif
                        </form>
                    </div>
    
                    <div class="col-6 mt-3">
                        <h5 class="font-weight-bold text-primary">Follow Up</h5>
                        @php $followUps = $showlead->negotiationstatus->followUps ?? [] @endphp
                        @if (count($followUps) > 0)
                            @foreach ($followUps as $index => $followUp)
                                <div id="follow-up-{{ $followUp->id }}">
                                    <p class="d-flex justify-content-between">
                                        {{ $index + 1 }}  {{ $followUp->negotiation_status }} Follow Up
                                        @if ($followUp->status == 0 && Carbon::parse($followUp->created_at)->diffInHours(now()) >= 48)
                                            <button class="btn btn-sm btn-outline-danger">
                                                Incomplete
                                            </button>
                                        @elseif($followUp->status == 0) 
                                            <button class="btn btn-sm btn-outline-primary mark-read-btn" 
                                            data-id="{{ $followUp->id }}">
                                                Mark as Read
                                            </button> 
                                            @elseif($followUp->status == 1) 
                                            <button class="btn btn-sm btn-outline-success" 
                                            data-id="{{ $followUp->id }}">
                                                Complete
                                            </button>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <p>No Follow Up</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- @endsection --}}
<script>
 $(document).ready(function () {
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right", 
        "timeOut": "5000",
    }

    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

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
            location.reload();
        });

        $('#negotiation_sub_option').on('change', function () {
            var formAction = '{{ route("negotiation.updateSubStatus") }}';
            $('#form-status').attr('action', formAction); 
            $('#form-status').submit();
            location.reload();
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
                }
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error updating status:", error);
            }
        });
    });
});
</script>
{{-- </body>
</html> --}}