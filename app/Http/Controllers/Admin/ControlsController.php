<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Controls;
use App\Models\Risk; // Updated import
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ControlsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $controls = QueryBuilder::for(Controls::query())
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts(['title', 'status', 'created_at'])
            ->defaultSort('-created_at')
            ->paginate(10)
            ->appends($request->query());

        if ($request->ajax()) {
            return view('admin.controls.partials.table', compact('controls'))->render();
        }

        return view('admin.controls.index', compact('controls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ✅ Load all risks for the dropdown
        $risks = Risk::select('id', 'title')->orderBy('title')->get();
        return view('admin.controls.create', compact('risks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:100',
            'risk_id' => 'nullable|exists:risks,id',
            'status' => 'required|in:active,inactive,under_review',
        ]);

        Control::create($validated);

        return redirect()
            ->route('admin.controls.index')
            ->with('success', 'Control created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Controls $control)
    {
        return view('admin.controls.show', compact('control'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Controls $control)
    {
        $risks = Risk::select('id', 'title')->orderBy('title')->get();
        return view('admin.controls.edit', compact('control', 'risks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Controls $control)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:100',
            'risk_id' => 'nullable|exists:risks,id',
            'status' => 'required|in:active,inactive,under_review',
        ]);

        $control->update($validated);

        return redirect()
            ->route('admin.controls.show', $control)
            ->with('success', 'Control updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Controls $control)
    {
        $control->delete();

        return redirect()
            ->route('admin.controls.index')
            ->with('success', 'Control deleted successfully.');
    }
}
