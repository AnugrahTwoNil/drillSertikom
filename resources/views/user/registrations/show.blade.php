@extends('layouts.user')

@section('title', 'Detail Pendaftaran')
@section('subtitle', 'Status pembayaran dan langkah selanjutnya.')

@section('content')
    @php
        $workshop = $registration->workshop;
        $badge = match ($registration->status) {
            'paid'    => ['Lunas', 'bg-green-100 text-green-800'],
            'pending' => ['Menunggu Pembayaran', 'bg-yellow-100 text-yellow-800'],
            'expired' => ['Kedaluwarsa', 'bg-gray-200 text-gray-600'],
            default   => ['Gagal', 'bg-red-100 text-red-700'],
        };
    @endphp

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if ($workshop->foto)
            <img src="{{ asset('storage/' . $workshop->foto) }}" alt="{{ $workshop->judul }}" class="h-[240px] w-full object-cover">
        @else
            <div class="h-[240px] w-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm italic">No Photo</div>
        @endif

        <div class="p-6">
            <div class="flex items-start justify-between gap-3">
                <h2 class="text-xl font-bold text-gray-800">{{ $workshop->judul }}</h2>
                <span class="text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap {{ $badge[1] }}">{{ $badge[0] }}</span>
            </div>

            <p class="text-gray-600 text-sm mt-3 leading-relaxed">{{ $workshop->deskripsi }}</p>

            <dl class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div class="bg-yellow-50 rounded-lg p-4">
                    <dt class="text-gray-500">Harga</dt>
                    <dd class="font-bold text-gray-800">Rp {{ number_format($workshop->harga, 0, ',', '.') }}</dd>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <dt class="text-gray-500">Tanggal Daftar</dt>
                    <dd class="font-bold text-gray-800">{{ $registration->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 sm:col-span-2">
                    <dt class="text-gray-500">Kode Pesanan</dt>
                    <dd class="font-bold text-gray-800 break-all">{{ $registration->order_id }}</dd>
                </div>
            </dl>

            <!-- Actions depend on status -->
            <div class="mt-6">
                @if ($registration->status === 'paid')
                    <a href="{{ route('registrations.ticket', $registration) }}"
                       class="block text-center bg-yellow-400 text-gray-900 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition">
                        <i class="fa-solid fa-ticket mr-1"></i> Lihat Tiket
                    </a>

                @elseif ($registration->status === 'pending')
                    <p class="text-sm text-gray-500 mb-3">
                        Selesaikan pembayaran lewat QR code, lalu klik "Cek Status" untuk memperbarui.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('registrations.pay', $registration) }}"
                           class="flex-1 text-center bg-yellow-400 text-gray-900 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition">
                            <i class="fa-solid fa-qrcode mr-1"></i> Bayar Sekarang
                        </a>
                        <a href="{{ route('registrations.check', $registration) }}"
                           class="flex-1 text-center bg-white border border-gray-300 text-gray-800 py-2 rounded-lg font-bold text-sm hover:bg-gray-50 transition">
                            Cek Status
                        </a>
                    </div>

                @else
                    <p class="text-sm text-gray-500 mb-3">
                        Pembayaran ini {{ $registration->status === 'expired' ? 'sudah kedaluwarsa' : 'tidak berhasil' }}.
                        Kamu bisa mendaftar ulang untuk workshop yang sama.
                    </p>
                    <form method="POST" action="{{ route('registrations.store', $workshop) }}">
                        @csrf
                        <button type="submit"
                                class="w-full bg-yellow-400 text-gray-900 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition cursor-pointer">
                            Daftar Ulang
                        </button>
                    </form>
                @endif
            </div>

            <a href="{{ route('registrations.index') }}" class="inline-block mt-5 text-sm text-gray-500 hover:text-gray-800">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Pendaftaran Saya
            </a>
        </div>
    </div>
@endsection