<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserDateService
{
    public function getUserTimezone(?int $userId = null): string
    {
        $user = $userId
            ? User::findOrFail($userId)
            : Auth::user();

        return $user->timezone ?? config('app.timezone');
    }

    /**
     * ユーザの「今日」を UTC の start / end で返す
     */
    public function getTodayUtcRange(?int $userId = null): array
    {
        $tz = $this->getUserTimezone($userId);

        $start = Carbon::now($tz)
            ->startOfDay()
            ->timezone('UTC');

        $end = Carbon::now($tz)
            ->endOfDay()
            ->timezone('UTC');

        return [$start, $end];
    }

    /**
     * ユーザ基準の「今日の日付（Y-m-d）」を返す
     */
    public function getTodayDateString(?int $userId = null): string
    {
        $tz = $this->getUserTimezone($userId);

        return Carbon::now($tz)->toDateString();
    }
}
