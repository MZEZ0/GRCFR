<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Policy;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalQuestions = Question::count();
        $answeredQuestions = Answer::where('user_id', $userId)
            ->distinct('question_id')
            ->count('question_id');

        $yesCount = Answer::where('user_id', $userId)->where('answer', 'yes')->count();
        $noCount = Answer::where('user_id', $userId)->where('answer', 'no')->count();
        $naCount = Answer::where('user_id', $userId)->where('answer', 'na')->count();

        $completion = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;

        $answers = Answer::with(['policy', 'question'])
            ->where('user_id', $userId)
            ->orderBy('policy_id')
            ->orderBy('question_id')
            ->get();

        $policies = Policy::withCount([
            'questions',
            'answers as answered_questions_count' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            },
        ])->orderBy('code')->get();

        return view('answers.index', [
            'answers' => $answers,
            'policies' => $policies,
            'totalQuestions' => $totalQuestions,
            'answeredQuestions' => $answeredQuestions,
            'completionPercentage' => $completion,
            'yesCount' => $yesCount,
            'noCount' => $noCount,
            'naCount' => $naCount,
        ]);
    }
}
