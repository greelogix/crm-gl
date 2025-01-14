<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Requests\LeadRequest;
use App\Mail\NegotiationReminderMail;
use App\Models\NegotiationStatus;
use Carbon\Carbon;
use App\Helpers\authHelpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {

    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('status_lead');
        if ($user->role === 'admin') {
            $leadsQuery = Lead::query();
        } else {
            $leadsQuery = Lead::where('user_id', $user->id);
        }
    
        if ($filter == 1) {
            $leadsQuery->where('status', 1);
        }
    
        // if ($request->start_date) {
        //     $startDate = Carbon::parse($request->start_date)->startOfDay();
        //     $leadsQuery->where('created_at', '>=', $startDate);
        // }
    
        // if ($request->end_date) {
        //     $endDate = Carbon::parse($request->end_date)->endOfDay();
        //     $leadsQuery->where('created_at', '<=', $endDate);
        // }
    
        $leads = $leadsQuery->orderBy('id', 'desc')->get();
        
        return view('leads.index', compact('leads'));
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadRequest $request)
     {
        Lead::create($request->validated());
        return redirect()->route('leads.index')->with('success', 'Proposal created successfully!');
    }
        

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leadUpdated = Lead::where('id', $id)->update([
            'status' => true,
            'date' => \Carbon\Carbon::now()->format('Y-m-d'),
        ]);

        $showlead = Lead::with(['negotiationstatus.followUps'])->findOrFail($id);
    
        if ($leadUpdated) {
            session()->flash('success', 'Lead Created Successfully!');
        }

        return view('leads.show', compact('showlead'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editlead = Lead::findOrFail($id);
        return response()->json([
            'success' => true,
            'lead' => $editlead
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadRequest $request, string $id)
{
    $validatedData = $request->validated();

    $lead = Lead::findOrFail($id);
    $lead->update($validatedData);
    return redirect()->route('leads.index')->with('success', 'Proposal updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Proposal deleted successfully');
    } 
}
