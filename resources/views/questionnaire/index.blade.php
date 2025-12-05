<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ optional($company)->name ?? 'Demo SME Co.' }} · SME Security Baseline v1</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Security Baseline Questionnaire</h2>
            </div>
            <div class="text-right text-sm text-gray-600 dark:text-gray-300">
                <p class="font-semibold">{{ $answeredQuestions }} / {{ $totalQuestions }} questions answered</p>
                <p>{{ $completionPercentage }}% complete</p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Policies</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalPolicies }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Questions</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalQuestions }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Answered</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $answeredQuestions }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Completion</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $completionPercentage }}%</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2 dark:bg-gray-700">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Track your progress across all SME baseline policies.</p>
                </div>
                <a href="{{ route('policies.index') }}" class="text-indigo-600 dark:text-indigo-300 text-sm">View policy list</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Answered</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($policies as $policy)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $policy->code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $policy->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $policy->answered_count }} / {{ $policy->questions_count }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('questionnaire.show', $policy) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">{{ $policy->answered_count > 0 ? 'Continue' : 'Start' }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
