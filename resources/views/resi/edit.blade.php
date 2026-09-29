@extends('layouts.app')
@section('judul', 'Ubah Resi')
@section('konten')
<h1 class="text-2xl font-bold mb-4">Ubah Resi: {{ $resi->nomor_resi }}</h1>

<form method="POST" action="{{ route('resi.update', $resi) }}" class="bg-white p-6 rounded shadow max-w-3xl">
    @csrf @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Pelanggan</label>
            <select name="pelanggan_id" class="border rounded p-2 w-full" required>
                @foreach ($pelanggan as $p)
                    <option value="{{ $p->id }}" @selected($resi->pelanggan_id == $p->id)>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Layanan</label>
            <select name="layanan_id" class="border rounded p-2 w-full" required>
                @foreach ($layanan as $l)
                    <option value="{{ $l->id }}" @selected($resi->layanan_id == $l->id)>{{ $l->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Cabang Asal</label>
            <select name="cabang_asal_id" class="border rounded p-2 w-full" required>
                @foreach ($cabang as $c)
                    <option value="{{ $c->id }}" @selected($resi->cabang_asal_id == $c->id)>{{ $c->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Cabang Tujuan</label>
            <select name="cabang_tujuan_id" class="border rounded p-2 w-full" required>
                @foreach ($cabang as $c)
                    <option value="{{ $c->id }}" @selected($resi->cabang_tujuan_id == $c->id)>{{ $c->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Nama Penerima</label>
        <input type="text" name="nama_penerima" value="{{ old('nama_penerima', $resi->nama_penerima) }}" class="border rounded p-2 w-full" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-semibold">Telepon Penerima</label>
        <input type="text" name="telepon_penerima" value="{{ old('telepon_penerima', $resi->telepon_penerima) }}" class="border rounded p-2 w-full" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-semibold">Alamat Penerima</label>
        <textarea name="alamat_penerima" rows="2" class="border rounded p-2 w-full" required>{{ old('alamat_penerima', $resi->alamat_penerima) }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Berat Aktual</label>
            <input type="number" step="0.1" name="berat_aktual" value="{{ old('berat_aktual', $resi->berat_aktual) }}" class="border rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">P (cm)</label>
            <input type="number" step="0.1" name="panjang" value="{{ old('panjang', $resi->panjang) }}" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">L (cm)</label>
            <input type="number" step="0.1" name="lebar" value="{{ old('lebar', $resi->lebar) }}" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">T (cm)</label>
            <input type="number" step="0.1" name="tinggi" value="{{ old('tinggi', $resi->tinggi) }}" class="border rounded p-2 w-full">
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Nilai Barang</label>
        <input type="number" step="1000" name="nilai_barang" value="{{ old('nilai_barang', $resi->nilai_barang) }}" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Catatan</label>
        <textarea name="catatan" rows="2" class="border rounded p-2 w-full">{{ old('catatan', $resi->catatan) }}</textarea>
    </div>

    <div class="flex gap-2">
        <button class="bg-blue-700 text-white px-6 py-2 rounded">Perbarui</button>
        <a href="{{ route('resi.show', $resi) }}" class="border px-6 py-2 rounded">Batal</a>
    </div>
</form>
@endsection