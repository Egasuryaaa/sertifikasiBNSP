@extends('layouts.app')
@section('judul', 'Lacak Paket')
@section('konten')
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-3xl font-bold mb-2 text-center">Lacak Paket Anda</h1>
    <p class="text-center text-gray-500 mb-6">Masukkan nomor resi untuk melihat status pengiriman</p>
    <form method="GET" action="{{ route('tracking.cari') }}" class="flex gap-2">
        <input type="text" name="nomor_resi" value="{{ old('nomor_resi') }}" placeholder="Contoh: SLC-20250101-0001" class="flex-1 border rounded p-3 text-lg" required autofocus>
        <button class="bg-blue-700 text-white px-6 py-3 rounded hover:bg-blue-800">Lacak</button>
    </form>
</div>
@endsection