<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
      * affiliate -> parent user (belongsTo)
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
