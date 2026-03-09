<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('company.update', $company->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="company_owner_id" value="{{ $company->ownerId }}">

                <!-- Company Details Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 mb-6">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Company Details</h3>
                        <p class="text-sm text-gray-600">Enter the company details</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Company Name -->
                        <div>
                            <x-input-label for="name" :value="__('Company Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $company->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $company->address)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <!-- Industry -->
                        <div>
                            <x-input-label for="industry" :value="__('Industry')" />
                            <select name="industry" id="industry" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry }}" {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>{{ $industry }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('industry')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Company Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $company->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Website -->
                        <div>
                            <x-input-label for="website" :value="__('Website (optional)')" />
                            <x-text-input id="website" name="website" type="text" class="mt-1 block w-full" :value="old('website', $company->website)" />
                            <x-input-error class="mt-2" :messages="$errors->get('website')" />
                        </div>
                    </div>
                </div>

                <!-- Company Owner Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 mb-6">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Company Owner</h3>
                        <p class="text-sm text-gray-600">Enter the company owner details</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Owner Name -->
                        <div>
                            <x-input-label for="owner_name" :value="__('Owner Name')" />
                            <x-text-input id="owner_name" name="owner_name" type="text" class="mt-1 block w-full" :value="old('owner_name', $company->owner->name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('owner_name')" />
                        </div>

                        <!-- Owner Email -->
                        <div>
                            <x-input-label for="owner_email" :value="__('Owner Email')" />
                            <x-text-input id="owner_email" name="owner_email" type="email" class="mt-1 block w-full" :value="old('owner_email', $company->owner->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('owner_email')" />
                        </div>

                        <!-- Owner Password -->
                        <div x-data="{ show: false }" class="relative">
                            <x-input-label for="owner_password" :value="__('Change Owner Password (Leave blank to keep the same)')" />
                            <x-text-input id="owner_password" name="owner_password" ::type="show ? 'text' : 'password'" class="mt-1 block w-full pr-10" />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center mt-6 text-gray-400 hover:text-gray-600">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.888 9.888L3 3m18 18l-6.89-6.89" />
                                </svg>
                            </button>
                            <x-input-error class="mt-2" :messages="$errors->get('owner_password')" />
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end items-center space-x-4">
                    <a href="{{ route('company.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                        {{ __('Update Company') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
