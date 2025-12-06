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
        $vocabularies = Vocabulary::where('user_id', Auth::id())->paginate(12);
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

    public function settings()
    {
        return view('pages.vocabulary.settings');
    }

    // public function step1(Request $request)
    // {
    //     $only_unmastered = $request->only_unmastered;
    //     $query = Vocabulary::where('user_id', Auth::id());

    //     if($only_unmastered)
    //     {
    //         $query->where('status', '!=', 'mastered');
    //     }

    //     $max = $query->count();


    // }
}
