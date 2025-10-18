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
}
