<?php

namespace App\Http\Controllers;

use App\Services\DeepLService;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    public function translate(Request $request, DeepLService $deepl)
    {
        $text = $request->input('text');
        $result = $deepl->translateBidirectional($text);

        return response()->json([
            'original' => $result['original'],
            'translated' => $result['translated'],
        ]);
    }
}
