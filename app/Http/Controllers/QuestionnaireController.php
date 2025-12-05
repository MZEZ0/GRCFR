<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Company;
use App\Models\Policy;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();
        $policies = Policy::withCount('questions')
            ->withCount(['answers as answered_count' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->orderBy('id')
            ->get();

        $totalPolicies = $policies->count();
        $totalQuestions = Question::count();
        $answeredQuestions = Answer::where('user_id', $userId)->count();
        $completionPercentage = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 1) : 0;

        return view('questionnaire.index', [
            'policies' => $policies,
            'company' => Company::first(),
            'totalPolicies' => $totalPolicies,
            'totalQuestions' => $totalQuestions,
            'answeredQuestions' => $answeredQuestions,
            'completionPercentage' => $completionPercentage,
        ]);
    }

    public function show(Policy $policy): View
    {
        $policy->load('questions');

        $answers = Answer::where('user_id', Auth::id())
            ->where('policy_id', $policy->id)
            ->get()
            ->keyBy('question_id');

        return view('questionnaire.show', [
            'policy' => $policy,
            'company' => Company::first(),
            'answers' => $answers,
            'nextPolicy' => Policy::where('id', '>', $policy->id)->orderBy('id')->first(),
        ]);
    }

    public function store(Request $request, Policy $policy): RedirectResponse
    {
        $validated = $request->validate([
            'question_id' => 'required|array',
            'question_id.*' => 'exists:questions,id',
            'answer' => 'required|array',
            'answer.*' => 'in:yes,no,na',
            'notes' => 'array',
            'notes.*' => 'nullable|string',
        ]);

        $userId = Auth::id();

        foreach ($validated['question_id'] as $index => $questionId) {
            $response = $validated['answer'][$index] ?? null;

            if (! $response) {
                continue;
            }

            Answer::updateOrCreate(
                [
                    'user_id' => $userId,
                    'policy_id' => $policy->id,
                    'question_id' => $questionId,
                ],
                [
                    'answer' => $response,
                    'notes' => $validated['notes'][$index] ?? null,
                ]
            );
        }

        if ($request->input('save_next')) {
            $nextPolicy = Policy::where('id', '>', $policy->id)->orderBy('id')->first();

            if ($nextPolicy) {
                return redirect()
                    ->route('questionnaire.show', $nextPolicy)
                    ->with('success', 'Responses saved. Moving to the next policy.');
            }

            return redirect()->route('questionnaire.index')->with('success', 'All policy questions have been answered.');
        }

        return redirect()
            ->route('questionnaire.index')
            ->with('success', 'Responses saved.');
    }
}
