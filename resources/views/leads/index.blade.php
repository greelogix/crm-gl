<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Lead</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
</head>
<body>  
    {{-- @extends('layouts.app')

@section('content') --}}
    <div class="container mt-5">
        <div class="text-end">
           <a href="{{route('logout')}}" class="btn btn-danger">Logout</a>
        </div>
        <h2>Leads Customers</h2>
        <div class="row">
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary create-lead"  data-bs-toggle="modal" data-bs-target="#LeadModal">Create Customer</button>
            </div>
            <div class="col">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col"><input type="checkbox" id="select-all"></th>
                        <th scope="col">#</th>
                        <th>Client Name</th>
                        <th>Tech Stack</th>
                        <th>Connects Spent</th>
                        <th>Rate Type</th>
                        <th>Rate Value</th>
                        <th>Proposal Link</th>
                        <th>Proposal Name</th>
                        <th>Country</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $index=>$lead)
                        <tr>
                            <th>
                                <input type="checkbox" class="select-checkbox select-{{ $lead->id }}" data-lead-id="{{ $lead->id }}" data-bs-toggle="tooltip" title="Check Create Lead">
                                <a href="{{ route('leads.show', $lead->id) }}" class="checked-link-{{ $lead->id }}" style="display:none;"></a>
                            </th>
                            <td>{{ $index+1}}</td>
                            <td>{{$lead->client_name}}</td>
                            <td>{{ $lead->tech_stack }}</td>
                            <td>{{ $lead->connects_spent }}</td>
                            <td>{{ $lead->rate_type }}</td>
                            <td>{{ $lead->rate_value }}</td>
                            <td>{{ $lead->proposal_link }}</td>
                            <td>{{ $lead->proposal_name }}</td>
                            <td>{{ $lead->country }}</td>
                            <td>
                                {{-- <a href="{{ route('leads.show', $lead->id) }}" class="cursor-pointer view-lead"  data-bs-toggle="modal" data-bs-target="#LeadDetailsModal" data-id="{{ $lead->id }}" data-bs-toggle="tooltip" title="details"><i class="fa-solid fa-eye" style="color: #3bb73b;"></i></a> --}}

                                <a href="{{ route('leads.edit', $lead->id) }}" class="cursor-pointer ms-1 edit-lead" data-bs-toggle="modal" data-bs-target="#LeadModal" data-id="{{ $lead->id }}" data-bs-toggle="tooltip" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <a href="{{ route('leads.destroy', $lead->id) }}" class="ms-1" data-bs-toggle="tooltip" title="Delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $lead->id }}').submit();">
                                    <i class="fa-sharp fa-solid fa-trash cursor-pointer" style="color: #db1515;"></i> 
                                </a>

                                <form id="delete-form-{{ $lead->id }}" action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE') 
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{-- <div class="text-end">
                    {{ $leads->links() }}
                </div> --}}
            </div>
             <!-- Modal -->
            <div class="modal fade" id="LeadModal" tabindex="-1" aria-labelledby="LeadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="LeadModalLabel">Create Lead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="leadForm" action="{{ route('leads.store') }}" method="POST"> 
                            @csrf
                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="client_name">Client Name</label>
                                    <input type="text" class="form-control required @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name') }}">
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tech_stack">Tech Stack</label>
                                    <input type="text" class="form-control required @error('tech_stack') is-invalid @enderror" id="tech_stack" name="tech_stack" value="{{ old('tech_stack') }}">
                                    @error('tech_stack')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="connects_spent">Connects Spent</label>
                                    <input type="text" class="form-control required @error('connects_spent') is-invalid @enderror" id="connects_spent" name="connects_spent" value="{{ old('connects_spent') }}">
                                    @error('connects_spent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="rate_type">Per Hour Rate</label>
                                    <select class="form-control required @error('rate_type') is-invalid @enderror" id="rate_type" name="rate_type">
                                        <option value="">Select Rate</option>
                                        <option value="Fixed">Fixed</option>
                                        <option value="hourly">hourly</option>
                                    </select>
                                    @error('rate_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group col-md-6 rate-input" id="rate_input_field" style="display: none;">
                                        <label for="rate_value">Enter Rate</label>
                                        <input type="number" class="form-control required @error('rate_value') is-invalid @enderror" id="rate_value" name="rate_value" value="{{ old('rate_value') }}">
                                        @error('rate_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="proposal_name">Proposal Name</label>
                                    <input type="text" class="form-control required @error('proposal_name') is-invalid @enderror" id="proposal_name" name="proposal_name" value="{{ old('proposal_name') }}">
                                    @error('proposal_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="proposal_link">Proposal Link</label>
                                    <input type="url" class="form-control required @error('proposal_link') is-invalid @enderror" id="proposal_link" name="proposal_link" value="{{ old('proposal_link') }}">
                                    @error('proposal_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control required @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="proposal_date">Proposal Date</label>
                                    <input type="date" class="form-control required @error('proposal_date') is-invalid @enderror" id="proposal_date" name="proposal_date" value="{{ old('proposal_date') }}">
                                    @error('proposal_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" id="btn-submit" class="btn btn-primary btn-block">Create Lead</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
                </div>
            </div>

            {{-- Details --}}
            {{-- <div class="modal fade" id="LeadDetailsModal" tabindex="-1" aria-labelledby="LeadDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="LeadDetailsModalLabel">Details Lead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="d-none" id="leadId"></p>
                        <div class="row mb-3 bg-light text-center pt-3">
                            <div class="form-group col-md-3">
                                <label for="client_name"><strong>Client Name</strong></label>
                            </div>
                            <div class="form-group col-md-3">
                                <p id="client_name_details"></p>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tech_stack"><strong>Tech Stack</strong></label>
                            </div>
                            <div class="form-group col-md-3">
                                <p id="tech_stack_details"></p>
                            </div>
                        </div>
                        
                        <div class="row mb-3 text-center pt-3">
                            <div class="form-group col-md-3">
                                <label for="connects_spent"><strong>Connects Spent</strong></label>
                            </div>
                            <div class="form-group col-md-3">
                                <p id="connects_spent_details"></p>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="rate_value"><strong>Per Hour Rate</strong></label>
                            </div>
                            <div class="form-group col-md-3">
                                <p id="rate_value"></p>
                            </div>
                        </div>
                        
                        <div class="row mb-3 bg-light text-center pt-3">
                            <div class="form-group col-md-3">
                                <label for="proposal_link"><strong>Proposal Link</strong></label>
                            </div>
                            <div class="form-group col-md-3">
                                <p id="proposal_link_details"></p>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="proposal_date"><strong>Proposal Date</strong></label>
                            </div>
                            <div class="form-group col-md-3">
                                <p id="proposal_date_details"></p>
                            </div>
                        </div>
                        
                        <div class="row mb-3 text-center pt-3">
                            <div class="form-group col-md-3">
                                <label for="proposal_name"><strong>Proposal Name</strong></label>
                            </div>
                            <div class="form-group col-md-3">
                                <p id="proposal_name_details"></p>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="country"><strong>Country</strong></label>
                            </div>
                            <div class="form-group col-md-3">
                                <p id="country_details"></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Negotiation
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li class="dropdown-submenu">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            WBS
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <li><a class="dropdown-item" href="">Won</a></li>
                                            <li><a class="dropdown-item" href="">Loss</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            Call
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <li><a class="dropdown-item" href="">Won</a></li>
                                            <li><a class="dropdown-item" href="">Loss</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-expanded="false">
                                            Decision
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                            <li><a class="dropdown-item" href="">Won</a></li>
                                            <li><a class="dropdown-item" href="">Loss</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>                            
                        </div>
                                                
                    </div>
                </div>
                </div>
            </div> --}}

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js_details"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> 
{{-- @endsection --}}
<script>
 $(document).ready(function () {
   
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
    
//     $('.select-checkbox').change(function() {
//         if ($(this).prop('checked')) {
//             // var leadId = $(this).data('lead-id');
//             // console.log($('.view-lead[data-id="' + leadId + '"]').click());
//             // $('#LeadDetailsModal').modal('show'); 
//             $('.checked-link').click();
//         } else {
//             console.log('undefined');
//         }
//    });

       $('#rate_type').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'Fixed' || selectedValue === 'hourly') {
                $('#rate_input_field').show();
            } else {
                $('#rate_input_field').hide();
            }
        });

        $('.select-checkbox').change(function() {
            var leadId = $(this).data('lead-id');
            var $link = $('.checked-link-' + leadId);

            if ($(this).prop('checked')) {
                $link.attr('href', '/leads/' + leadId);
                $link[0].click();
                // window.location.href = '/leads/' + leadId;
            } else {
                console.log('Checkbox is unchecked');
            }
        });

    $('body').on('click', '.create-lead', function(){
        $('#LeadModalLabel').text('Create Lead'); 
        $('#btn-submit').text('Create Lead');
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
                $('#LeadModalLabel').text('Update Lead'); 
                $('#btn-submit').text('Update Lead');
                $('#leadModal').modal('show'); 
            },
            error: function(xhr, status, error) {
                toastr.error('Error fetching lead data:', error);
            }
        });
    });

    // $('body').on('click', '.view-lead', function(){
    //     var leadId = $(this).data('id');
    //     $('.select-' + leadId).prop('checked', true); 
    //     $.ajax({
    //         url: '/leads/' + leadId + '/edit',
    //         type: 'GET',
    //         success: function(response) {
    //             $('#leadId').text(response.lead.id);
    //             $('#client_name_details').text(response.lead.client_name);
    //             $('#tech_stack_details').text(response.lead.tech_stack);
    //             $('#connects_spent_details').text(response.lead.connects_spent);
    //             $('#rate_value_details').text(response.lead.rate_value);
    //             $('#proposal_name_details').text(response.lead.proposal_name);
    //             $('#proposal_link_details').text(response.lead.proposal_link);
    //             $('#country_details').text(response.lead.country);
    //             // $('#created_at_details').text(response.lead.created_at);
    //             $('#proposal_date_details').text(response.lead.proposal_date);
    //             $('#leadModal').modal('show'); 
    //         },
    //         error: function(xhr, status, error) {
    //             console.log('Error fetching lead data:', error);
    //         }
    //     });
    // });  
    
    $('#LeadModal').on('hidden.bs.modal', function () {
            $('#leadForm')[0].reset();
            $('.required').css('border', '');
            $('.required').removeClass('is-invalid');
           
   });

//    $('#LeadDetailsModal').on('hidden.bs.modal', function () {
//         var leadId = $('#leadId').text();
//         $('.select-' + leadId).prop('checked', false); 
//     });

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

});    
</script>
</body>
</html>


