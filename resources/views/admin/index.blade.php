@extends('layouts.admin')

@section('title', 'Kelola Workshop')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-[#4F545C]">Kelola Workshop</h1>
            <p class="text-[#7A7F87] text-sm mt-1">Daftar semua workshop yang tersedia.</p>
        </div>
        <a href="{{ route('adminWorkshop.create') }}"
           class="bg-yellow-200 text-[#4F545C] px-5 py-2 rounded-lg font-medium text-sm hover:bg-yellow-300 transition text-center">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Workshop
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-yellow-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-yellow-100 text-[#4F545C]">
                    <tr>
                        <th class="px-4 py-3 font-semibold w-12">#</th>
                        <th class="px-4 py-3 font-semibold">Foto</th>
                        <th class="px-4 py-3 font-semibold">Judul</th>
                        <th class="px-4 py-3 font-semibold">Harga</th>
                        <th class="px-4 py-3 font-semibold">Kuota</th>
                        <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-yellow-100">
                    @forelse ($dataWorkshop as $workshop)
                        <tr class="hover:bg-yellow-50">
                            <td class="px-4 py-3 text-[#7A7F87]">
                                {{ $dataWorkshop->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($workshop->foto)
                                    <img src="{{ asset('storage/' . $workshop->foto) }}" alt="{{ $workshop->judul }}"
                                         class="w-16 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-12 rounded-lg bg-[#E9E7DF] flex items-center justify-center text-xs text-[#7A7F87]">
                                        -
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-[#4F545C]">{{ $workshop->judul }}</p>
                                <p class="text-xs text-[#7A7F87] line-clamp-1 max-w-xs">{{ $workshop->deskripsi }}</p>
                            </td>
                            <td class="px-4 py-3 text-[#4F545C] whitespace-nowrap">
                                Rp {{ number_format($workshop->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-[#4F545C] whitespace-nowrap">
                                @if (is_null($workshop->capacity))
                                    {{ $workshop->taken_count }} / tak terbatas
                                @else
                                    {{ $workshop->taken_count }} / {{ $workshop->capacity }}
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('adminWorkshop.edit', $workshop) }}"
                                       class="bg-yellow-200 text-[#4F545C] px-3 py-1.5 rounded-lg font-medium text-xs hover:bg-yellow-300 transition">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('adminWorkshop.destroy', $workshop) }}"
                                          onsubmit="return confirm('Hapus workshop ini? Semua pendaftarannya juga akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-100 text-red-800 px-3 py-1.5 rounded-lg font-medium text-xs hover:bg-red-200 transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-[#7A7F87]">
                                Belum ada workshop. Klik "Tambah Workshop" untuk membuat yang pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $dataWorkshop->links() }}
    </div>
@endsection