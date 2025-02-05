<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use App\Models\NegotiationStatus;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NegotiationController extends Controller
{
    public function store(Request $request)
    {
        $user_id = Auth::id();
       
        $request->validate([
            'lead_id' => 'required',
            'negotiation_status' => 'required',
        ]);
       
        $negotiation = NegotiationStatus::updateOrCreate(
            ['user_id' => $user_id, 'lead_id' => $request->lead_id],
            [
                'negotiation_status' => $request->negotiation_status,
                'negotiation_sub_status' => $request->negotiation_sub_status ?? null,
                'updated_at' => now(),
            ]
        );
        return redirect()->back()->with('success', 'Successfully Update!');
    }

    public function updateSubStatus(Request $request)
    {
        $user_id = Auth::id();
        $request->validate([
            'lead_id' => 'required',
            'negotiation_sub_status' => 'required',
        ]);

        $negotiation = NegotiationStatus::where('user_id', $user_id)
            ->where('lead_id', $request->lead_id)
            ->first();

        if (!$negotiation) {
            return redirect()->back()->with('error', 'Negotiation status not found', 404);
            // return response()->json(['error' => 'Negotiation status not found'], 404);
        }

        $negotiation->update([
            'negotiation_sub_status' => $request->negotiation_sub_status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Successfully Update!');
    }

    public function markAsRead($id)
{
    $followUp = FollowUp::findOrFail($id);
    if ($followUp) {
        $followUp->status = 1;
        $followUp->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'FollowUp not found']);
}
}

