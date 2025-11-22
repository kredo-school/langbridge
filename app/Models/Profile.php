<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
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

}
