<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('job-vacancy.index') }}" class="p-2 bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                        {{ $vacancy->title }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        <a href="{{ route('company.show', $vacancy->company) }}" class="font-bold text-indigo-600 hover:text-red-600 transition-colors">{{ $vacancy->company->name }}</a> &bull; {{ $vacancy->location }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('job-vacancy.edit', $vacancy) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Vacancy') }}
                </a>
                
                <form action="{{ route('job-vacancy.destroy', $vacancy) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this vacancy?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-semibold text-xs uppercase tracking-widest hover:bg-rose-100 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('Archive') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Details -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Info Card -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200/60 transition-all hover:shadow-md">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-bold text-gray-900 border-l-4 border-indigo-500 pl-4">Vacancy Details</h3>
                            <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold border border-indigo-100">
                                {{ $vacancy->type }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div class="space-y-1">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Category</span>
                                <div class="flex items-center text-gray-700 font-semibold">
                                    <svg class="w-5 h-5 mr-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    {{ $vacancy->jobCategory->name ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Offered Salary</span>
                                <div class="flex items-center text-emerald-600 font-bold text-lg">
                                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ is_numeric($vacancy->salary) ? '$' . number_format($vacancy->salary, 2) : $vacancy->salary }}
                                </div>
                            </div>
                        </div>

                        <div class="prose max-w-none text-gray-600 leading-relaxed pt-6 border-t border-gray-100">
                            <h4 class="text-gray-900 font-bold mb-4">Description</h4>
                            {!! nl2br(e($vacancy->description)) !!}
                        </div>
                    </div>

                    <!-- Applications Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200/60">
                        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                            <h3 class="text-lg font-bold text-gray-900">Recent Applications</h3>
                            <span class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-500">
                                {{ $vacancy->jobApplications->count() }} Total
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-white">
                                    <tr>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Applicant</th>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Date Applied</th>
                                        <th class="px-8 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($vacancy->jobApplications as $application)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-8 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                                        {{ substr($application->user->name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-bold text-gray-900">{{ $application->user->name }}</div>
                                                        <div class="text-xs text-gray-500">{{ $application->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                                                {{ $application->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold 
                                                    {{ $application->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                                                    {{ $application->status === 'accepted' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                                    {{ $application->status === 'rejected' ? 'bg-rose-50 text-rose-700 border border-rose-100' : '' }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-8 py-12 text-center text-gray-400 text-sm italic">
                                                No applications received yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Company Sidebar -->
                <div class="space-y-8">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200/60 sticky top-8">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">About the Company</div>
                        
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-indigo-600 rounded-2xl mx-auto flex items-center justify-center text-white text-3xl font-bold shadow-xl shadow-indigo-200 mb-4">
                                {{ substr($vacancy->company->name, 0, 1) }}
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">{{ $vacancy->company->name }}</h4>
                            <span class="text-sm text-gray-500">{{ $vacancy->company->industry }}</span>
                        </div>

                        <div class="space-y-4 pt-6 border-t border-gray-50">
                            <div class="flex items-start gap-4">
                                <div class="p-2 bg-gray-50 rounded-lg text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-gray-400 uppercase">Headquarters</div>
                                    <div class="text-sm text-gray-700 font-medium">{{ $vacancy->company->address }}</div>
                                </div>
                            </div>

                            @if($vacancy->company->website)
                                <div class="flex items-start gap-4">
                                    <div class="p-2 bg-gray-50 rounded-lg text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9h18"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-gray-400 uppercase">Website</div>
                                        <a href="{{ $vacancy->company->website }}" target="_blank" class="text-sm text-indigo-600 font-bold hover:underline">
                                            Visit Site
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="pt-6">
                                <a href="{{ route('company.show', $vacancy->company) }}?tab=jobs" class="w-full flex items-center justify-center px-4 py-3 bg-indigo-50 text-indigo-700 rounded-xl text-sm font-bold hover:bg-indigo-100 transition-all border border-indigo-100">
                                    View Company Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
