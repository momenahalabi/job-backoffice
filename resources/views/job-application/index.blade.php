<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $isArchived ?? false ? __('Archived Job Applications') : __('Job Applications') }}
            </h2>
            <div class="flex gap-2">
                @if(!($isArchived ?? false))
                    <a href="{{ route('application.archived') }}" class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-all duration-200">
                        {{ __('Archived Job Applications') }}
                    </a>
                @else
                    <a href="{{ route('application.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200">
                        {{ __('Active Job Applications') }}
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4">{{ __('Applicant Name') }}</th>
                                <th class="px-6 py-4">{{ __('Position (Job Vacancy)') }}</th>
                                @if(auth()->user()->role == 'admin')
                                <th class="px-6 py-4">{{ __('Company') }}</th>
                                @endif
                                <th class="px-6 py-4 text-center">{{ __('Status') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($jobApplications as $application)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($application->user)
                                            <a href="{{ route('user.show', $application->user) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                                {{ $application->user->name }}
                                            </a>
                                        @else
                                            <span class="text-sm text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($application->jobVacancy)
                                            <a href="{{ route('job-vacancy.show', $application->jobVacancy) }}" class="text-sm text-indigo-600 font-medium hover:text-indigo-800 transition-colors">
                                                {{ $application->jobVacancy->title }}
                                            </a>
                                        @else
                                            <span class="text-sm text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    @if(auth()->user()->role == 'admin')
                                     <td class="px-6 py-4 whitespace-nowrap">
                                         @if($application->jobVacancy && $application->jobVacancy->company)
                                             <a href="{{ route('company.show', $application->jobVacancy->company) }}" class="text-sm text-indigo-600 font-medium hover:text-red-600 transition-colors">
                                                 {{ $application->jobVacancy->company->name }}
                                             </a>
                                         @else
                                            <span class="text-sm text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'text-purple-600 font-semibold',
                                                'accepted' => 'text-green-600 font-semibold',
                                                'rejected' => 'text-red-600 font-semibold',
                                            ];
                                            $currentStatusClass = $statusClasses[strtolower($application->status)] ?? 'text-gray-600';
                                        @endphp
                                        <span class="text-xs {{ $currentStatusClass }}">
                                            {{ strtolower($application->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                            @if(!($isArchived ?? false))
                                                <a href="{{ route('application.edit', $application) }}" class="text-orange-500 hover:text-orange-700 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                    {{ __('Edit') }}
                                                </a>
                                                <form action="{{ route('application.destroy', $application) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to archive this application?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                        </svg>
                                                        {{ __('Archive') }}
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('application.restore', $application) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                        </svg>
                                                        {{ __('Restore') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role == 'admin' ? 5 : 4 }}" class="px-6 py-10 text-center text-gray-500 bg-gray-50/20">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 17.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">{{ __('No job applications found.') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if ($jobApplications->hasPages())
                    <div class="p-6 bg-gray-50 border-t border-gray-100">
                        {{ $jobApplications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
