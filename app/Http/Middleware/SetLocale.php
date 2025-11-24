<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            // target_language の逆を母語として UI 言語に設定
            $locale = $user->target_language === 'en' ? 'ja' : 'en';
            app()->setLocale($locale);
        }

        return $next($request);
    }
}