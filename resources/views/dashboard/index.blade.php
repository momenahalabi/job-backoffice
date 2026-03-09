<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Analytics') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Active Users -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-start transition-all hover:shadow-md">
                    <span class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">{{ __('Active Applicants') }}</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-blue-600 tracking-tight">{{ $stats['active_users'] }}</span>
                    </div>
                    <span class="text-xs text-gray-400 mt-2 flex items-center">
                        {{ __('Last 30 days') }}
                    </span>
                </div>

                <!-- Active Job Postings -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-start transition-all hover:shadow-md">
                    <span class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">{{ __('Active Job Postings') }}</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-indigo-600 tracking-tight">{{ $stats['active_job_postings'] }}</span>
                    </div>
                    <span class="text-xs text-gray-400 mt-2 flex items-center">
                        {{ __('Currently active') }}
                    </span>
                </div>

                <!-- Total Applications -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-start transition-all hover:shadow-md">
                    <span class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">{{ __('Total Applications') }}</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-purple-600 tracking-tight">{{ $stats['total_applications'] }}</span>
                    </div>
                    <span class="text-xs text-gray-400 mt-2 flex items-center">
                        {{ __('All time') }}
                    </span>
                </div>
            </div>

            <!-- Most Applied Jobs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">{{ __('Most Applied Jobs') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                <th class="px-8 py-4">{{ __('Job Title') }}</th>
                                @if(auth()->user()->role == 'admin')
                                <th class="px-8 py-4">{{ __('Company') }}</th>
                                @endif
                                <th class="px-8 py-4 text-center">{{ __('Applications') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mostAppliedJobs as $job)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-8 py-5 text-sm font-semibold text-gray-800">
                                        <a href="{{ route('job-vacancy.show', $job->id) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                            {{ $job->title }}
                                        </a>
                                    </td>
                                    @if(auth()->user()->role == 'admin')
                                     <td class="px-8 py-5 text-sm text-gray-600 font-medium">
                                         @if($job->company)
                                             <a href="{{ route('company.show', $job->company->id) }}" class="text-indigo-600 hover:text-red-600 transition-colors">
                                                 {{ $job->company->name }}
                                             </a>
                                         @else
                                            N/A
                                        @endif
                                    </td>
                                    @endif
                                    <td class="px-8 py-5 text-center">
                                        <span class="text-sm font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded-full">{{ $job->job_applications_count }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role == 'admin' ? 3 : 2 }}" class="px-8 py-10 text-center text-gray-400 text-sm font-medium italic">
                                        {{ __('No job postings with applications found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Converting Jobs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">{{ __('Top Converting Job Posts') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                <th class="px-8 py-4">{{ __('Job Title') }}</th>
                                <th class="px-8 py-4 text-center">{{ __('Views') }}</th>
                                <th class="px-8 py-4 text-center">{{ __('Applications') }}</th>
                                <th class="px-8 py-4 text-right pr-8">{{ __('Conversion Rate') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($topConvertingJobs as $job)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-8 py-5 text-sm font-semibold text-gray-800">
                                        <a href="{{ route('job-vacancy.show', $job->id) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                            {{ $job->title }}
                                        </a>
                                    </td>
                                    <td class="px-8 py-5 text-center text-sm font-medium text-gray-500">{{ $job->views }}</td>
                                    <td class="px-8 py-5 text-center text-sm font-medium text-gray-500">{{ $job->job_applications_count }}</td>
                                    <td class="px-8 py-5 text-right pr-8">
                                        <div class="flex items-center justify-end font-bold text-green-600">
                                            <span>{{ number_format($job->conversion_rate, 1) }}%</span>
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-gray-400 text-sm font-medium italic">
                                        {{ __('No performance data available yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
