<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Profile extends Model
{
    use HasFactory;
   //add unique handle name when creating profile
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            // Example: create a handle name like @user5
            $base = '@user' . $profile->user_id;
            $handle = $base;
            $counter = 1;

            // If the same handle name already exists, add a number like @user5 → @user51 → @user52...
            while (Profile::where('handle', $handle)->exists()) {
                $handle = $base . $counter;
                $counter++;
            }
            // Set the unique handle name
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
        // If there is a user, return that user's interests. Otherwise, return an empty collection.
        return $this->user ? $this->user->interests : collect();
    }
}
