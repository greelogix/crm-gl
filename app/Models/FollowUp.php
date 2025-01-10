<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $table="follow_ups";

    protected $fillable = [
        'negotiation_status_id', 
        'negotiation_status',
        'status',
    ];

    public function negotiationstatus()
    {
        return $this->belongsTo(NegotiationStatus::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
