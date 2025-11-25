<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Policy;
use App\Models\Risk;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalPolicies = Policy::count();
        $totalRisks = Risk::count();

        $statusCounts = Assessment::where('user_id', $userId)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $compliantCount = $statusCounts['compliant'] ?? 0;
        $totalAssessed = $statusCounts->sum();
        $compliancePercentage = $totalAssessed > 0
            ? round(($compliantCount / $totalAssessed) * 100, 1)
            : 0;

        $breakdown = [
            'compliant' => $compliantCount,
            'partial' => $statusCounts['partial'] ?? 0,
            'non_compliant' => $statusCounts['non_compliant'] ?? 0,
            'not_applicable' => $statusCounts['not_applicable'] ?? 0,
        ];

        return view('dashboard', [
            'totalPolicies' => $totalPolicies,
            'totalRisks' => $totalRisks,
            'compliantCount' => $compliantCount,
            'compliancePercentage' => $compliancePercentage,
            'breakdown' => $breakdown,
        ]);
    }
}
