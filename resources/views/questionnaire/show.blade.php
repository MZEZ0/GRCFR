<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ optional($company)->name ?? 'Demo SME Co.' }} · {{ $policy->code }}</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $policy->title }}</h2>
            </div>
            <a href="{{ route('questionnaire.index') }}" class="text-indigo-600 dark:text-indigo-300 text-sm">Back to questionnaire</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <p class="text-gray-700 dark:text-gray-300">{{ $policy->short_description }}</p>
            <p class="mt-4 text-gray-900 dark:text-gray-100 font-semibold">How compliant is your organization with this policy?</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('questionnaire.store', $policy) }}" class="space-y-4">
                @csrf
                @foreach ($policy->questions as $index => $question)
                    @php $existing = $answers[$question->id] ?? null; @endphp
                    <div class="border border-gray-200 dark:border-gray-700 rounded p-4 space-y-2">
                        <input type="hidden" name="question_id[]" value="{{ $question->id }}">
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $question->text }}</p>
                        <div class="flex flex-wrap gap-3 text-sm text-gray-800 dark:text-gray-100">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="answer[{{ $index }}]" value="yes" @checked(optional($existing)->answer === 'yes') required>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="answer[{{ $index }}]" value="no" @checked(optional($existing)->answer === 'no') required>
                                <span>No</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="answer[{{ $index }}]" value="na" @checked(optional($existing)->answer === 'na') required>
                                <span>Not applicable</span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-200">Notes (optional)</label>
                            <textarea name="notes[{{ $index }}]" rows="2" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Add context or evidence links">{{ old('notes.' . $index, optional($existing)->notes) }}</textarea>
                        </div>
                    </div>
                @endforeach

                @error('question_id')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('answer.*')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="flex items-center gap-3">
                    <button type="submit" name="save_next" value="1" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save &amp; Next</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-white">Save &amp; Back to list</button>
                </div>
            </form>
        </div>

        @if ($nextPolicy)
            <div class="text-right text-sm">
                <a href="{{ route('questionnaire.show', $nextPolicy) }}" class="text-indigo-600 dark:text-indigo-300">Skip to next policy ({{ $nextPolicy->code }})</a>
            </div>
        @endif
    </div>
</x-app-layout>
