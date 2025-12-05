<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GRC Assessment Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1, h2, h3 { margin: 0 0 8px; }
        .section { margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px; text-align: left; }
        th { background: #f3f4f6; font-weight: bold; }
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; }
        .badge-high { background: #fecdd3; color: #991b1b; }
        .badge-medium { background: #fef3c7; color: #92400e; }
        .badge-low { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <h1>GRC Assessment Report – SME Security Baseline v1</h1>
    <p><strong>Company:</strong> {{ $company->name }} | {{ $company->sector }} | {{ $company->country }}</p>
    <p><strong>Contact:</strong> {{ $company->contact_person }} ({{ $company->contact_email }})</p>

    <div class="section">
        <h2>Summary</h2>
        <p>Total policies: {{ $totalPolicies }} | Compliant: {{ $statusSummary['compliant'] }} | Partial: {{ $statusSummary['partial'] }} | Non-compliant: {{ $statusSummary['non_compliant'] }} | N/A: {{ $statusSummary['not_applicable'] }}</p>
        <p>Overall compliance: {{ $compliancePercentage }}%</p>
    </div>

    <div class="section">
        <h3>Policy Compliance Overview</h3>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Evidence</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $statusLabels = [
                        'compliant' => 'Compliant',
                        'partial' => 'Partial',
                        'non_compliant' => 'Non-compliant',
                        'not_applicable' => 'Not Applicable',
                    ];
                @endphp
                @foreach ($policies as $policy)
                    @php $assessment = $policy->assessments->first(); @endphp
                    <tr>
                        <td>{{ $policy->code }}</td>
                        <td>{{ $policy->title }}</td>
                        <td>{{ $assessment ? $statusLabels[$assessment->status] : 'Not assessed' }}</td>
                        <td>{{ $truncateNotes($assessment->notes ?? '') }}</td>
                        <td>{{ $assessment?->evidenceFiles->count() ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Risk Register Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Score</th>
                    <th>Residual Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($risks as $risk)
                    @php
                        $badgeClass = match($risk->residual_level) {
                            'High' => 'badge-high',
                            'Medium' => 'badge-medium',
                            default => 'badge-low',
                        };
                    @endphp
                    <tr>
                        <td>{{ $risk->code }}</td>
                        <td>{{ $risk->title }}</td>
                        <td>{{ $risk->score }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ $risk->residual_level }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
