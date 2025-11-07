<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserKyc extends Model
{
    protected $table='user_kycs';

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function front()
    // {
    //     return $this->belongsTo(Front::class, 'front_id');
    // }


    // public function back()
    // {
    //     return $this->belongsTo(Back::class, 'back_id');
    // }

}