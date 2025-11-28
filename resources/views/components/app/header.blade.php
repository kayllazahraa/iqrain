<header class="sticky top-0 bg-white z-30 border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-18">

            {{-- Hamburger button (Mobile) --}}
            <div class="flex lg:hidden">
                <button
                    class="text-gray-500 hover:text-gray-600"
                    @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <rect y="4" width="24" height="2" rx="1" />
                        <rect y="11" width="24" height="2" rx="1" />
                        <rect y="18" width="24" height="2" rx="1" />
                    </svg>
                </button>
            </div>

            <div class="flex items-center flex-1 lg:flex-initial"></div>

            <div class="flex items-center space-x-3">
                @livewire('notifications.notification-dropdown')
                <hr class="w-px h-6 bg-gray-200 border-none" />
                <x-dropdown-profile align="right" />
            </div>

        </div>
    </div>
</header>
