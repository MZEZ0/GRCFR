<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $company->name }} &middot; SME Security Baseline v1</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Policy Questionnaire</h2>
            </div>
            <div class="text-right text-sm text-gray-600 dark:text-gray-300">
                <p><span class="font-semibold">{{ $assessedCount }}</span> of {{ $totalPolicies }} answered</p>
                <p>{{ $percentComplete }}% complete</p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex flex-wrap items-center gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Progress</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $percentComplete }}%</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $remaining }} policies remaining</p>
            </div>
            <div class="flex-1 min-w-[200px]">
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $percentComplete }}%"></div>
                </div>
            </div>
            <div>
                <a href="{{ route('policies.index') }}" class="text-indigo-600 dark:text-indigo-300 text-sm">View all policies</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($policies as $policy)
                        @php
                            $assessment = $policy->assessments->first();
                            $statusLabels = [
                                'compliant' => 'Compliant',
                                'partial' => 'Partial',
                                'non_compliant' => 'Non-compliant',
                                'not_applicable' => 'Not Applicable',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $policy->code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $policy->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                @if ($assessment)
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                                        @class([
                                            'bg-green-100 text-green-800' => $assessment->status === 'compliant',
                                            'bg-yellow-100 text-yellow-800' => $assessment->status === 'partial',
                                            'bg-red-100 text-red-800' => $assessment->status === 'non_compliant',
                                            'bg-gray-100 text-gray-800' => $assessment->status === 'not_applicable',
                                        ])">
                                        {{ $statusLabels[$assessment->status] }}
                                    </span>
                                @else
                                    <span class="text-gray-500">Not answered</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('questionnaire.show', $policy) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">Answer</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
