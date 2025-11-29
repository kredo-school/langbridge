<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;


class VocabularyController extends Controller
{
    private $vocabulary; //ログインユーザの単語リスト

    public function __construct(Vocabulary $vocabulary)
    {
        $this->vocabulary = $vocabulary->where('user_id', Auth::id());
    }

    public function index()
    {
        $vocabularies = $this->vocabulary->get();
        return view('pages.vocabulary.index', compact('vocabularies'));
    }
}
