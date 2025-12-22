<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyStatistic extends Model
{
    use HasFactory;

    protected $table = 'daily_statistics';

    protected $fillable = [
        'user_id',
        'date',
        'total_questions',
        'correct_questions',
        'accuracy',
        'attempt_number',
    ];

    protected $casts = [
        'date' => 'date',
        'accuracy' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
