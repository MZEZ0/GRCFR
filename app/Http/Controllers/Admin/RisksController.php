<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Risk;

class RisksController extends Controller
{
    /**
     * Display a listing of risks.
     */
    public function index(Request $request)
    {
        $risks = Risk::orderBy('code')->paginate(10);

        return view('admin.risks.index', compact('risks'));
    }

    /**
     * Show the form for creating a new risk.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created risk in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified risk.
     */
    public function show(Risk $risk)
    {
        return view('admin.risks.show', compact('risk'));
    }

    /**
     * Show the form for editing the specified risk.
     */
    public function edit(Risk $risk)
    {
        abort(404);
    }

    /**
     * Update the specified risk in storage.
     */
    public function update(Request $request, Risk $risk)
    {
        abort(404);
    }

    /**
     * Remove the specified risk from storage.
     */
    public function destroy(Risk $risk)
    {
        abort(404);
    }
}
