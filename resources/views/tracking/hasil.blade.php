@extends('layouts.app')
@section('judul', 'Hasil Pelacakan')
@section('konten')
<div class="max-w-3xl mx-auto">
    <div class="bg-white p-6 rounded shadow mb-4">
        <h1 class="text-2xl font-bold mb-4">Resi: {{ $resi->nomor_resi }}</h1>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="text-gray-500">Pengirim:</span> {{ $resi->pelanggan->nama }}</div>
            <div><span class="text-gray-500">Penerima:</span> {{ $resi->nama_penerima }}</div>
            <div><span class="text-gray-500">Asal:</span> {{ $resi->cabangAsal->kota }}</div>
            <div><span class="text-gray-500">Tujuan:</span> {{ $resi->cabangTujuan->kota }}</div>
            <div><span class="text-gray-500">Layanan:</span> {{ $resi->layanan->nama }}</div>
            <div><span class="text-gray-500">Berat Tagih:</span> {{ $resi->berat_tagih }} kg</div>
            <div><span class="text-gray-500">Total Biaya:</span> Rp {{ number_format($resi->total_biaya, 0, ',', '.') }}</div>
            <div>
                <span class="text-gray-500">Status:</span>
                <span class="px-2 py-1 rounded text-xs font-semibold
                    @if($resi->status == 'terkirim') bg-green-100 text-green-700
                    @elseif($resi->status == 'gagal') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ strtoupper($resi->status) }}
                </span>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-bold text-lg mb-4">Riwayat Perjalanan</h2>
        @forelse ($resi->trackingLog as $log)
            <div class="border-l-4 border-blue-500 pl-4 mb-3">
                <div class="font-semibold">{{ strtoupper($log->status) }} - {{ $log->lokasi }}</div>
                <div class="text-sm text-gray-500">{{ $log->created_at->format('d M Y H:i') }}</div>
                @if($log->keterangan)<div class="text-sm">{{ $log->keterangan }}</div>@endif
            </div>
        @empty
            <p class="text-gray-500">Belum ada riwayat.</p>
        @endforelse
    </div>
</div>
@endsection