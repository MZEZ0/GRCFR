<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use Illuminate\View\View;

class RiskController extends Controller
{
    public function index(): View
    {
        $risks = Risk::orderBy('code')->get();

        return view('risks.index', compact('risks'));
    }
}
