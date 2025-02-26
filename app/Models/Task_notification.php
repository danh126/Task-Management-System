<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task_notification extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'message',
        'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
