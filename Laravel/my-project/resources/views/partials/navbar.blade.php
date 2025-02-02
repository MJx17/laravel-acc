<nav class="bg-gray-900 text-white p-4 shadow-md">
    <div class="navbar">
    <div class="flex items-center justify-between">
        <!-- Left side links -->
        <div class="flex items-center space-x-4">
            <!-- Sidebar toggle button -->
            <button class="text-white" id="sidebar-toggle-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8M4 18h12"></path>
                </svg>
            </button>
            <div class="text-xl font-semibold">{{ __('Dashboard') }}</div>
        </div>
       
        <!-- Right side profile and other buttons -->
        <div class="hidden md:flex items-center space-x-4">
            <a href="{{ route('profile.edit') }}" class="hover:bg-gray-700 px-4 py-2 rounded">{{ __('Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:bg-gray-700 px-4 py-2 rounded">{{ __('Log Out') }}</button>
            </form>
        </div>
    </div>
    </div>
</nav>
