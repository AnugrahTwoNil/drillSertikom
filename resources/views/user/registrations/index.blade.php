@extends('layouts.user')

@section('title', 'Pendaftaran Saya')
@section('subtitle', 'Pantau status pembayaran dan buka tiket workshop kamu di sini.')

@section('content')
    <div class="space-y-4">
        @forelse ($dataRegistration as $registration)
            @php
                $badge = match ($registration->status) {
                    'paid'    => ['Lunas', 'bg-green-100 text-green-800'],
                    'pending' => ['Menunggu Pembayaran', 'bg-yellow-100 text-yellow-800'],
                    'expired' => ['Kedaluwarsa', 'bg-gray-200 text-gray-600'],
                    default   => ['Gagal', 'bg-red-100 text-red-700'],
                };
            @endphp

            <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col sm:flex-row">
                @if ($registration->workshop->foto)
                    <img src="{{ asset('storage/' . $registration->workshop->foto) }}" alt="{{ $registration->workshop->judul }}"
                         class="h-40 sm:h-auto sm:w-48 w-full object-cover">
                @else
                    <div class="h-40 sm:h-auto sm:w-48 w-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm italic">
                        No Photo
                    </div>
                @endif

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="text-gray-800 font-bold">{{ $registration->workshop->judul }}</h2>
                        <span class="text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap {{ $badge[1] }}">{{ $badge[0] }}</span>
                    </div>

                    <p class="text-sm text-gray-500 mt-1">
                        Rp {{ number_format($registration->workshop->harga, 0, ',', '.') }}
                        &middot; Daftar {{ $registration->created_at->format('d M Y, H:i') }}
                    </p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @if ($registration->status === 'paid')
                            <a href="{{ route('registrations.ticket', $registration) }}"
                               class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition">
                                <i class="fa-solid fa-ticket mr-1"></i> Lihat Tiket
                            </a>
                        @elseif ($registration->status === 'pending')
                            <a href="{{ route('registrations.pay', $registration) }}"
                               class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition">
                                <i class="fa-solid fa-qrcode mr-1"></i> Bayar
                            </a>
                            <a href="{{ route('registrations.check', $registration) }}"
                               class="bg-white border border-gray-300 text-gray-800 px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-50 transition">
                                Cek Status
                            </a>
                        @endif

                        <a href="{{ route('registrations.show', $registration) }}"
                           class="bg-gray-800 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-700 transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white/60 rounded-xl shadow-sm p-10 text-center">
                <p class="text-gray-500 mb-4">Kamu belum mendaftar workshop apa pun.</p>
                <a href="{{ route('workshops.index') }}"
                   class="inline-block bg-yellow-400 text-gray-900 px-5 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition">
                    Lihat Workshop
                </a>
            </div>
        @endforelse
    </div>
@endsection