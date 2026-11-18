@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Header -->
    <div class="rounded-xl bg-yellow-100 border border-yellow-200 p-8 mb-8">
        <h1 class="text-2xl font-semibold text-[#4F545C]">
            Halo, {{ auth()->user()->name }}
        </h1>
        <p class="text-[#7A7F87] mt-1">Ringkasan data workshopTIX.</p>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-yellow-100 shadow-sm p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-users text-[#8A7F3A] text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-[#7A7F87]">Total Peserta</p>
                <p class="text-3xl font-semibold text-[#4F545C]">{{ number_format($totalUsers, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-yellow-100 shadow-sm p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-chalkboard-user text-[#8A7F3A] text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-[#7A7F87]">Total Workshop</p>
                <p class="text-3xl font-semibold text-[#4F545C]">{{ number_format($totalWorkshops, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-yellow-100 shadow-sm p-6 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-ticket text-[#8A7F3A] text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-[#7A7F87]">Total Pendaftaran</p>
                <p class="text-3xl font-semibold text-[#4F545C]">{{ number_format($totalRegistrations, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick actions -->
    <div class="bg-white rounded-xl border border-yellow-100 shadow-sm p-6 mt-8">
        <h2 class="text-lg font-semibold text-[#4F545C] mb-4">Aksi Cepat</h2>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('adminWorkshop.create') }}"
               class="bg-yellow-200 text-[#4F545C] px-5 py-2 rounded-lg font-medium text-sm hover:bg-yellow-300 transition text-center">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Workshop
            </a>
            <a href="{{ route('adminWorkshop.index') }}"
               class="bg-[#E9E7DF] text-[#4F545C] px-5 py-2 rounded-lg font-medium text-sm hover:bg-[#DEDBD0] transition text-center">
                Kelola Workshop
            </a>
        </div>
    </div>
@endsection