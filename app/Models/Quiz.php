<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vocabulary_id',
        'is_correct',
        'attempt_number',
    ];

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 単語とのリレーション
    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }
}
