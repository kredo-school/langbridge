<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Message extends Model
{

    protected $fillable = [
        'user_id',
        'to_user_id',
        'content',
        'image_path',
        'emoji',
        'is_read',
        'sent_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
