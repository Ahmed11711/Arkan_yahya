<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class Blog extends Model
{
 
    protected $casts = [
    
    'push' => 'boolean',
    'push_date' => 'date',
];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}