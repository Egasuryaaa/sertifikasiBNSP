<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 10px; margin: 10px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 5px; }
        .kode { font-size: 16px; font-weight: bold; letter-spacing: 2px; text-align: center; margin: 6px 0; }
        .qr { text-align: center; margin-top: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <div style="font-size:14px;font-weight:bold">SiLacak</div>
        <div>PT Sinar Logistik Nusantara</div>
    </div>
    <div class="kode">{{ $resi->nomor_resi }}</div>
    <div class="qr">{!! QrCode::size(100)->generate($resi->nomor_resi) !!}</div>
    <div style="margin-top:8px">
        <div><b>Pengirim:</b> {{ $resi->pelanggan->nama }}</div>
        <div><b>Penerima:</b> {{ $resi->nama_penerima }}</div>
        <div><b>Telepon:</b> {{ $resi->telepon_penerima }}</div>
        <div><b>Alamat:</b> {{ $resi->alamat_penerima }}</div>
        <div><b>Tujuan:</b> {{ $resi->cabangTujuan->kota }}</div>
        <div><b>Layanan:</b> {{ $resi->layanan->nama }}</div>
        <div><b>Berat:</b> {{ $resi->berat_tagih }} kg</div>
        <div><b>Biaya:</b> Rp {{ number_format($resi->total_biaya, 0, ',', '.') }}</div>
    </div>
</body>
</html>