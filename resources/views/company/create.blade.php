<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('New Company Partnership') }}
            </h2>
            <a href="{{ route('company.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center transition-colors font-medium">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('company.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Section: Company Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 bg-gray-50/30">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ __('Company Details') }}</h3>
                        </div>
                        <p class="text-sm text-gray-500 ml-10">{{ __('Enter the core information for the partner company.') }}</p>
                    </div>

                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div class="space-y-1">
                                <x-input-label for="name" :value="__('Company Name')" class="text-xs font-bold uppercase tracking-wider text-gray-500" />
                                <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name')" required placeholder="e.g. Acme Corp" />
                                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                            </div>

                            <!-- Industry -->
                            <div class="space-y-1">
                                <x-input-label for="industry" :value="__('Industry')" class="text-xs font-bold uppercase tracking-wider text-gray-500" />
                                <select id="industry" name="industry" class="block w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all duration-200">
                                    <option value="" disabled {{ old('industry') ? '' : 'selected' }}>Select Industry</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry }}" {{ old('industry') == $industry ? 'selected' : '' }}>{{ $industry }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('industry')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="space-y-1">
                            <x-input-label for="address" :value="__('Business Address')" class="text-xs font-bold uppercase tracking-wider text-gray-500" />
                            <x-text-input id="address" name="address" type="text" class="block w-full" :value="old('address')" required placeholder="Full physical address" />
                            <x-input-error :messages="$errors->get('address')" class="mt-1" />
                        </div>

                        <!-- Description -->
                        <div class="space-y-1">
                            <x-input-label for="description" :value="__('Company Description')" class="text-xs font-bold uppercase tracking-wider text-gray-500" />
                            <textarea id="description" name="description" rows="4" class="block w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all duration-200" required placeholder="Describe what the company does...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-1" />
                        </div>

                        <!-- Website -->
                        <div class="space-y-1">
                            <x-input-label for="website" :value="__('Website URL')" class="text-xs font-bold uppercase tracking-wider text-gray-500" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                </div>
                                <x-text-input id="website" name="website" type="text" class="block w-full pl-10" :value="old('website')" placeholder="https://www.example.com" />
                            </div>
                            <x-input-error :messages="$errors->get('website')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Section: Company Owner -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 bg-gray-50/30">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ __('Owner Account') }}</h3>
                        </div>
                        <p class="text-sm text-gray-500 ml-10">{{ __('Create a secure login for the company representative.') }}</p>
                    </div>

                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Owner Name -->
                            <div class="space-y-1">
                                <x-input-label for="owner_name" :value="__('Full Name')" class="text-xs font-bold uppercase tracking-wider text-gray-500" />
                                <x-text-input id="owner_name" name="owner_name" type="text" class="block w-full" :value="old('owner_name')" required placeholder="Name of primary contact" />
                                <x-input-error :messages="$errors->get('owner_name')" class="mt-1" />
                            </div>

                            <!-- Owner Email -->
                            <div class="space-y-1">
                                <x-input-label for="owner_email" :value="__('Email Address')" class="text-xs font-bold uppercase tracking-wider text-gray-500" />
                                <x-text-input id="owner_email" name="owner_email" type="email" class="block w-full" :value="old('owner_email')" required placeholder="contact@company.com" />
                                <x-input-error :messages="$errors->get('owner_email')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Owner Password -->
                        <div class="space-y-1">
                            <x-input-label for="owner_password" :value="__('Account Password')" class="text-xs font-bold uppercase tracking-wider text-gray-500" />
                            <div x-data="{ show: false }" class="relative">
                                <x-text-input id="owner_password" name="owner_password" ::type="show ? 'text' : 'password'" class="block w-full pr-10" required />
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.888 9.888L3 3m18 18l-6.89-6.89" /></svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('owner_password')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 p-4">
                    <a href="{{ route('company.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition-colors">
                        {{ __('Discard Changes') }}
                    </a>
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-100 hover:shadow-blue-200 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __('Add Company') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
