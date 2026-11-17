<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Workshop Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="text-[#4F545C]" x-data="{ sidebar: false }">

    <!-- Mobile top bar -->
    <div class="md:hidden flex items-center justify-between bg-[#4F545C] px-4 py-3">
        <h1 class="text-[#FEF9C3] text-lg font-semibold">Workshop Sekolah</h1>
        <button type="button" @click="sidebar = true" class="text-[#FEF9C3] text-xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Mobile overlay -->
    <div x-show="sidebar" x-cloak x-transition.opacity
         class="fixed inset-0 z-30 bg-[#4F545C]/40 md:hidden"
         @click="sidebar = false"></div>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-40 w-64 bg-[#1f2937] flex flex-col transition-transform duration-300 md:translate-x-0"
        :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="px-6 py-6 flex items-center justify-between">
            <h1 class="text-lg font-semibold text-[#FEF9C3]">Workshop Sekolah</h1>
            <button type="button" class="md:hidden text-[#C9C6BB] hover:text-[#FEF9C3]" @click="sidebar = false">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <p class="px-6 text-xs font-medium text-[#B5B2A6] uppercase tracking-wider mb-2">Menu</p>

        <nav class="flex-1 px-3 space-y-1">
            <a href="{{ route('adminDashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
               {{ request()->routeIs('adminDashboard') ? 'bg-yellow-200 text-[#4F545C]' : 'text-[#E4E1D3] hover:bg-[#5E636B]' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                Dashboard
            </a>
        
            <a href="{{ route('adminWorkshop.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
               {{ request()->routeIs('adminWorkshop.index') || request()->routeIs('adminWorkshop.index') ? 'bg-yellow-200 text-[#4F545C]' : 'text-[#E4E1D3] hover:bg-[#5E636B]' }}">
                <i class="fa-solid fa-table-list"></i>
                List Workshop
            </a>

            <a href="{{ route('adminWorkshop.create') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
               {{ request()->routeIs('adminWorkshop.create') ? 'bg-yellow-200 text-[#4F545C]' : 'text-[#E4E1D3] hover:bg-[#5E636B]' }}">
                <i class="fa-solid fa-plus w-5 text-center"></i>
                Tambah Workshop
            </a>
        </nav>

        <!-- User + logout -->
        <div class="px-4 py-4 border-t border-[#5E636B]">
            <p class="text-sm font-medium text-[#FEF9C3] truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-[#B5B2A6] mb-3">Admin</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-[#5E636B] text-[#FEF9C3] px-4 py-2 rounded-lg font-medium text-sm hover:bg-[#6A6F77] transition cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket mr-1"></i> Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <main class="md:ml-64 min-h-screen p-6 md:p-10">
        @if (session('message') || session('success'))
            <div class="mb-6 rounded-lg bg-yellow-100 border border-yellow-200 text-[#4F545C] px-4 py-3 text-sm">
                {{ session('message') ?? session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded-lg bg-red-100 border border-red-200 text-red-800 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>