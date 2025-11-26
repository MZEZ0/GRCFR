<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $company->name }} &middot; SME Security Baseline v1</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Policies</div>
                <div class="text-3xl font-semibold text-gray-900 dark:text-white mt-2">{{ $totalPolicies }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">Policies Assessed</div>
                <div class="text-3xl font-semibold text-gray-900 dark:text-white mt-2">{{ $assessedPolicies }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">Overall Compliance</div>
                <div class="text-3xl font-semibold text-gray-900 dark:text-white mt-2">{{ $compliancePercentage }}%</div>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $compliantCount }} compliant out of {{ $totalPolicies }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">Risks</div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">H {{ $riskBreakdown['high'] }}</span>
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">M {{ $riskBreakdown['medium'] }}</span>
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">L {{ $riskBreakdown['low'] }}</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">High / Medium / Low residual risks</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Policy Assessment Breakdown</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $statusLabels = [
                            'compliant' => 'Compliant',
                            'partial' => 'Partial',
                            'non_compliant' => 'Non-compliant',
                            'not_applicable' => 'Not Applicable',
                        ];
                        $colors = [
                            'compliant' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100',
                            'partial' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100',
                            'non_compliant' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100',
                            'not_applicable' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100',
                        ];
                    @endphp
                    @foreach ($breakdown as $status => $count)
                        <div class="p-4 rounded-lg {{ $colors[$status] }}">
                            <div class="text-sm font-medium">{{ $statusLabels[$status] }}</div>
                            <div class="text-2xl font-semibold">{{ $count }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Risks by Score</h3>
                <div class="space-y-3">
                    @foreach ($topRisks as $risk)
                        <div class="border border-gray-100 dark:border-gray-700 rounded p-3">
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $risk->code }} &mdash; {{ $risk->title }}</p>
                                    <p class="text-gray-500 dark:text-gray-400">Score: {{ $risk->score }}</p>
                                </div>
                                @php
                                    $badgeClass = match($risk->residual_level) {
                                        'High' => 'bg-red-100 text-red-800',
                                        'Medium' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-green-100 text-green-800',
                                    };
                                @endphp
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">{{ $risk->residual_level }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status Table</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($breakdown as $status => $count)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $statusLabels[$status] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
