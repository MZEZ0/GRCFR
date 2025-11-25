<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            SME Security Baseline Dashboard
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Policies</div>
                <div class="text-3xl font-semibold text-gray-900 dark:text-white mt-2">{{ $totalPolicies }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Risks</div>
                <div class="text-3xl font-semibold text-gray-900 dark:text-white mt-2">{{ $totalRisks }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">Compliant Policies</div>
                <div class="text-3xl font-semibold text-gray-900 dark:text-white mt-2">{{ $compliantCount }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">Compliance %</div>
                <div class="text-3xl font-semibold text-gray-900 dark:text-white mt-2">{{ $compliancePercentage }}%</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Assessment Breakdown</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $statusLabels = [
                        'compliant' => 'Compliant',
                        'partial' => 'Partially Compliant',
                        'non_compliant' => 'Non-Compliant',
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
    </div>
</x-app-layout>
