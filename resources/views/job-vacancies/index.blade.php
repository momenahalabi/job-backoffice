<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Job Vacancies') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Manage and publish your job opportunities') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('job-vacancy.archived') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-200 text-xs font-semibold uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    {{ __('View Archive') }}
                </a>

                <a href="{{ route('job-vacancy.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-lg shadow-indigo-100 hover:shadow-indigo-200 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Add Job Vacancy') }}
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
                                    {{ __('Title') }}
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Company') }}
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Location') }}
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Type') }}
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Salary') }}
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($vacancies as $vacancy)
                                <tr>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <a href="{{ route('job-vacancy.show', $vacancy) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-900">
                                            {{ $vacancy->title }}
                                        </a>
                                    </td>
                                     <td class="px-6 py-5 whitespace-nowrap text-sm">
                                         @if($vacancy->company)
                                             <a href="{{ route('company.show', $vacancy->company) }}" class="font-bold text-indigo-600 hover:text-red-600 transition-colors">
                                                 {{ $vacancy->company->name }}
                                             </a>
                                         @else
                                             <span class="text-gray-400 italic">--</span>
                                         @endif
                                     </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $vacancy->location }}</div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $vacancy->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ is_numeric($vacancy->salary) ? '$' . number_format($vacancy->salary, 2) : $vacancy->salary }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('job-vacancy.edit', $vacancy) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg transition-all text-xs font-bold border border-indigo-100">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                {{ __('Edit') }}
                                            </a>

                                            <!-- Archive -->
                                            <form action="{{ route('job-vacancy.destroy', $vacancy) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to archive this job vacancy?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg transition-all text-xs font-bold border border-rose-100">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    {{ __('Archive') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="p-4 bg-gray-50 rounded-full mb-4">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">{{ __('No job vacancies found.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>
                </div>

                @if($vacancies->hasPages())
                    <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-100">
                        {{ $vacancies->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
