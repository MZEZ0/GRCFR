<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $company->name }} &middot; {{ $policy->code }}</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $policy->title }}</h2>
            </div>
            <a href="{{ route('questionnaire.index') }}" class="text-indigo-600 dark:text-indigo-300 text-sm">Back to questionnaire</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <p class="text-gray-700 dark:text-gray-300">{{ $policy->short_description }}</p>
            <p class="mt-4 text-gray-900 dark:text-gray-100 font-semibold">How compliant is your organization with this policy?</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('questionnaire.store', $policy) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Compliance status</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @php
                            $options = [
                                'compliant' => 'Compliant',
                                'partial' => 'Partially compliant',
                                'non_compliant' => 'Non-compliant',
                                'not_applicable' => 'Not applicable',
                            ];
                        @endphp
                        @foreach ($options as $value => $label)
                            <label class="flex items-center gap-2 p-3 border rounded cursor-pointer dark:border-gray-700">
                                <input type="radio" name="status" value="{{ $value }}" @checked(optional($assessment)->status === $value) required>
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('status')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Notes</label>
                    <textarea name="notes" rows="3" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes', optional($assessment)->notes) }}</textarea>
                    @error('notes')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Evidence files</label>
                    <input type="file" name="evidence[]" multiple class="block w-full text-sm text-gray-700 dark:text-gray-200" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Accepted: pdf, jpg, png, doc, docx, xls, xlsx. Max 10MB each.</p>
                    @error('evidence.*')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" name="save_next" value="1" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save &amp; next</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-white">Save &amp; back to list</button>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Evidence</h3>
            @if ($assessment && $assessment->evidenceFiles->count())
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($assessment->evidenceFiles as $file)
                        <li class="py-2 flex items-center justify-between text-sm text-gray-700 dark:text-gray-200">
                            <span>{{ $file->original_name }}</span>
                            <a class="text-indigo-600 dark:text-indigo-300" href="{{ Storage::url($file->file_path) }}" download>Download</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-600 dark:text-gray-300">No evidence uploaded yet.</p>
            @endif
        </div>

        @if ($nextPolicy)
            <div class="text-right">
                <a href="{{ route('questionnaire.show', $nextPolicy) }}" class="text-indigo-600 dark:text-indigo-300 text-sm">Skip to next policy ({{ $nextPolicy->code }})</a>
            </div>
        @endif
    </div>
</x-app-layout>
