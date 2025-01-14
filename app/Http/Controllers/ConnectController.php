<?php

namespace App\Http\Controllers;

use App\Models\Connect;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ConnectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->role === 'admin'){
            $connects = Connect::orderBy('date', 'asc')->get();
            $leads = Lead::where('status', '1')->get();
        }else{
            $connects = Connect::where('user_id', $user->id)->orderBy('date', 'asc')->get();
            $leads = Lead::where('user_id', $user->id)->where('status', '1')->get();
        }

        $groupedByWeekConnects = $connects->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->date)->startOfWeek()->format('Y-m-d') . ' - ' . \Carbon\Carbon::parse($item->date)->endOfWeek()->format('Y-m-d');
        });
    
        $groupedByWeekLeads = $leads->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->date)->startOfWeek()->format('Y-m-d') . ' - ' . \Carbon\Carbon::parse($item->date)->endOfWeek()->format('Y-m-d');
        });
        
    
        return view('connect.index', compact('groupedByWeekConnects', 'groupedByWeekLeads' ,'connects'));
    }
    


    public function store(Request $request){
      
        $userid = Auth::id();
        $validatedData = $request->validate([
            'date' => 'required|date',
            'price' => 'required|numeric',
            'connects_buy' => 'required|integer',
        ]);

        Connect::create([
            'user_id' => $userid,
            'date' => $validatedData['date'],
            'price' => $validatedData['price'],
            'connects_buy' => $validatedData['connects_buy'],
        ]);
        return redirect()->route('connect')->with('success', 'Connect added successfully.');
    }
}
