@extends('layouts.app')
@section('judul', 'Daftar Resi')
@section('konten')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Daftar Resi</h1>
    <a href="{{ route('resi.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">+ Buat Resi</a>
</div>

<form method="GET" class="mb-4 flex flex-wrap gap-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor resi / penerima..." class="border rounded p-2 w-64">
    <select name="status" class="border rounded p-2">
        <option value="">Semua Status</option>
        @foreach (['pending','pickup','transit','delivery','terkirim','gagal'] as $s)
            <option value="{{ $s }}" @selected(request('status') == $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button class="bg-blue-700 text-white px-4 py-2 rounded">Filter</button>
    @if (request('q') || request('status'))
        <a href="{{ route('resi.index') }}" class="border px-4 py-2 rounded">Reset</a>
    @endif
</form>

<table class="min-w-full bg-white rounded shadow text-sm">
    <thead class="bg-blue-700 text-white">
        <tr>
            <th class="p-3 text-left">No. Resi</th>
            <th class="p-3 text-left">Pengirim</th>
            <th class="p-3 text-left">Penerima</th>
            <th class="p-3 text-left">Tujuan</th>
            <th class="p-3 text-left">Layanan</th>
            <th class="p-3 text-right">Biaya</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($resi as $r)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 font-mono text-xs">{{ $r->nomor_resi }}</td>
                <td class="p-3">{{ $r->pelanggan->nama ?? '-' }}</td>
                <td class="p-3">{{ $r->nama_penerima }}</td>
                <td class="p-3">{{ $r->cabangTujuan->kota ?? '-' }}</td>
                <td class="p-3">{{ $r->layanan->nama ?? '-' }}</td>
                <td class="p-3 text-right">Rp {{ number_format($r->total_biaya, 0, ',', '.') }}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded text-xs
                        @if($r->status == 'terkirim') bg-green-100 text-green-700
                        @elseif($r->status == 'gagal') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700 @endif">
                        {{ strtoupper($r->status) }}
                    </span>
                </td>
                <td class="p-3 space-x-2 whitespace-nowrap">
                    <a href="{{ route('resi.show', $r) }}" class="text-blue-600 hover:underline">Lihat</a>
                    <a href="{{ route('resi.label', $r) }}" class="text-purple-600 hover:underline">Label</a>
                    <form action="{{ route('resi.destroy', $r) }}" method="POST" class="inline" onsubmit="return confirm('Hapus resi ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="p-6 text-center text-gray-500">Belum ada resi.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $resi->links() }}</div>
@endsection