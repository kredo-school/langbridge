<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    // App\Models\Profile.php
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $attributes = [
        'hidden' => true,
        'age_hidden' => true,
        'country_hidden' => true,
        'region_hidden' => true,
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    protected static function boot(){
        parent::boot();
        static::creating(function ($profile) {
            // ランダムな英数字8文字を生成
            $handle = Str::random(8);
    
            while (Profile::where('handle', $handle)->exists()) {
                $handle = Str::random(8);
            }    
            $profile->handle = $handle;
        });
    }
}
