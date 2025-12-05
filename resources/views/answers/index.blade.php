@php use Illuminate\Support\Str; @endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ optional($activeCompany)->name ?? 'Demo SME Co.' }} · SME Security Baseline v1</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Questionnaire Answers</h2>
            </div>
            <div class="text-right text-sm text-gray-600 dark:text-gray-300">
                <p class="font-semibold">{{ $answeredQuestions }} / {{ $totalQuestions }} questions answered</p>
                <p>{{ $completionPercentage }}% complete</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Completion</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $completionPercentage }}%</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2 dark:bg-gray-700">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Yes responses</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $yesCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">No responses</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $noCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Not applicable</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $naCount }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Review and update your answers across all policies.</p>
                </div>
                <a href="{{ route('questionnaire.index') }}" class="text-indigo-600 dark:text-indigo-300 text-sm">Back to questionnaire</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Answered</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Update</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($policies as $policy)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $policy->code }} · {{ $policy->title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $policy->short_description }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $policy->answered_questions_count }} / {{ $policy->questions_count }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('questionnaire.show', $policy) }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">Update responses</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Latest answers</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ordered by policy and question.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($answers as $answer)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $answer->policy->code ?? 'Policy' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $answer->question->text ?? 'Question' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $labelMap = ['yes' => 'Yes', 'no' => 'No', 'na' => 'Not applicable'];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ $labelMap[$answer->answer] ?? $answer->answer }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ Str::limit($answer->notes, 80) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if ($answer->policy)
                                        <a href="{{ route('questionnaire.show', $answer->policy) }}" class="text-indigo-600 dark:text-indigo-300 text-sm">Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 text-center">No answers yet. Start with the questionnaire.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
