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
    public function index()
    {
       $userid = Auth::id();
        $leads = Lead::where('user_id', $userid)->get();
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
        return redirect()->route('leads.index')->with('success', 'Lead Created successfully!');;
    }
        

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $showlead = Lead::with('negotiation_status')->findOrFail($id);
        $showlead = Lead::with(['negotiationstatus.followUps'])->findOrFail($id);
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
    return redirect()->route('leads.index')->with('success', 'Lead updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully');
    } 
}
