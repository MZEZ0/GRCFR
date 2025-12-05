<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Policy;
use App\Models\Risk;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AssessmentReportController extends Controller
{
    public function index(): View
    {
        $company = Company::firstOrFail();
        $data = $this->buildReportData($company->id);

        return view('report.index', $data);
    }

    public function downloadPdf(): Response
    {
        $company = Company::firstOrFail();
        $data = $this->buildReportData($company->id);

        if (! class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
            return redirect()
                ->route('report.index')
                ->with('error', 'PDF export requires barryvdh/laravel-dompdf. Please install it to enable downloads.');
        }

        $pdf = app('dompdf.wrapper')->loadView('report.pdf', $data);

        return $pdf->download('GRC_Assessment_Report_Demo_SME.pdf');
    }

    private function buildReportData(int $companyId): array
    {
        $company = Company::findOrFail($companyId);
        $policies = Policy::with([
            'assessments' => function ($query) use ($companyId) {
                $query->where('company_id', $companyId)->latest();
            },
            'assessments.evidenceFiles',
        ])->orderBy('code')->get();

        $statusSummary = [
            'compliant' => 0,
            'partial' => 0,
            'non_compliant' => 0,
            'not_applicable' => 0,
        ];

        foreach ($policies as $policy) {
            $status = optional($policy->assessments->first())->status;
            if ($status && array_key_exists($status, $statusSummary)) {
                $statusSummary[$status]++;
            }
        }

        $totalPolicies = $policies->count();
        $compliancePercentage = $totalPolicies > 0 ? round(($statusSummary['compliant'] / $totalPolicies) * 100, 1) : 0;

        $risks = Risk::orderByDesc('score')->get();

        return [
            'company' => $company,
            'policies' => $policies,
            'statusSummary' => $statusSummary,
            'totalPolicies' => $totalPolicies,
            'compliancePercentage' => $compliancePercentage,
            'risks' => $risks,
            'truncateNotes' => fn (?string $text) => Str::limit($text ?? '', 80),
        ];
    }
}
