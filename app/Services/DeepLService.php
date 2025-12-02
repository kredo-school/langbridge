<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeepLService
{
    public function translateBidirectional($text)
    {
        // 日本語っぽいかどうかを簡易判定（正規表現）
        $isJapanese = preg_match('/\p{Han}|\p{Hiragana}|\p{Katakana}/u', $text);

        $targetLang = $isJapanese ? 'EN' : 'JA';

        $response = Http::asForm()->post(config('services.deepl.url'), [
            'auth_key' => config('services.deepl.key'),
            'text' => $text,
            'target_lang' => $targetLang,
        ]);

        return [
            'original' => $text,
            'translated' => $response->json()['translations'][0]['text'] ?? null,
        ];
    }
}
