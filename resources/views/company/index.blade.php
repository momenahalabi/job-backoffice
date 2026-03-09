<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Companies Management') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Manage your active partner companies') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                @if(auth()->user()->role == 'admin')
                <a href="{{ route('companies.archived') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-200 text-xs font-semibold uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    {{ __('View Archive') }}
                </a>
                @endif

                <a href="{{ route('company.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-lg shadow-indigo-100 hover:shadow-indigo-200 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Add New Company') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Messages --> 
            @if (session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     x-init="setTimeout(() => show = false, 4000)"
                     class="mb-6 p-4 bg-white border-l-4 border-green-500 shadow-sm rounded-r-xl flex items-center justify-between" 
                     role="alert">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-full mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ __('Success') }}</p>
                            <p class="text-xs text-gray-600">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
                                         
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200/60">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Company Info') }}
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Industry') }}
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    {{ __('Website') }}
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($companies as $company)
                                <tr>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 font-bold text-lg">
                                                {{ substr($company->name, 0, 1) }}
                                            </div>
                                             <div class="ml-4">
                                                 <a href="{{ route('company.show', $company) }}" class="text-sm font-bold text-indigo-600 hover:text-red-600 transition-colors">
                                                     {{ $company->name }}
                                                 </a>
                                                 <div class="text-xs text-gray-500">{{ $company->address }}</div>
                                             </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $company->industry ?? __('N/A') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap hidden md:table-cell">
                                        @if($company->website)
                                            <a href="{{ $company->website }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-900 flex items-center group/link">
                                                <span class="truncate max-w-[150px]">{{ preg_replace('(^https?://)', '', $company->website) }}</span>
                                                <svg class="w-3 h-3 ml-1 opacity-0 group-hover/link:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic">--</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('company.edit', $company) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg transition-all text-xs font-bold border border-indigo-100">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                {{ __('Edit') }}
                                            </a>

                                            @if(auth()->user()->role == 'admin')
                                            <!-- Archive -->
                                            <form action="{{ route('company.destroy', $company) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to archive this company?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg transition-all text-xs font-bold border border-rose-100">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    {{ __('Archive') }}
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="p-4 bg-gray-50 rounded-full mb-4">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">{{ __('No companies found.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>
                </div>

                @if($companies->hasPages())
                    <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-100">
                        {{ $companies->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
