<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Company;
use App\Models\Policy;
use App\Models\Risk;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $company = Company::firstOrFail();

        $totalPolicies = Policy::count();
        $totalRisks = Risk::count();

        $statusCounts = Assessment::where('user_id', $userId)
            ->where('company_id', $company->id)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $compliantCount = $statusCounts['compliant'] ?? 0;
        $assessedPolicies = Assessment::where('user_id', $userId)
            ->where('company_id', $company->id)
            ->distinct('policy_id')
            ->count('policy_id');

        $compliancePercentage = $totalPolicies > 0
            ? round(($compliantCount / $totalPolicies) * 100, 1)
            : 0;

        $breakdown = [
            'compliant' => $compliantCount,
            'partial' => $statusCounts['partial'] ?? 0,
            'non_compliant' => $statusCounts['non_compliant'] ?? 0,
            'not_applicable' => $statusCounts['not_applicable'] ?? 0,
        ];

        $riskBreakdown = [
            'high' => Risk::where('residual_level', 'High')->count(),
            'medium' => Risk::where('residual_level', 'Medium')->count(),
            'low' => Risk::where('residual_level', 'Low')->count(),
        ];

        $topRisks = Risk::orderByDesc('score')->take(5)->get();

        return view('dashboard', [
            'company' => $company,
            'totalPolicies' => $totalPolicies,
            'totalRisks' => $totalRisks,
            'compliantCount' => $compliantCount,
            'assessedPolicies' => $assessedPolicies,
            'compliancePercentage' => $compliancePercentage,
            'breakdown' => $breakdown,
            'riskBreakdown' => $riskBreakdown,
            'topRisks' => $topRisks,
        ]);
    }
}
