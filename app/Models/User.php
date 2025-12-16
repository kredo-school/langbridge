<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Models\Report;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'target_language',
        'birthday',
        'country',
        'region',
        'is_admin',
        
    ];
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'user_interest');
    }


    public function getAgeAttribute(){
    return Carbon::parse($this->birthday)->age;
    }
    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class);
    }

    public function recentChats()
{
    return $this->belongsToMany(User::class, 'chat_sessions', 'user_id', 'partner_id')
                ->withTimestamps()
                ->orderBy('chat_sessions.updated_at', 'desc');
}

use SoftDeletes;

    public function reports(){
        return $this->morphMany(Report::class, 'reportedContent');
    }

}

