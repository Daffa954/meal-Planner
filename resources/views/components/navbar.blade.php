<nav x-data="{ open: false }" class="bg-white shadow-md p-[8px]">
    @php
        $currentRoute = request()->route()->getName();
        
        $navigation = [

        ];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <img class="h-24 w-auto" src="{{ asset('images/logo-nobg.png') }}" alt="Logo">
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex space-x-8">
                @foreach($navigation as $item)
                    <a
                        href="{{ $item['href'] }}"
                        class="{{ $currentRoute === $item['route'] ? 'text-[#7B5E3C] font-semibold' : 'text-gray-600 hover:text-[#9C7248]' }} transition text-lg px-3 py-2"
                    >
                        {{ $item['name'] }}
                    </a>
                @endforeach
            </div>

            <!-- Desktop Buttons -->
            <div class="hidden md:flex space-x-4">
                <a href="{{ route('login') }}" class="bg-[#7B5E3C] text-white px-6 py-2 rounded-lg hover:bg-[#9C7248] transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="border border-[#7B5E3C] text-[#7B5E3C] px-6 py-2 rounded-lg hover:bg-[#FCD47F]/20 transition">
                    Register
                </a>
            </div>

            <!-- Mobile Button -->
            <div class="md:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center rounded-md p-2 text-[#7B5E3C] border-2 border-[#7B5E3C] hover:bg-[#FCD47F]/10">
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="md:hidden px-4 pt-4 pb-6 space-y-4 bg-white border-t">
        @foreach($navigation as $item)
            <a
                href="{{ $item['href'] }}"
                class="{{ $currentRoute === $item['route'] ? 'text-[#7B5E3C] font-semibold' : 'text-gray-600 hover:text-[#9C7248]' }} block text-base"
            >
                {{ $item['name'] }}
            </a>
        @endforeach
        <div class="pt-4 space-y-3">
            <a href="{{ route('login') }}" class="w-full bg-[#7B5E3C] text-white px-4 py-2 rounded-lg hover:bg-[#9C7248] block text-center">
                Login
            </a>
            <a href="{{ route('register') }}" class="w-full border border-[#7B5E3C] text-[#7B5E3C] px-4 py-2 rounded-lg hover:bg-[#FCD47F]/10 block text-center">
                Register
            </a>
        </div>
    </div>
</nav>