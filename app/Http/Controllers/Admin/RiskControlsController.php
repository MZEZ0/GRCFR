<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiskControls;
use App\Models\Risk;
use App\Models\Controls;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class RiskControlsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $riskControls = QueryBuilder::for(RiskControls::query()->with(['risk', 'control']))
            ->allowedFilters([
                AllowedFilter::exact('risk_id'),
                AllowedFilter::exact('control_id'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts(['created_at', 'status'])
            ->defaultSort('-created_at')
            ->paginate(10)
            ->appends($request->query());

        if ($request->ajax()) {
            return view('admin.risk-controls.partials.table', compact('riskControls'))->render();
        }

        return view('admin.risk-controls.index', compact('riskControls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $risks = Risk::select('id', 'title')->orderBy('title')->get();
        $controls = Controls::select('id', 'title')->orderBy('title')->get();
        return view('admin.risk-controls.create', compact('risks', 'controls'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'risk_id' => 'required|exists:risks,id',
            'control_id' => 'required|exists:controls,id',
            'effectiveness' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,pending',
        ]);

        RiskControl::create($validated);

        return redirect()
            ->route('admin.risk-controls.index')
            ->with('success', 'Risk-Control relationship created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RiskControls $riskControl)
    {
        $riskControl->load(['risk', 'control']);
        return view('admin.risk-controls.show', compact('riskControl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiskControls $riskControl)
    {
        $risks = Risk::select('id', 'title')->orderBy('title')->get();
        $controls = Control::select('id', 'title')->orderBy('title')->get();
        return view('admin.risk-controls.edit', compact('riskControl', 'risks', 'controls'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiskControls $riskControl)
    {
        $validated = $request->validate([
            'risk_id' => 'required|exists:risks,id',
            'control_id' => 'required|exists:controls,id',
            'effectiveness' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,pending',
        ]);

        $riskControl->update($validated);

        return redirect()
            ->route('admin.risk-controls.show', $riskControl)
            ->with('success', 'Risk-Control relationship updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiskControls $riskControl)
    {
        $riskControl->delete();

        return redirect()
            ->route('admin.risk-controls.index')
            ->with('success', 'Risk-Control relationship deleted successfully.');
    }
}
