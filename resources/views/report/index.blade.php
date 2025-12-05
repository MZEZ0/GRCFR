<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $company->name }} &middot; SME Security Baseline v1</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">GRC Assessment Report</h2>
            </div>
            <div class="space-x-3">
                <a href="{{ route('report.pdf') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">Export to PDF</a>
            </div>
        </div>
    </x-slot>

    @if (session('error'))
        <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6 print:bg-white">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Company</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $company->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $company->sector }} &middot; {{ $company->country }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Contact</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $company->contact_person }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $company->contact_email }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Overall Compliance</p>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $compliancePercentage }}%</p>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Policies</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalPolicies }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Compliant</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statusSummary['compliant'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Partially compliant</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statusSummary['partial'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Non-compliant / N/A</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statusSummary['non_compliant'] + $statusSummary['not_applicable'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Policy Compliance Overview</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evidence</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $statusLabels = [
                                'compliant' => 'Compliant',
                                'partial' => 'Partial',
                                'non_compliant' => 'Non-compliant',
                                'not_applicable' => 'Not Applicable',
                            ];
                        @endphp
                        @foreach ($policies as $policy)
                            @php
                                $assessment = $policy->assessments->first();
                            @endphp
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $policy->code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $policy->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $assessment ? $statusLabels[$assessment->status] : 'Not assessed' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $truncateNotes($assessment->notes ?? '') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $assessment?->evidenceFiles->count() ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Risk Register Summary</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Residual Level</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($risks as $risk)
                            @php
                                $badgeClass = match($risk->residual_level) {
                                    'High' => 'bg-red-100 text-red-800',
                                    'Medium' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-green-100 text-green-800',
                                };
                            @endphp
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $risk->code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $risk->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $risk->score }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">{{ $risk->residual_level }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
