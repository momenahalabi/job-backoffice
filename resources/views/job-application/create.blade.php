<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Job Application') }}
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <form method="POST" action="{{ route('application.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- User Selection -->
                            <div>
                                <x-input-label for="userId" :value="__('Select Applicant')" />
                                <select id="userId" name="userId" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                                    <option value="">{{ __('Select a user') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('userId') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('userId')" />
                            </div>

                            <!-- Vacancy Selection -->
                            <div>
                                <x-input-label for="jobVacancyId" :value="__('Select Job Vacancy')" />
                                <select id="jobVacancyId" name="jobVacancyId" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                                    <option value="">{{ __('Select a vacancy') }}</option>
                                    @foreach($vacancies as $vacancy)
                                        <option value="{{ $vacancy->id }}" {{ old('jobVacancyId') == $vacancy->id ? 'selected' : '' }}>{{ $vacancy->title }} - {{ $vacancy->company->name ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jobVacancyId')" />
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Initial Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all transform active:scale-95 duration-200">
                                {{ __('Create Application') }}
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
