<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'user_id','client_name', 'tech_stack', 'connects_spent', 'proposal_name',
        'proposal_link', 'country', 'proposal_date','rate_type','rate_value',
    ];

    public function negotiationstatus()
    {
        return $this->hasOne(NegotiationStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
