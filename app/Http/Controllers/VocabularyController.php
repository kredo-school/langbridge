<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;


class VocabularyController extends Controller
{
    private $vocabulary; //ログインユーザの単語リスト

    public function index()
    {
        $vocabularies = Vocabulary::where('user_id', Auth::id())->get();
        return view('pages.vocabulary.index', compact('vocabularies'));
    }

    public function destroy($id)
    {
        Vocabulary::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail()
        ->delete();

        return redirect()->route('vocabulary.index');
    }
}
