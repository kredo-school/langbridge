<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vocabulary;
use App\Models\Quiz;
use Carbon\Carbon;

class VocabularyStatusService
{
    public function refreshStatusForUser(int $userId): void
    {

        $timezone = $this->getTimeZone($userId);

        $threshold_utc = Carbon::now($timezone)
        ->subDays(14)
        ->startOfDay()
        ->setTimezone('UTC');

         $vocabularyIds = Quiz::selectRaw('vocabulary_id, MAX(created_at) as last_correct_at')
            ->where('user_id', $userId)
            ->where('is_correct', true)
            ->groupBy('vocabulary_id')
            ->having('last_correct_at', '<', $threshold_utc)
            ->pluck('vocabulary_id');

        if ($vocabularyIds->isEmpty()) {
        return;
        }

        Vocabulary::where('user_id', $userId)
            ->where('status', 'mastered')
            ->whereIn('id', $vocabularyIds)
            ->update(['status' => 'learning']);
    }

    public function promoteLearningToMastered(int $userId): void
    {

        $timezone = $this->getTimeZone($userId);

        // ユーザーTZ基準で「7日前の開始」
        $fromUserTz = Carbon::now($timezone)
            ->subDays(7)
            ->startOfDay();

        // UTC に変換（DB用）
        $fromUtc = $fromUserTz->setTimezone('UTC');

        $learningVocabularyIds = Vocabulary::where('user_id', $userId)
            ->where('status', 'learning')
            ->pluck('id');

        if ($learningVocabularyIds->isEmpty()) {
            return;
        }

        $stats = Quiz::selectRaw('
                vocabulary_id,
                COUNT(*) as total,
                SUM(is_correct) as correct
            ')
            ->where('user_id', $userId)
            ->whereIn('vocabulary_id', $learningVocabularyIds)
            ->where('created_at', '>=', $fromUtc)
            ->groupBy('vocabulary_id')
            ->get();

        foreach ($stats as $stat) {
            $accuracy = $stat->correct / $stat->total;

            if ($stat->total >= 3 && $accuracy >= 0.8) {
                Vocabulary::where('id', $stat->vocabulary_id)
                    ->update([
                        'status' => 'mastered',
                    ]);
            }
        }
    }

    private function getTimezone(int $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return;
        }

        return $user->timezone ?? 'UTC';
    }
}