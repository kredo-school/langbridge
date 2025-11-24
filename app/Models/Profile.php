<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Profile extends Model
{
    use HasFactory;

    /**
     * 🔗 User モデルとのリレーション（1対1）
     */
    public function user()
    // App\Models\Profile.php

protected static function boot()
{
    parent::boot();

    static::creating(function ($profile) {
        $base = '@user' . $profile->user_id;
        $handle = $base;
        $counter = 1;

        while (Profile::where('handle', $handle)->exists()) {
            $handle = $base . $counter;
            $counter++;
        }

        $profile->handle = $handle;
    });
}
public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔍 検索で使う興味リレーション（User 経由）
     */
    public function interests()
    {
        return $this->user ? $this->user->interests : collect();
    }
}
