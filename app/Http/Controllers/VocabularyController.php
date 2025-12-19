<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;
use App\Services\VocabularyStatusService;


class VocabularyController extends Controller
{
    protected VocabularyStatusService $vocabulary_status_service;

    public function __construct(VocabularyStatusService $vocabulary_status_service)
    {
        $this->vocabulary_status_service = $vocabulary_status_service;
    }

    public function index()
    {
        $user_id = Auth::id();

        $this->vocabulary_status_service
            ->refreshStatusForUser($user_id);

        $vocabularies = Vocabulary::where('user_id', Auth::id())->paginate(10);

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
