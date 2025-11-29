<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str; // ここはクラスの外で use
use App\Models\User;

class Profile extends Model
{
    use HasFactory;

    // primary key を user_id に変更
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'nickname',
        'bio',
        // 他の fillable フィールドもここに追加
    ];

    protected $attributes = [
        'hidden' => true,
        'age_hidden' => true,
        'country_hidden' => true,
        'region_hidden' => true,
    ];

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

    /**
     * プロフィール作成時に handle を自動生成
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            // ランダムな英数字8文字で handle を生成
            $handle = Str::random(8);

            // 重複しないようにループ
            while (Profile::where('handle', $handle)->exists()) {
                $handle = Str::random(8);
            }

            $profile->handle = $handle;
        });
    }
}
