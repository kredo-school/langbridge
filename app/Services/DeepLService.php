<?php

namespace App\Services;

// use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepLService
{
    public function translateBidirectional($text)
    {
        // 日本語っぽいかどうかを簡易判定（正規表現）
        $isJapanese = preg_match('/\p{Han}|\p{Hiragana}|\p{Katakana}/u', $text);

        $targetLang = $isJapanese ? 'en-US' : 'ja';

        try {
            $authKey = config('services.deepl.key');
            // TODO Enable SSL verification after debugging
            $options = ['max_retries' => 5, 'timeout' => 10.0, 'server_url' => config('services.deepl.url')];
            $deeplClient = new \DeepL\DeepLClient($authKey, $options);
            Log::debug('DeepL Client sending request.', ['options' => $options, 'targetLang' => $targetLang, 'text' => $text]);
            $response = $deeplClient->translateText($text, null, $targetLang);
            Log::debug('DeepL Client received response.', ['response' => $response]);

            return [
                'original' => $text,
                'translated' => $response->text,
            ];
        } catch (\Exception $e) {
            Log::error('DeepL Client initialization error: ' . $e->getMessage());
            return [
                'original' => $text,
                'translated' => null,
                'error' => 'DeepL Client initialization failed',
            ];
        }
    }
}
