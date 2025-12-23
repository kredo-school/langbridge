<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Vocabulary;
use App\Models\DailyStatistic;
use Illuminate\Support\Facades\Auth;
use App\Services\VocabularyStatusService;
use App\Services\UserDateService;
use Carbon\Carbon;

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

    public function start(Request $request, UserDateService $userDate)
    {
        $user_id = Auth::id();

        $order = $request->order;
        $only_unmastered = $request->only_unmastered;
        $side = $request->question_side;
        $count = (int)$request->count;

        [$today_start, $today_end] = $userDate->getTodayUtcRange($user_id);

        $query = Vocabulary::where('user_id', $user_id);

        if ($only_unmastered) {
            $query->where('status', '!=', 'mastered');
        }

        if ($order === 'random') {
            $query->inRandomOrder();
        } else {
            $query->orderBy('created_at', 'asc');
        }

        $questions = $query->limit($count)->get();

        $todayCount = Quiz::where('user_id', Auth::id())
            ->whereBetween('created_at', [$today_start, $today_end])
            ->max('attempt_number');

        $attemptNumber = $todayCount ? $todayCount + 1 : 1;
    
        session([
            'quiz_questions' => $questions,
            'quiz_side' => $side,
            'quiz_attempt_number' => $attemptNumber,
        ]);

        return redirect()->route('quiz.run', ['index' => 0]);
    }

    public function run(Request $request, VocabularyStatusService $statusService, UserDateService $userDate)
    {
        $questions = session('quiz_questions');
        $side = session('quiz_side');
        $index = $request->index ?? 0;

        [$today_start, $today_end] = $userDate->getTodayUtcRange(Auth::id());

        if (!$questions || $index >= count($questions)) {
            $user_id = Auth::id();
            $today = $userDate->getTodayDateString($user_id);

            $statusService->promoteLearningToMastered($user_id);

            $latest_attempt = Quiz::where('user_id', $user_id)
                ->latest('id')
                ->value('attempt_number');

            $total = Quiz::where('user_id', $user_id)
                ->where('attempt_number', $latest_attempt)
                ->whereBetween('created_at', [$today_start, $today_end])
                ->count();

            $correct = Quiz::where('user_id', $user_id)
                ->where('attempt_number', $latest_attempt)
                ->where('is_correct', true)
                ->whereBetween('created_at', [$today_start, $today_end])
                ->count();

            $accuracy = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

            DailyStatistic::create([
                'user_id' => $user_id,
                'date' => $today,
                'total_questions' => $total,
                'correct_questions' => $correct,
                'accuracy' => $accuracy,
                'attempt_number' => $latest_attempt,
            ]);

            return redirect()->route('quiz.result')->with([
                'attempt_number' => $latest_attempt,
                'total' => $total,
                'correct' => $correct
            ]);
        }

        $question = $questions[$index];

        return view('pages.quiz.card', [
            'question' => $question,
            'side' => $side,
            'index' => $index,
            'total' => count($questions),
        ]);
    }

    public function record(Request $request)
    {
        $user_id = Auth::id();

        Quiz::create([
            'user_id' => $user_id,
            'vocabulary_id' => $request->vocabulary_id,
            'is_correct' => $request->is_correct,
            'attempt_number' => session('quiz_attempt_number')
        ]);

        // unlearned → learning
        Vocabulary::where('id', $request->vocabulary_id)
            ->where('user_id', $user_id)
            ->where('status', 'unlearned')
            ->update(['status' => 'learning']);

        $next_index = $request->index + 1;

        return redirect()->route('quiz.run', ['index' => $next_index]);
    }

    public function result()
    {
        return view('pages.quiz.result');
    }


    public function card()
    {
        return view('pages.quiz.card');
    }

}
