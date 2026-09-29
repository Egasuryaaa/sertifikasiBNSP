@extends('layouts.app')
@section('judul', 'Dashboard')
@section('konten')
<h1 class="text-2xl font-bold mb-6">Dashboard SiLacak</h1>

{{-- Kartu Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded shadow border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Resi</p>
        <p class="text-3xl font-bold text-blue-700">{{ number_format($stats['total_resi']) }}</p>
    </div>
    <div class="bg-white p-5 rounded shadow border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Pelanggan</p>
        <p class="text-3xl font-bold text-green-600">{{ number_format($stats['total_pelanggan']) }}</p>
    </div>
    <div class="bg-white p-5 rounded shadow border-l-4 border-purple-500">
        <p class="text-sm text-gray-500">Cabang</p>
        <p class="text-3xl font-bold text-purple-700">{{ number_format($stats['total_cabang']) }}</p>
    </div>
    <div class="bg-white p-5 rounded shadow border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Pendapatan</p>
        <p class="text-xl font-bold text-yellow-700">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white p-5 rounded shadow border-l-4 border-indigo-500">
        <p class="text-sm text-gray-500">Resi Hari Ini</p>
        <p class="text-2xl font-bold text-indigo-700">{{ number_format($stats['resi_hari_ini']) }}</p>
    </div>
    <div class="bg-white p-5 rounded shadow border-l-4 border-orange-500">
        <p class="text-sm text-gray-500">Resi Transit</p>
        <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['resi_transit']) }}</p>
    </div>
</div>

{{-- Statistik per Layanan --}}
<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="font-bold text-lg mb-4">Resi per Layanan</h2>
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Layanan</th>
                <th class="p-3 text-right">Jumlah Resi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($perLayanan as $l)
                <tr class="border-b">
                    <td class="p-3">{{ $l->nama }}</td>
                    <td class="p-3 text-right font-semibold">{{ $l->resi_count }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="p-6 text-center text-gray-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Resi Terbaru --}}
<div class="bg-white p-6 rounded shadow">
    <h2 class="font-bold text-lg mb-4">Resi Terbaru</h2>
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">No. Resi</th>
                <th class="p-3 text-left">Pelanggan</th>
                <th class="p-3 text-left">Layanan</th>
                <th class="p-3 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($terbaru as $r)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 font-mono text-xs">
                        <a href="{{ route('resi.show', $r) }}" class="text-blue-600 hover:underline">{{ $r->nomor_resi }}</a>
                    </td>
                    <td class="p-3">{{ $r->pelanggan->nama ?? '-' }}</td>
                    <td class="p-3">{{ $r->layanan->nama ?? '-' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs
                            @if($r->status == 'terkirim') bg-green-100 text-green-700
                            @elseif($r->status == 'gagal') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ strtoupper($r->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-6 text-center text-gray-500">Belum ada resi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection