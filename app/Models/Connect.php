<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    protected $table="connects";

    protected $fillable = [
        'user_id',
        'date',
        'price',
        'connects_buy',
    ];
}
