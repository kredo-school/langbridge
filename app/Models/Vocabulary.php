<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    // fillable で一括代入を許可
    protected $fillable = [
        'user_id',
        'front',
        'back',
        'note',
        'status',
    ];

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // クイズ履歴とのリレーション
    public function quizes()
    {
        return $this->hasMany(Quiz::class);
    }
}
