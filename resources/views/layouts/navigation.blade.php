<nav class="w-[250px] bg-white h-screen border-r border-gray-200">
    <!-- Logo Section -->
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-8 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800"> {{ __('Shaghalni') }}</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <ul class="flex flex-col px-4 py-6 space-y-2">
        @if (auth()->user()->role == 'company-owner' || auth()->user()->role == 'admin')
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>
        @endif

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('company.index')" :active="request()->routeIs('company.*')">
                {{ __('Companies') }}
            </x-nav-link>
        @endif

        @if (auth()->user()->role == 'company-owner' && auth()->user()->company)
            <x-nav-link :href="route('company.show', auth()->user()->company)" :active="request()->routeIs('company.show') && (request()->route('company') instanceof \App\Models\Company ? request()->route('company')->id : request()->route('company')) == auth()->user()->company->id">
                {{ __('My Company') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('application.index')" :active="request()->routeIs('application.*')">
            {{ __('Job Applications') }}
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.*')">
                {{ __('Job Categories') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-vacancy.index')" :active="request()->routeIs('job-vacancy.*')">
            {{ __('Job Vacancies') }}
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.*')">
                {{ __('Users') }}
            </x-nav-link>
        @endif

        <hr class="my-4 border-gray-100" />
        
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center px-4 py-2 w-full text-sm font-medium text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition duration-150 ease-in-out">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Log Out') }}
            </button>
        </form>
    </ul>
</nav>