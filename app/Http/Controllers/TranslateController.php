<?php

namespace App\Http\Controllers;

use App\Services\DeepLService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TranslateController extends Controller
{
    //     public function translate(Request $request, DeepLService $deepl)
    //     {
    //         $text = $request->input('text');
    //         $result = $deepl->translateBidirectional($text);

    //         return response()->json([
    //             'original' => $result['original'],
    //             'translated' => $result['translated'],
    //         ]);
    //     }
    // }

    public function translate(Request $request, DeepLService $deepl)
    {
        try {
            $text = $request->input('text');
            $result = $deepl->translateBidirectional($text);

            return $result;
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Translation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
