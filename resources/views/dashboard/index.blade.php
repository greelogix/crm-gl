@extends('layouts.app')

@section('content')
<div class="d-flex mx-auto justify-content-between mt-5">
@if(Auth::user()->role == 'admin')
   <div class="card flex-fill me-3" style="height: 115px;">
       <div class="card-body d-flex justify-content-between align-items-center">
           <span class="text-muted fw-medium">
               <i class="fas fa-users me-2"></i> Total User:
           </span>
           <span class="fw-bold text-dark">{{$usercount}}</span>
       </div>
   </div>
 @endif
   <div class="card flex-fill me-3" style="height: 115px;">
       <div class="card-body d-flex justify-content-between align-items-center">
           <span class="text-muted fw-medium">
            <i class="fas fa-exclamation-circle text-success me-2"></i>  Total Proposal:
           </span>
           <span class="fw-bold ">{{$perposelcount}}</span>
       </div>
   </div>

   <div class="card flex-fill" style="height: 115px;">
       <div class="card-body d-flex justify-content-between align-items-center">
           <span class="text-muted fw-medium">
               <i class="fas fa-check-circle text-success me-2"></i> Total Leads:
           </span>
           <span class="fw-bold text-success">{{$leadcount}}</span>
       </div>
   </div>
</div>
@endsection
