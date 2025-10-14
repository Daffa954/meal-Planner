<nav x-data="{ open: false, dropdownOpen: false }" class="bg-white shadow-md p-[8px]">
    @php
        $currentRoute = request()->route()->getName();
        
        $navigation = [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'href' => route('dashboard')],
            ['name' => 'Meal Plans', 'route' => 'meal-plans', 'href' => route('meal-plans.index')],
            ['name' => 'Anak Saya', 'route' => 'children', 'href' => route('children.index')],
            ['name' => 'Resep Saya', 'route' => 'favorites', 'href' => route('recipes.index')],
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <img class="h-20 w-auto" src="{{ asset('images/logo-nobg.png') }}" alt="Logo">
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex space-x-8">
                @foreach ($navigation as $item)
                    <a href="{{ $item['href'] }}"
                        class="{{ $currentRoute === $item['route'] ? 'text-[#7B5E3C] font-semibold border-b-2 border-[#7B5E3C]' : 'text-gray-600 hover:text-[#9C7248]' }} transition text-lg px-3 py-2">
                        {{ $item['name'] }}
                    </a>
                @endforeach
            </div>

            <!-- User Menu Desktop -->
            <div class="hidden md:flex items-center space-x-4">
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="flex items-center space-x-2 text-gray-700 hover:text-[#7B5E3C] transition">
                        <div class="w-8 h-8 bg-[#7B5E3C] rounded-full flex items-center justify-center text-white text-sm font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="font-medium">Hi, {{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                             class="bi bi-chevron-down transition-transform" 
                             :class="{ 'rotate-180': dropdownOpen }" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="dropdownOpen" 
                         @click.away="dropdownOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                            📝 Edit Profil
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                            ⚙️ Pengaturan
                        </a>
                        <div class="border-t border-gray-200 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Button -->
            <div class="md:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-[#7B5E3C] border-2 border-[#7B5E3C] hover:bg-[#FCD47F]/10 transition">
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden px-4 pt-4 pb-6 space-y-4 bg-white border-t">
        
        <!-- User Info Mobile -->
        <div class="flex items-center space-x-3 pb-4 border-b border-gray-200">
            <div class="w-10 h-10 bg-[#7B5E3C] rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-medium text-gray-900">Hi, {{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Navigation Links Mobile -->
        @foreach ($navigation as $item)
            <a href="{{ $item['href'] }}"
                class="{{ $currentRoute === $item['route'] ? 'text-[#7B5E3C] font-semibold bg-[#FCD47F]/10' : 'text-gray-600 hover:text-[#9C7248]' }} block text-base py-2 px-3 rounded-lg transition">
                {{ $item['name'] }}
            </a>
        @endforeach

        <!-- Additional Mobile Menu Items -->
        <div class="pt-2 space-y-2 border-t border-gray-200">
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center space-x-2 text-gray-600 hover:text-[#7B5E3C] transition py-2 px-3 rounded-lg">
                <span>📝</span>
                <span>Edit Profil</span>
            </a>
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center space-x-2 text-gray-600 hover:text-[#7B5E3C] transition py-2 px-3 rounded-lg">
                <span>⚙️</span>
                <span>Pengaturan</span>
            </a>
        </div>

        <!-- Logout Button Mobile -->
        <div class="pt-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center justify-center space-x-2 bg-red-50 text-red-600 px-4 py-3 rounded-lg hover:bg-red-100 transition font-medium">
                    <span>🚪</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>