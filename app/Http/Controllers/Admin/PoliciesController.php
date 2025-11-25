<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\Framework;

class PoliciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $policies = Policy::orderBy('code')->paginate(10);

        return view('admin.policies.index', compact('policies'));
    }

    /**
     * Show the form for creating a new policy.
     */
    public function create()
    {
        return view('admin.policies.create');
    }

    /**
     * Store a newly created policy in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:policies,code',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
        ]);

        $frameworkId = Framework::first()->id ?? null;

        Policy::create($validated + ['framework_id' => $frameworkId]);

        return redirect()
            ->route('admin.policies.index')
            ->with('success', 'Policy created successfully.');
    }

    /**
     * Display the specified policy.
     */
    public function show(Policy $policy)
    {
        return view('admin.policies.show', compact('policy'));
    }

    /**
     * Show the form for editing the specified policy.
     */
    public function edit(Policy $policy)
    {
        return view('admin.policies.edit', compact('policy'));
    }

    /**
     * Update the specified policy in storage.
     */
    public function update(Request $request, Policy $policy)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:policies,code,' . $policy->id,
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
        ]);

        $policy->update($validated);

        return redirect()
            ->route('admin.policies.show', $policy)
            ->with('success', 'Policy updated successfully.');
    }

    /**
     * Remove the specified policy from storage.
     */
    public function destroy(Policy $policy)
    {
        $policy->delete();

        return redirect()
            ->route('admin.policies.index')
            ->with('success', 'Policy deleted successfully.');
    }
}
