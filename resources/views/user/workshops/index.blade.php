@extends('layouts.user')

@section('title', 'WorkshopTix')
@section('subtitle', 'Pantau status pembayaran dan buka tiket workshop kamu di sini.')

@section('content')
    <!-- Top bar -->

    <!-- Flash messages -->
    <div class="max-w-6xl mx-auto px-4 mt-6">
        @if (session('message'))
            <div class="mb-4 rounded-lg bg-yellow-100 text-yellow-800 px-4 py-3 text-sm">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Search & Filter -->
    <div class="max-w-6xl mx-auto px-4 mt-4">
        <div class="bg-white/60 rounded-xl shadow-sm p-6">
            <form method="GET" action="{{ url()->current() }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex flex-1 flex-col md:flex-row gap-4 w-full md:items-center">
                    <div class="relative w-full md:w-1/2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari workshop..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 text-sm bg-white">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" name="available" value="1"
                               onchange="this.form.submit()"
                               class="rounded border-gray-300 text-yellow-400 focus:ring-yellow-400"
                               {{ request()->boolean('available') ? 'checked' : '' }}>
                        Hanya yang masih ada slot
                    </label>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition">
                        Cari
                    </button>
                    @if(request('search') || request()->boolean('available'))
                        <a href="{{ url()->current() }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Workshop Grid -->
    <div class="max-w-6xl mx-auto px-4 mt-10 mb-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($dataWorkshop as $workshop)
                @php
                    $unlimited = is_null($workshop->capacity);
                    $sisa = $unlimited ? null : max($workshop->capacity - $workshop->taken_count, 0);
                    $penuh = !$unlimited && $sisa <= 0;
                @endphp

                <div x-data="{ open: false }">

                    <!-- Card -->
                    <div class="rounded-xl overflow-hidden shadow-lg bg-white transition hover:-translate-y-2 duration-300 ease-in-out cursor-pointer" @click="open = true">
                        @if($workshop->foto)
                            <img src="{{ asset('storage/' . $workshop->foto) }}" alt="{{ $workshop->judul }}" class="h-[180px] w-full object-cover">
                        @else
                            <div class="h-[180px] w-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm italic">
                                No Photo
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-xs font-bold text-yellow-500 uppercase tracking-wider">
                                    Rp {{ number_format($workshop->harga, 0, ',', '.') }}
                                </p>
                                @if($penuh)
                                    <span class="text-xs font-bold text-red-500">Penuh</span>
                                @elseif($unlimited)
                                    <span class="text-xs text-gray-500">Kuota bebas</span>
                                @else
                                    <span class="text-xs text-gray-500">Sisa {{ $sisa }} slot</span>
                                @endif
                            </div>
                            <p class="text-gray-800 font-bold truncate">{{ $workshop->judul }}</p>
                            <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $workshop->deskripsi }}</p>
                            <button type="button" class="mt-3 block w-full text-center bg-gray-800 text-white py-2 rounded-lg font-bold text-sm hover:bg-gray-700 transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div
                        x-show="open"
                        x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center p-4"
                        style="background-color: rgba(0,0,0,0.5);"
                        @click.self="open = false"
                        x-transition
                    >
                        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full overflow-hidden max-h-[90vh] overflow-y-auto">
                            @if($workshop->foto)
                                <img src="{{ asset('storage/' . $workshop->foto) }}" alt="{{ $workshop->judul }}" class="h-[220px] w-full object-cover">
                            @else
                                <div class="h-[220px] w-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm italic">
                                    No Photo
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-bold text-yellow-500 uppercase tracking-wider mb-1">
                                            Rp {{ number_format($workshop->harga, 0, ',', '.') }}
                                        </p>
                                        <h3 class="text-xl font-bold text-gray-800">{{ $workshop->judul }}</h3>
                                    </div>
                                    <button type="button" class="text-gray-400 hover:text-gray-600 text-xl leading-none" @click="open = false">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>

                                <p class="text-gray-600 text-sm mt-4 leading-relaxed">{{ $workshop->deskripsi }}</p>

                                <div class="mt-4 flex items-center gap-2 text-sm text-gray-700">
                                    <i class="fa-solid fa-users text-yellow-500"></i>
                                    @if($unlimited)
                                        <span>{{ $workshop->taken_count }} orang telah bergabung</span>
                                    @else
                                        <span>{{ $workshop->taken_count }} / {{ $workshop->capacity }} slot terisi</span>
                                    @endif
                                </div>

                                @if($penuh)
                                    <button type="button" disabled class="mt-5 block w-full text-center bg-gray-200 text-gray-500 py-2 rounded-lg font-bold text-sm cursor-not-allowed">
                                        Kuota Penuh
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('registrations.store', $workshop) }}">
                                        @csrf
                                        <button type="submit" class="mt-5 block w-full text-center bg-yellow-400 text-gray-900 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition cursor-pointer">
                                            Daftar &amp; Bayar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <p class="text-center text-gray-500 col-span-full">Belum ada workshop yang tersedia, cek lagi nanti ya!</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $dataWorkshop->links() }}
        </div>
    </div>

@endsection
