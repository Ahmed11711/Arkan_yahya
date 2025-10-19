<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class Service extends Model
{
   protected $casts = [
    
    'push' => 'boolean',
    'push_date' => 'date',
];

public function wallets()
{
    return $this->hasMany(Wallet::class);
}


}
