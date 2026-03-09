<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Create Job Vacancy') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Post a new career opportunity for potential candidates') }}
                </p>
            </div>
            
            <a href="{{ route('job-vacancy.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Cancel') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200/60 p-8">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900">Job Vacancy Details</h3>
                    <p class="text-sm text-gray-600">Enter the job vacancy details</p>
                </div>

                <form action="{{ route('job-vacancy.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" class="font-bold text-gray-700" />
                        <x-text-input id="title" name="title" type="text" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm {{ $errors->has('title') ? 'border-rose-400 ring-rose-300 ring-1' : '' }}" 
                            :value="old('title')" 
                            placeholder="e.g. Senior Backend Developer" />
                        <x-input-error class="mt-2 text-rose-500 text-xs font-bold" :messages="$errors->get('title')" />
                    </div>

                    <!-- Location -->
                    <div>
                        <x-input-label for="location" :value="__('Location')" class="font-bold text-gray-700" />
                        <x-text-input id="location" name="location" type="text" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm {{ $errors->has('location') ? 'border-rose-400 ring-rose-300 ring-1' : '' }}" 
                            :value="old('location')" 
                            placeholder="e.g. Remote, San Francisco, CA" />
                        <x-input-error class="mt-2 text-rose-500 text-xs font-bold" :messages="$errors->get('location')" />
                    </div>

                    <!-- Expected Salary -->
                    <div>
                        <x-input-label for="salary" :value="__('Expected Salary (USD)')" class="font-bold text-gray-700" />
                        <x-text-input id="salary" name="salary" type="number" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm {{ $errors->has('salary') ? 'border-rose-400 ring-rose-300 ring-1' : '' }}" 
                            :value="old('salary')" 
                            placeholder="e.g. 120000" />
                        <x-input-error class="mt-2 text-rose-500 text-xs font-bold" :messages="$errors->get('salary')" />
                    </div>

                    <!-- Type, Company, Category -->
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Type -->
                        <div>
                            <x-input-label for="type" :value="__('Type')" class="font-bold text-gray-700" />
                            <select name="type" id="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <!-- Company -->
                        <div>
                            <x-input-label for="companyId" :value="__('Company')" class="font-bold text-gray-700" />
                            <select name="companyId" id="companyId" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">
                                <option value="" disabled selected>Select a company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('companyId') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('companyId')" />
                        </div>

                        <!-- Job Category -->
                        <div>
                            <x-input-label for="jobCategoryId" :value="__('Job Category')" class="font-bold text-gray-700" />
                            <select name="jobCategoryId" id="jobCategoryId" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">
                                <option value="" disabled selected>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('jobCategoryId') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jobCategoryId')" />
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div>
                        <x-input-label for="description" :value="__('Job Description')" class="font-bold text-gray-700" />
                        <textarea id="description" name="description" rows="5" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm {{ $errors->has('description') ? 'border-rose-400 ring-rose-300 ring-1' : '' }}">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2 text-rose-500 text-xs font-bold" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-indigo-100">
                            {{ __('Publish Job Vacancy') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
