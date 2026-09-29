@extends('layouts.app')
@section('judul', 'Cek Ongkir')
@section('konten')
<div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Daftar Tarif</h1>
        @foreach ($layanan as $l)
            <div class="border-b py-2 flex justify-between">
                <span>{{ $l->nama }}</span>
                <span class="font-semibold">Rp {{ number_format($l->tarif_per_kg, 0, ',', '.') }}/kg</span>
            </div>
        @endforeach
    </div>
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Hitung Ongkir</h2>
        <form method="POST" action="{{ route('tarif.hitung') }}" class="space-y-3">
            @csrf
            <select name="layanan_id" class="w-full border rounded p-2" required>
                <option value="">- Pilih Layanan -</option>
                @foreach ($layanan as $l)
                    <option value="{{ $l->id }}">{{ $l->nama }} - Rp {{ number_format($l->tarif_per_kg, 0, ',', '.') }}/kg</option>
                @endforeach
            </select>
            <input type="number" step="0.1" name="berat_aktual" placeholder="Berat aktual (kg)" class="w-full border rounded p-2" required>
            <div class="grid grid-cols-3 gap-2">
                <input type="number" step="0.1" name="panjang" placeholder="P (cm)" class="border rounded p-2">
                <input type="number" step="0.1" name="lebar" placeholder="L (cm)" class="border rounded p-2">
                <input type="number" step="0.1" name="tinggi" placeholder="T (cm)" class="border rounded p-2">
            </div>
            <input type="number" step="1000" name="nilai_barang" placeholder="Nilai barang (Rp)" class="w-full border rounded p-2" value="0">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_member" value="1"> Pelanggan Member (diskon 10%)
            </label>
            <button class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">Hitung</button>
        </form>
    </div>
</div>
@endsection