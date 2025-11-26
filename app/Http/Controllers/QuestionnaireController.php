<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Company;
use App\Models\EvidenceFile;
use App\Models\Policy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    public function index(): View
    {
        $company = Company::firstOrFail();
        $userId = Auth::id();

        $policies = Policy::with(['assessments' => function ($query) use ($userId, $company) {
            $query->where('user_id', $userId)
                ->where('company_id', $company->id)
                ->latest();
        }])->orderBy('id')->get();

        $assessedCount = $policies->filter(fn ($policy) => $policy->assessments->first())->count();
        $totalPolicies = $policies->count();
        $remaining = $totalPolicies - $assessedCount;
        $percentComplete = $totalPolicies > 0 ? round(($assessedCount / $totalPolicies) * 100, 1) : 0;

        return view('questionnaire.index', compact('policies', 'company', 'assessedCount', 'remaining', 'percentComplete', 'totalPolicies'));
    }

    public function show(Policy $policy): View
    {
        $company = Company::firstOrFail();
        $assessment = Assessment::with('evidenceFiles')
            ->where('user_id', Auth::id())
            ->where('policy_id', $policy->id)
            ->where('company_id', $company->id)
            ->latest()
            ->first();

        $nextPolicy = Policy::where('id', '>', $policy->id)->orderBy('id')->first();

        return view('questionnaire.show', [
            'policy' => $policy,
            'assessment' => $assessment,
            'company' => $company,
            'nextPolicy' => $nextPolicy,
        ]);
    }

    public function store(Request $request, Policy $policy): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:compliant,partial,non_compliant,not_applicable',
            'notes' => 'nullable|string',
            'evidence.*' => 'file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ]);

        $company = Company::firstOrFail();
        $userId = Auth::id();

        $assessment = Assessment::updateOrCreate(
            [
                'user_id' => $userId,
                'company_id' => $company->id,
                'policy_id' => $policy->id,
            ],
            [
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]
        );

        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('evidence', 'public');
                EvidenceFile::create([
                    'assessment_id' => $assessment->id,
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'uploaded_at' => now(),
                ]);
            }
        }

        if ($request->input('save_next')) {
            $nextPolicy = Policy::where('id', '>', $policy->id)->orderBy('id')->first();

            if ($nextPolicy) {
                return redirect()
                    ->route('questionnaire.show', $nextPolicy)
                    ->with('success', 'Assessment saved. Moving to the next policy.');
            }

            return redirect()->route('questionnaire.index')->with('success', 'All policies have been assessed.');
        }

        return redirect()
            ->route('questionnaire.index')
            ->with('success', 'Assessment saved.');
    }
}
