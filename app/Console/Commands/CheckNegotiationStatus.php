<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NegotiationStatus;
use App\Mail\ReminderMail;
use App\Mail\FollowUpReminderMail;
use App\Models\FollowUp;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckNegotiationStatus extends Command
{
    protected $signature = 'app:check-status';
    protected $description = 'Check negotiation statuses and send reminders';

    public function handle()
    {
        $negotiations = NegotiationStatus::with(['user', 'lead'])
        ->whereNull('negotiation_sub_status')
        ->where('updated_at', '<=', now()->subDay(2))
        ->get();

        if ($negotiations->isNotEmpty()) {
            foreach ($negotiations as $negotiation) {
                $user = $negotiation->user;
                Mail::to($user->email)->send(new ReminderMail($negotiation));
                
                $followUp = FollowUp::create([
                        'negotiation_status_id' => $negotiation->id,
                        'negotiation_status' => $negotiation->negotiation_status,
                        'status' => false, 
                    ]);

                    if ($followUp && Carbon::parse($followUp->created_at)->diffInHours(now()) >= 24 && $followUp->status == false) {
                        Mail::to($user->email)->send(new FollowUpReminderMail($followUp,$negotiation));
                    }

                if (Carbon::parse($negotiation->updated_at)->diffInDays(now()) >= 7) {
                    $negotiation->update([
                        'negotiation_sub_status' => 'Loss',
                    ]);
                }
            }
        }
    }
}    