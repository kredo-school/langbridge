<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function settings()
    {
        return view('pages.quiz.settings');
    }

    public function step1(Request $request)
    {
        $only_unmastered = $request->only_unmastered;
        $query = Vocabulary::where('user_id', Auth::id());

        if($only_unmastered)
        {
            $query->where('status', '!=', 'mastered');
        }

        $max = $query->count();

        return view('pages.quiz.settings', ['max_questions' => $max, 'inputs' => $request->all()]);

    }

    public function start(Request $request)
    {
        $user_id = Auth::id();

        $order = $request->order;
        $only_unmastered = $request->only_unmastered;
        $side = $request->question_side;
        $count = (int)$request->count;

        $query = Vocabulary::where('user_id', $user_id);

        if($only_unmastered) {
            $query->where('status', '!=', 'mastered');
        }

        if($order === 'random'){
            $query->inRandomOrder();
        }else{
            $query->orderBy('created_at', 'asc');
        } 

        $questions = $query->limit($count)->get();

        return view('pages.quiz.card', [
            'questions' => $questions,
            'side' => $side
        ]);
    }

    public function card()
    {
        return view('pages.quiz.card');
    }
}
