@extends('layouts.app')
@section('judul', 'Lacak Paket')
@section('konten')
<div class="max-w-xl mx-auto mt-16 bg-white p-8 sm:p-10 rounded-xl border border-gray-200 shadow-sm">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Lacak Paket Anda</h1>
        <p class="text-gray-500 text-sm">Masukkan nomor resi untuk melihat status pengiriman terkini</p>
    </div>
    
    <form method="GET" action="{{ route('tracking.cari') }}" class="flex flex-col sm:flex-row gap-3">
        <input type="text" name="nomor_resi" value="{{ old('nomor_resi') }}" placeholder="Contoh: SLC-20250101-0001" class="flex-1 border border-gray-300 text-gray-900 rounded-md py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required autofocus>
        <button class="bg-blue-600 text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors shadow-sm">
            Lacak
        </button>
    </form>
</div>
@endsection