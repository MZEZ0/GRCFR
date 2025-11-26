<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Policies for {{ $company->name ?? 'Demo SME Co.' }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($policies as $policy)
                        @php
                            $userAssessment = $policy->assessments->first();
                            $statusLabels = [
                                'compliant' => 'Compliant',
                                'partial' => 'Partial',
                                'non_compliant' => 'Non-Compliant',
                                'not_applicable' => 'Not Applicable',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <a href="{{ route('policies.show', $policy) }}" class="text-indigo-600 dark:text-indigo-300 font-semibold">{{ $policy->code }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                <div class="font-medium">{{ $policy->title }}</div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">{{ $policy->short_description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                @if ($userAssessment)
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                                        @class([
                                            'bg-green-100 text-green-800' => $userAssessment->status === 'compliant',
                                            'bg-yellow-100 text-yellow-800' => $userAssessment->status === 'partial',
                                            'bg-red-100 text-red-800' => $userAssessment->status === 'non_compliant',
                                            'bg-gray-100 text-gray-800' => $userAssessment->status === 'not_applicable',
                                        ])">
                                        {{ $statusLabels[$userAssessment->status] }}
                                    </span>
                                @else
                                    <span class="text-gray-500">Not assessed</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
