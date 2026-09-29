<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #111;
            background: #fff;
        }
        .wrap {
            border: 2px solid #111;
            width: 100%;
            padding: 0;
        }

        /* HEADER */
        .hdr {
            background: #ee4d2d;
            color: #fff;
            text-align: center;
            padding: 8px 10px;
        }
        .hdr .brand { font-size: 20px; font-weight: bold; letter-spacing: 1px; }
        .hdr .tagline { font-size: 9px; opacity: .85; margin-top: 1px; }

        /* BARCODE STRIP */
        .bc-wrap {
            text-align: center;
            padding: 10px 30px 6px;
            border-bottom: 1px solid #ddd;
        }
        .bc-wrap img { max-width: 220px; height: 50px; }
        .bc-num { font-size: 12px; font-weight: bold; letter-spacing: 2px; margin-top: 3px; }

        /* BODY 2 COLUMN */
        .body-row {
            display: table;
            width: 100%;
            border-top: 0;
        }
        .col-left {
            display: table-cell;
            width: 62%;
            padding: 10px 10px 10px 12px;
            border-right: 1px solid #ddd;
            vertical-align: top;
        }
        .col-right {
            display: table-cell;
            width: 38%;
            padding: 10px 12px 10px 10px;
            vertical-align: top;
            text-align: center;
        }

        .section-title {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            color: #777;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }
        .big-name { font-size: 13px; font-weight: bold; margin-bottom: 1px; }
        .kota { font-size: 12px; font-weight: bold; margin-top: 5px; }
        .muted { color: #555; font-size: 9px; }
        
        .divider { border-top: 1px dashed #ccc; margin: 8px 0; }

        .right-section { margin-bottom: 6px; }
        .right-section .section-title { margin-bottom: 3px; }
        .layanan-text { font-size: 18px; font-weight: bold; color: #ee4d2d; }
        .berat-text { font-size: 16px; font-weight: bold; }

        /* FOOTER */
        .ftr {
            border-top: 1px solid #ddd;
            text-align: center;
            padding: 5px 10px;
            font-size: 8px;
            color: #888;
        }
    </style>
</head>
<body>
<div class="wrap">

    {{-- HEADER --}}
    <div class="hdr">
        <div class="brand">SiLacak Express</div>
        <div class="tagline">PT Sinar Logistik Nusantara</div>
    </div>

    {{-- BARCODE BATANG --}}
    <div class="bc-wrap">
        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($resi->nomor_resi, 'C128', 1.7, 50) }}" alt="barcode">
        <div class="bc-num">{{ $resi->nomor_resi }}</div>
    </div>

    {{-- BODY --}}
    <div class="body-row">

        {{-- KIRI: info paket --}}
        <div class="col-left">
            <div class="section-title">Penerima</div>
            <div class="big-name">{{ $resi->nama_penerima }}</div>
            <div class="muted">{{ $resi->telepon_penerima }}</div>
            <div class="muted" style="margin-top:3px; line-height:1.4;">{{ $resi->alamat_penerima }}</div>
            <div class="kota">{{ strtoupper($resi->cabangTujuan->kota) }}</div>

            <div class="divider"></div>

            <div class="section-title">Pengirim</div>
            <div style="font-weight:bold; font-size:11px;">{{ $resi->pelanggan->nama }}</div>
            <div class="muted">{{ strtoupper($resi->cabangAsal->kota) }}</div>
        </div>

        {{-- KANAN: QR + info --}}
        <div class="col-right">
            <div class="right-section">
                <div class="section-title">QR Code</div>
                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($resi->nomor_resi, 'QRCODE', 3, 3) }}" alt="qr">
            </div>

            <div class="divider"></div>

            <div class="right-section">
                <div class="section-title">Layanan</div>
                <div class="layanan-text">{{ strtoupper($resi->layanan->nama) }}</div>
            </div>

            <div class="divider"></div>

            <div class="right-section">
                <div class="section-title">Berat</div>
                <div class="berat-text">{{ $resi->berat_tagih }} KG</div>
            </div>

            <div class="divider"></div>

            <div class="right-section">
                <div class="section-title">Total Biaya</div>
                <div style="font-weight:bold; font-size:11px;">Rp {{ number_format($resi->total_biaya, 0, ',', '.') }}</div>
            </div>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="ftr">
        Dicetak: {{ now()->format('d M Y, H:i') }} &nbsp;|&nbsp; Hubungi: 1500-LCK &nbsp;|&nbsp; silacak.test
    </div>

</div>
</body>
</html>