<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    //

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }


   

}