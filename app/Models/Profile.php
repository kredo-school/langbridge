<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Interest;


class Profile extends Model
{

    use HasFactory;

    
    protected $fillable = [
        'nickname',
        'bio',
        //other fillable fields can be added here
    ];

    
    protected static function boot()
    {
        parent::boot();
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

    /**
     * 🔗 Which user this profile belongs to (one-to-one relationship)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔍 Get the interest categories of this profile (retrieved via User)
     */
    public function interests()
    {
        return $this->user ? $this->user->interests : collect();
    }
            // ランダムな英数字8文字を生成
            $handle = Str::random(8);
    
            while (Profile::where('handle', $handle)->exists()) {
                $handle = Str::random(8);
            }    
            $profile->handle = $handle;
        });
    }
}
