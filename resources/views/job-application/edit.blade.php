<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Job Application') }}
            </h2>
            <a href="{{ route('application.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Applicant Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 mb-6">
                <div class="p-6 border-b border-gray-100 flex items-center gap-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xl uppercase">
                        {{ substr($jobApplication->user->name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $jobApplication->user->name ?? 'Unknown Applicant' }}</h3>
                        <p class="text-sm text-gray-500">{{ __('Applied for') }} <span class="font-medium text-gray-700">{{ $jobApplication->jobVacancy->title ?? 'N/A' }}</span> at <span class="font-medium text-gray-700">{{ $jobApplication->jobVacancy->company->name ?? 'N/A' }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <form method="POST" action="{{ route('application.update', $jobApplication) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Application Status')" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                                    <option value="pending" {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <!-- AI Score -->
                            <div>
                                <x-input-label for="aiGeneratedScore" :value="__('AI Score (0-100)')" />
                                <x-text-input id="aiGeneratedScore" name="aiGeneratedScore" type="number" class="mt-1 block w-full" :value="old('aiGeneratedScore', $jobApplication->aiGeneratedScore)" min="0" max="100" />
                                <x-input-error class="mt-2" :messages="$errors->get('aiGeneratedScore')" />
                            </div>
                        </div>

                        <!-- Feedback -->
                        <div>
                            <x-input-label for="aiGeneratedFeedback" :value="__('Internal Feedback / AI Feedback')" />
                            <textarea id="aiGeneratedFeedback" name="aiGeneratedFeedback" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">{{ old('aiGeneratedFeedback', $jobApplication->aiGeneratedFeedback) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('aiGeneratedFeedback')" />
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all transform active:scale-95 duration-200">
                                {{ __('Update Application') }}
                            </button>
                            <a href="{{ route('application.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
