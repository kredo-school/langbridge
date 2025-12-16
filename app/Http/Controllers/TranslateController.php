<?php

namespace App\Http\Controllers;

use App\Services\DeepLService;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    public function translate(Request $request, DeepLService $deepl)
    {
        try {
            $text = $request->input('text');
            $result = $deepl->translateBidirectional($text);

            return $result;
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Translation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
