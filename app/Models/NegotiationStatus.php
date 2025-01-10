<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegotiationStatus extends Model
{
    use HasFactory;

    protected $table="negotiations_status";

    protected $fillable = [
        'user_id',
        'lead_id',
        'negotiation_status',
        'negotiation_sub_status',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }
}
