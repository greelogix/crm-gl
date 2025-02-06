@extends('layouts.app')

@section('content')
<div class="mb-5 pb-3 d-flex justify-content-between position-relative" style="top: 35px;">
    {{-- <div class="">
        <h5 style="font-size: large;">Available Connects: {{$remainingConnects[$user->id] ?? 0}}</h5>
    </div>
    <div>
        <button class="btn btn-purple add-cuctomer create-connect shadow-none"  data-bs-toggle="modal" data-bs-target="#ConnectModal" style="font-size: small;">Add Connects</button>
    </div> --}}
</div>

<table id="customerTable" class="table align-middle w-100 mt-5">
    <thead class="table-active">
        <tr style="font-size: small; background-color: #f8f9fa;">
            <th></th>
            <th>Sr.</th>
            <th>Name</th>
            <th>Date</th>
            <th>Total Price</th>
            <th>Total Connects</th>
            <th>Total Use Connects</th>
            <th>Remaining Connects</th>
            {{-- <th>Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @if($connects->isEmpty())
            <tr>
                <td colspan="8" class="text-center">No data available in table</td>
            </tr>
        @else
            @foreach ($connects->groupBy('user_id') as $userId => $userConnects)
            <td colspan="8" class="text-center table-active" onclick="toggleUserConnects('{{ $userId }}')">
                <p style="position: relative; right: 600px; top: 30px; font-size: smaller;">
                    <i id="icon-{{ $userId }}" class="fa-sharp fa-solid fa-angle-down"></i>
                </p>
                <strong style="font-size: smaller;font-weight: 600;">{{ $userConnects->first()->user->name }}</strong>
            </td>
            
            @foreach ($userConnects as $connect)
                <tr id="user-connects-{{ $userId }}" style="font-size: small; background-color: #f8f9fa; display: none;" class="user-connect-row">
                    <td></td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $connect->user->name }}</td>
                    <td>{{ $connect->date }}</td>
                    <td>${{ $connect->price }}</td>
                    <td>{{ $connect->connects_buy }}</td>
                    <td>
                        @php
                            $dailyLeads = $leads->where('user_id', $connect->user_id)->where('created_at', '>=', \Carbon\Carbon::parse($connect->date)->startOfDay())->where('created_at', '<=', \Carbon\Carbon::parse($connect->date)->endOfDay());
                        @endphp
                        {{ $dailyLeads->sum('connects_spent') }}
                    </td>
                    <td>{{ $remainingConnects[$userId][$connect->date] ?? 0 }}</td>
                </tr>
            @endforeach
            
            @endforeach
        @endif
    </tbody>
</table>
@endsection
<script>
    function toggleUserConnects(userId) {
        var rows = document.querySelectorAll('#user-connects-' + userId);
        var icon = document.querySelector('#icon-' + userId);

        rows.forEach(function(row) {
            if (row.style.display === 'none') {
                row.style.display = '';
                icon.classList.remove('fa-angle-down');
                icon.classList.add('fa-angle-up');
            } else {
                row.style.display = 'none';
                icon.classList.remove('fa-angle-up');
                icon.classList.add('fa-angle-down');
            }
        });
    }
</script>

