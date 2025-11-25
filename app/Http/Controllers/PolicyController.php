<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\EvidenceFile;
use App\Models\Policy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PolicyController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $policies = Policy::with(['assessments' => function ($query) use ($userId) {
            $query->where('user_id', $userId)->latest();
        }])->orderBy('code')->get();

        return view('policies.index', compact('policies'));
    }

    public function show(Policy $policy): View
    {
        $assessment = Assessment::with('evidenceFiles')
            ->where('user_id', Auth::id())
            ->where('policy_id', $policy->id)
            ->latest()
            ->first();

        return view('policies.show', [
            'policy' => $policy,
            'assessment' => $assessment,
        ]);
    }

    public function assess(Request $request, Policy $policy): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:compliant,partial,non_compliant,not_applicable',
            'notes' => 'nullable|string',
            'evidence.*' => 'file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ]);

        $userId = Auth::id();

        $assessment = Assessment::updateOrCreate(
            ['user_id' => $userId, 'policy_id' => $policy->id],
            ['status' => $validated['status'], 'notes' => $validated['notes'] ?? null]
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

        return redirect()
            ->route('policies.show', $policy)
            ->with('success', 'Assessment saved successfully.');
    }
}
