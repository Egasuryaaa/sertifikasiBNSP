@extends('layouts.app')
@section('judul', 'Buat Resi Baru')
@section('konten')
<h1 class="text-2xl font-bold mb-4">Buat Resi Baru</h1>

<form method="POST" action="{{ route('resi.store') }}" class="bg-white p-6 rounded shadow max-w-3xl">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Pelanggan</label>
            <select name="pelanggan_id" class="border rounded p-2 w-full" required>
                <option value="">- Pilih Pelanggan -</option>
                @foreach ($pelanggan as $p)
                    <option value="{{ $p->id }}" @selected(old('pelanggan_id') == $p->id)>{{ $p->nama }} ({{ $p->is_member ? 'Member' : 'Reguler' }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Layanan</label>
            <select name="layanan_id" class="border rounded p-2 w-full" required>
                <option value="">- Pilih Layanan -</option>
                @foreach ($layanan as $l)
                    <option value="{{ $l->id }}" @selected(old('layanan_id') == $l->id)>{{ $l->nama }} - Rp {{ number_format($l->tarif_per_kg, 0, ',', '.') }}/kg</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Cabang Asal</label>
            <select name="cabang_asal_id" class="border rounded p-2 w-full" required>
                <option value="">- Pilih Cabang -</option>
                @foreach ($cabang as $c)
                    <option value="{{ $c->id }}" @selected(old('cabang_asal_id') == $c->id)>{{ $c->nama }} - {{ $c->kota }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Cabang Tujuan</label>
            <select name="cabang_tujuan_id" class="border rounded p-2 w-full" required>
                <option value="">- Pilih Cabang -</option>
                @foreach ($cabang as $c)
                    <option value="{{ $c->id }}" @selected(old('cabang_tujuan_id') == $c->id)>{{ $c->nama }} - {{ $c->kota }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama Penerima</label>
            <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}" class="border rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Telepon Penerima</label>
            <input type="text" name="telepon_penerima" value="{{ old('telepon_penerima') }}" class="border rounded p-2 w-full" required>
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Alamat Penerima</label>
        <textarea name="alamat_penerima" rows="2" class="border rounded p-2 w-full" required>{{ old('alamat_penerima') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Berat Aktual (kg)</label>
            <input type="number" step="0.1" name="berat_aktual" value="{{ old('berat_aktual', 1) }}" class="border rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">P (cm)</label>
            <input type="number" step="0.1" name="panjang" value="{{ old('panjang') }}" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">L (cm)</label>
            <input type="number" step="0.1" name="lebar" value="{{ old('lebar') }}" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">T (cm)</label>
            <input type="number" step="0.1" name="tinggi" value="{{ old('tinggi') }}" class="border rounded p-2 w-full">
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Nilai Barang (Rp)</label>
        <input type="number" step="1000" name="nilai_barang" value="{{ old('nilai_barang', 0) }}" class="border rounded p-2 w-full" required>
        <p class="text-xs text-gray-500 mt-1">Asuransi 0,2% otomatis jika nilai barang > Rp 1.000.000</p>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Catatan (opsional)</label>
        <textarea name="catatan" rows="2" class="border rounded p-2 w-full">{{ old('catatan') }}</textarea>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800">Simpan</button>
        <a href="{{ route('resi.index') }}" class="border px-6 py-2 rounded">Batal</a>
    </div>
</form>
@endsection