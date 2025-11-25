<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Policy {{ $policy->code }}</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $policy->title }}</h2>
            </div>
            <a href="{{ route('policies.index') }}" class="text-indigo-600 dark:text-indigo-300 text-sm">&larr; Back to policies</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <p class="text-gray-700 dark:text-gray-300">{{ $policy->short_description }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Assessment</h3>
                @if(session('success'))
                    <span class="text-green-600 text-sm">{{ session('success') }}</span>
                @endif
            </div>

            @if ($assessment)
                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded">
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        Last status: <strong>{{ ucfirst(str_replace('_', ' ', $assessment->status)) }}</strong>
                    </div>
                    @if ($assessment->notes)
                        <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">Notes: {{ $assessment->notes }}</div>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('policies.assess', $policy) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status</label>
                    <select name="status" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                        @php
                            $options = [
                                'compliant' => 'Compliant',
                                'partial' => 'Partially compliant',
                                'non_compliant' => 'Non-compliant',
                                'not_applicable' => 'Not applicable',
                            ];
                        @endphp
                        @foreach ($options as $value => $label)
                            <option value="{{ $value }}" @selected(optional($assessment)->status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
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

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save assessment</button>
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
    </div>
</x-app-layout>
