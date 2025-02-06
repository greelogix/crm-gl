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

        foreach ($negotiations as $negotiation) {
            $user = $negotiation->user;
            $followUpCount = FollowUp::where('negotiation_status_id', $negotiation->id)
            ->where('negotiation_status', $negotiation->negotiation_status)
            ->count();
            if ($followUpCount < 7) {
                Mail::to($user->email)->send(new ReminderMail($negotiation));
                $followUp = FollowUp::create([
                    'negotiation_status_id' => $negotiation->id,
                    'negotiation_status' => $negotiation->negotiation_status,
                    'status' => false,
                ]);

                if ($followUp->created_at->diffInDays(now()) >= 1 && !$followUp->status) {
                    Mail::to($user->email)->send(new FollowUpReminderMail($followUp, $negotiation));
                }
            } elseif ($followUpCount >= 7) {
                $negotiation->update(['negotiation_sub_status' => 'Loss']);
            }
        }
    }
} 




