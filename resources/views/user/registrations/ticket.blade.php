@extends('layouts.user')

@section('title', 'Tiket Digital')
@section('subtitle', 'Tunjukkan tiket ini saat hadir di workshop.')

@section('content')
    @php $workshop = $registration->workshop; @endphp

    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Top -->
            <div class="bg-yellow-400 px-6 py-5">
                <p class="text-xs font-bold text-gray-800 uppercase tracking-wider">Tiket Workshop</p>
                <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $workshop->judul }}</h2>
            </div>

            <!-- Perforation -->
            <div class="relative">
                <div class="border-t-2 border-dashed border-gray-200"></div>
                <div class="absolute -left-3 -top-3 w-6 h-6 rounded-full bg-[#FBF9F1]"></div>
                <div class="absolute -right-3 -top-3 w-6 h-6 rounded-full bg-[#FBF9F1]"></div>
            </div>

            <!-- Details -->
            <div class="px-6 py-5 space-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Nama Peserta</p>
                    <p class="font-bold text-gray-800">{{ $registration->user->name }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500">Harga</p>
                        <p class="font-bold text-gray-800">Rp {{ number_format($workshop->harga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status</p>
                        <p class="font-bold text-green-700">Lunas</p>
                    </div>
                </div>
                <div>
                    <p class="text-gray-500">Kode Tiket</p>
                    <p class="font-bold text-gray-800 break-all">{{ $registration->order_id }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Tanggal Daftar</p>
                    <p class="font-bold text-gray-800">{{ $registration->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row gap-3 print:hidden">
            <button type="button" onclick="window.print()"
                    class="flex-1 bg-yellow-400 text-gray-900 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition cursor-pointer">
                <i class="fa-solid fa-print mr-1"></i> Cetak Tiket
            </button>
            <a href="{{ route('registrations.index') }}"
               class="flex-1 text-center bg-gray-800 text-white py-2 rounded-lg font-bold text-sm hover:bg-gray-700 transition">
                Kembali
            </a>
        </div>
    </div>
@endsection