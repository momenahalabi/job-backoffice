<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('user.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200">
                    {{ __('Edit User') }}
                </a>
                <a href="{{ route('user.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">{{ __('Basic Information') }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase">{{ __('Name') }}</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase">{{ __('Email') }}</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase">{{ __('Role') }}</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $user->role ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">{{ __('Account Status') }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase">{{ __('Created At') }}</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase">{{ __('Last Updated') }}</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                                @if($user->trashed())
                                    <div>
                                        <label class="block text-xs font-medium text-red-500 uppercase">{{ __('Archived At') }}</label>
                                        <p class="text-sm text-red-600 font-medium">{{ $user->deleted_at->format('M d, Y H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
