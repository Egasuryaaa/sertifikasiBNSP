@extends('layouts.app')
@section('judul', 'Hasil Ongkir')
@section('konten')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Hasil Perhitungan</h1>
    <div class="space-y-2 text-sm">
        <div class="flex justify-between"><span>Layanan</span><strong>{{ $layanan->nama }}</strong></div>
        <div class="flex justify-between"><span>Berat Aktual</span><strong>{{ $data['berat_aktual'] }} kg</strong></div>
        <div class="flex justify-between"><span>Berat Tagih</span><strong>{{ $beratTagih }} kg</strong></div>
        <hr>
        <div class="flex justify-between"><span>Biaya Dasar</span><span>Rp {{ number_format($hasil['biaya_dasar'], 0, ',', '.') }}</span></div>
        <div class="flex justify-between text-green-700"><span>Diskon Member</span><span>- Rp {{ number_format($hasil['diskon'], 0, ',', '.') }}</span></div>
        <div class="flex justify-between text-orange-700"><span>Asuransi</span><span>+ Rp {{ number_format($hasil['asuransi'], 0, ',', '.') }}</span></div>
        <hr>
        <div class="flex justify-between text-xl font-bold"><span>TOTAL</span><span>Rp {{ number_format($hasil['total_biaya'], 0, ',', '.') }}</span></div>
    </div>
    <a href="{{ route('tarif.index') }}" class="block mt-6 text-center border px-4 py-2 rounded">Hitung Lagi</a>
</div>
@endsection