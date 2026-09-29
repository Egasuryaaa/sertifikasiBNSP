@extends('layouts.app')
@section('judul', 'Cek Ongkir')
@section('konten')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Cek Tarif Pengiriman</h1>
        <p class="text-gray-500 text-sm">Kalkulasi biaya pengiriman paket Anda dengan cepat dan akurat</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Daftar Tarif -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm h-fit">
            <h2 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Layanan Tersedia</h2>
            <div class="space-y-3">
                @foreach ($layanan as $l)
                    <div class="flex justify-between items-center py-2">
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $l->nama }}</h3>
                            <p class="text-gray-500 text-xs">Pengiriman reguler</p>
                        </div>
                        <div class="text-right">
                            <span class="block font-semibold text-gray-900">Rp {{ number_format($l->tarif_per_kg, 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-500">per kg</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kalkulator -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Kalkulator Ongkir</h2>
            <form method="POST" action="{{ route('tarif.hitung') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Layanan</label>
                    <select name="layanan_id" class="w-full border border-gray-300 text-gray-900 rounded-md p-2.5 focus:outline-none focus:ring-2 focus:ring-[#ee4d2d] focus:border-[#ee4d2d] transition-colors" required>
                        <option value="">- Silakan Pilih -</option>
                        @foreach ($layanan as $l)
                            <option value="{{ $l->id }}">{{ $l->nama }} - Rp {{ number_format($l->tarif_per_kg, 0, ',', '.') }}/kg</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Berat Aktual (kg)</label>
                    <input type="number" step="0.1" name="berat_aktual" placeholder="Contoh: 1.5" class="w-full border border-gray-300 text-gray-900 rounded-md p-2.5 focus:outline-none focus:ring-2 focus:ring-[#ee4d2d] focus:border-[#ee4d2d] transition-colors" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dimensi Paket (opsional)</label>
                    <div class="grid grid-cols-3 gap-3">
                        <input type="number" step="0.1" name="panjang" placeholder="P (cm)" class="border border-gray-300 text-gray-900 rounded-md p-2.5 focus:outline-none focus:ring-2 focus:ring-[#ee4d2d] focus:border-[#ee4d2d] transition-colors">
                        <input type="number" step="0.1" name="lebar" placeholder="L (cm)" class="border border-gray-300 text-gray-900 rounded-md p-2.5 focus:outline-none focus:ring-2 focus:ring-[#ee4d2d] focus:border-[#ee4d2d] transition-colors">
                        <input type="number" step="0.1" name="tinggi" placeholder="T (cm)" class="border border-gray-300 text-gray-900 rounded-md p-2.5 focus:outline-none focus:ring-2 focus:ring-[#ee4d2d] focus:border-[#ee4d2d] transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Barang (Rp)</label>
                    <input type="number" step="1000" name="nilai_barang" placeholder="0" value="0" class="w-full border border-gray-300 text-gray-900 rounded-md p-2.5 focus:outline-none focus:ring-2 focus:ring-[#ee4d2d] focus:border-[#ee4d2d] transition-colors">
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_member" value="1" class="w-4 h-4 rounded border-gray-300 text-[#ee4d2d] focus:ring-[#ee4d2d]">
                        <span class="text-sm text-gray-700">Pelanggan Member (diskon 10%)</span>
                    </label>
                </div>
                
                <button class="w-full bg-[#ee4d2d] text-white font-medium py-3 rounded-md hover:bg-[#d73d1f] transition-colors mt-2 shadow-sm">
                    Hitung Ongkos Kirim
                </button>
            </form>
        </div>
    </div>
</div>
@endsection