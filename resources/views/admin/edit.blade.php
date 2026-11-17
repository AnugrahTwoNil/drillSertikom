@extends('layouts.admin')

@section('title', 'Edit Workshop')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#4F545C]">Edit Workshop</h1>
        <p class="text-[#7A7F87] text-sm mt-1">Ubah data untuk "{{ $dataWorkshop->judul }}".</p>
    </div>

    <div class="bg-white rounded-xl border border-yellow-100 shadow-sm p-6 max-w-2xl">
        <form action="{{ route('adminWorkshop.update', $dataWorkshop->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-100 border border-red-200 p-4 text-sm text-red-800">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-5">
                <label for="judul" class="block text-sm font-medium text-[#4F545C] mb-1">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $dataWorkshop->judul) }}" required maxlength="50"
                       class="w-full px-4 py-2 border border-yellow-200 rounded-lg text-sm bg-white text-[#4F545C] placeholder-[#B5B2A6] focus:ring-yellow-300 focus:border-yellow-300">
            </div>

            <div class="mb-5">
                <label for="foto" class="block text-sm font-medium text-[#4F545C] mb-1">Foto Workshop</label>

                @if ($dataWorkshop->foto)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $dataWorkshop->foto) }}" alt="{{ $dataWorkshop->judul }}"
                             class="w-28 h-20 object-cover rounded-lg border border-yellow-100">
                        <p class="text-xs text-[#7A7F87]">Foto saat ini. Pilih file baru hanya jika ingin menggantinya.</p>
                    </div>
                @endif

                <input type="file" name="foto" id="foto" accept="image/*"
                       class="block w-full text-sm text-[#7A7F87] border border-yellow-200 rounded-lg bg-white
                              file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-medium
                              file:bg-yellow-200 file:text-[#4F545C] hover:file:bg-yellow-300 file:cursor-pointer">
                <p class="text-xs text-[#7A7F87] mt-1">Format JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
            </div>

            <div class="mb-5">
                <label for="deskripsi" class="block text-sm font-medium text-[#4F545C] mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="5" required
                          class="w-full px-4 py-2 border border-yellow-200 rounded-lg text-sm bg-white text-[#4F545C] placeholder-[#B5B2A6] focus:ring-yellow-300 focus:border-yellow-300">{{ old('deskripsi', $dataWorkshop->deskripsi) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                <div>
                    <label for="harga" class="block text-sm font-medium text-[#4F545C] mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga', $dataWorkshop->harga) }}" min="1000" max="10000000" required
                           class="w-full px-4 py-2 border border-yellow-200 rounded-lg text-sm bg-white text-[#4F545C] placeholder-[#B5B2A6] focus:ring-yellow-300 focus:border-yellow-300">
                    <p class="text-xs text-[#7A7F87] mt-1">Minimal Rp 1.000, maksimal Rp 10.000.000.</p>
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-medium text-[#4F545C] mb-1">Kuota Peserta</label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $dataWorkshop->capacity) }}" min="5"
                           class="w-full px-4 py-2 border border-yellow-200 rounded-lg text-sm bg-white text-[#4F545C] placeholder-[#B5B2A6] focus:ring-yellow-300 focus:border-yellow-300">
                    <p class="text-xs text-[#7A7F87] mt-1">Kosongkan jika tidak dibatasi. Minimal 5.</p>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row gap-3">
                <a href="{{ route('adminWorkshop.index') }}"
                   class="bg-[#E9E7DF] text-[#4F545C] px-5 py-2 rounded-lg font-medium text-sm hover:bg-[#DEDBD0] transition text-center">
                    Batal
                </a>
                <button type="submit"
                        class="bg-yellow-200 text-[#4F545C] px-5 py-2 rounded-lg font-medium text-sm hover:bg-yellow-300 transition cursor-pointer sm:flex-1">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection