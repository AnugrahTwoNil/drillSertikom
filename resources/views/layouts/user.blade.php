<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Workshop') | Workshop Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#FBF9F1]">

    <!-- Navbar -->
    <nav x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-40 print:hidden">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ url('/') }}" class="text-lg font-extrabold text-gray-800">
                        Workshop Sekolah<span class="text-yellow-400">.</span>
                    </a>
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('workshops.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-semibold transition
                           {{ request()->routeIs('workshops.*') ? 'bg-yellow-400 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
                            Workshop
                        </a>
                        <a href="{{ route('registrations.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-semibold transition
                           {{ request()->routeIs('registrations.*') ? 'bg-yellow-400 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
                            Pendaftaran Saya
                        </a>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-4">
                    <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-700 transition cursor-pointer">
                            Log Out
                        </button>
                    </form>
                </div>

                <button type="button" @click="open = !open" class="md:hidden text-gray-700 text-xl">
                    <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" x-cloak x-transition class="md:hidden border-t border-gray-100 px-4 py-3 space-y-1">
            <a href="{{ route('workshops.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100">Workshop</a>
            <a href="{{ route('registrations.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100">Pendaftaran Saya</a>
            <div class="pt-3 mt-2 border-t border-gray-100">
                <p class="px-3 text-sm font-semibold text-gray-800 mb-3">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-700 transition cursor-pointer">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div
        class="min-h-[200px] flex flex-col items-center justify-center text-center px-4 print:hidden"
    >
        <h1 class="text-[2.25rem] font-bold mb-2 text-gray-800 leading-tight">@yield('title')</h1>
        <p class="text-gray-600 text-[16px] max-w-xl">@yield('subtitle')</p>
    </div>

    <!-- Flash messages -->
    <div class="max-w-4xl mx-auto px-4 mt-6 print:hidden">
        @if (session('message'))
            <div class="mb-4 rounded-lg bg-yellow-100 text-yellow-800 px-4 py-3 text-sm">{{ session('message') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif
    </div>

    <!-- Content -->
    <main class="max-w-4xl mx-auto px-4 mt-6 mb-20">
        @yield('content')
    </main>

</body>
</html>