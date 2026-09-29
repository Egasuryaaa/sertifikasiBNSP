@extends('layouts.app')
@section('judul', 'Detail Resi')
@section('konten')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Resi: {{ $resi->nomor_resi }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('resi.label', $resi) }}" class="bg-purple-600 text-white px-4 py-2 rounded">Cetak Label PDF</a>
            <a href="{{ route('resi.index') }}" class="border px-4 py-2 rounded">Kembali</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow mb-4">
        <h2 class="font-bold text-lg mb-3">Informasi Pengiriman</h2>
        <dl class="grid grid-cols-3 gap-3 text-sm">
            <dt class="font-semibold">Pelanggan</dt>
            <dd class="col-span-2">{{ $resi->pelanggan->nama }}</dd>

            <dt class="font-semibold">Penerima</dt>
            <dd class="col-span-2">{{ $resi->nama_penerima }} - {{ $resi->telepon_penerima }}</dd>

            <dt class="font-semibold">Alamat</dt>
            <dd class="col-span-2">{{ $resi->alamat_penerima }}</dd>

            <dt class="font-semibold">Asal</dt>
            <dd class="col-span-2">{{ $resi->cabangAsal->nama }} ({{ $resi->cabangAsal->kota }})</dd>

            <dt class="font-semibold">Tujuan</dt>
            <dd class="col-span-2">{{ $resi->cabangTujuan->nama }} ({{ $resi->cabangTujuan->kota }})</dd>

            <dt class="font-semibold">Layanan</dt>
            <dd class="col-span-2">{{ $resi->layanan->nama }}</dd>

            <dt class="font-semibold">Berat Aktual</dt>
            <dd class="col-span-2">{{ $resi->berat_aktual }} kg</dd>

            <dt class="font-semibold">Berat Tagih</dt>
            <dd class="col-span-2">{{ $resi->berat_tagih }} kg</dd>

            <dt class="font-semibold">Nilai Barang</dt>
            <dd class="col-span-2">Rp {{ number_format($resi->nilai_barang, 0, ',', '.') }}</dd>

            <dt class="font-semibold">Biaya Dasar</dt>
            <dd class="col-span-2">Rp {{ number_format($resi->biaya_dasar, 0, ',', '.') }}</dd>

            <dt class="font-semibold">Diskon</dt>
            <dd class="col-span-2 text-green-700">- Rp {{ number_format($resi->diskon, 0, ',', '.') }}</dd>

            <dt class="font-semibold">Asuransi</dt>
            <dd class="col-span-2 text-orange-700">+ Rp {{ number_format($resi->asuransi, 0, ',', '.') }}</dd>

            <dt class="font-semibold">Total Biaya</dt>
            <dd class="col-span-2 font-bold text-lg">Rp {{ number_format($resi->total_biaya, 0, ',', '.') }}</dd>

            <dt class="font-semibold">Status</dt>
            <dd class="col-span-2">
                <span class="px-2 py-1 rounded text-xs
                    @if($resi->status == 'terkirim') bg-green-100 text-green-700
                    @elseif($resi->status == 'gagal') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ strtoupper($resi->status) }}
                </span>
            </dd>
        </dl>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-bold text-lg mb-3">Riwayat Perjalanan</h2>
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