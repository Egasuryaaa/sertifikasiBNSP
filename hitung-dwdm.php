<?php
/**
 * Kalkulator Link Budget DWDM
 * Jakarta (DC) → Cikarang (DRC)
 */

echo "======================================================\n";
echo "  KALKULATOR LINK BUDGET DWDM\n";
echo "  Jakarta (DC) → Cikarang (DRC)\n";
echo "======================================================\n\n";

// ============ PARAMETER ============
$txPower        = 0;      // dBm
$rxSensitivity  = -24;    // dBm
$fiberLossPerKm = 0.25;   // dB/km
$jarak          = 45;     // km
$muxLoss        = 2.5;    // dB
$demuxLoss      = 2.5;    // dB
$konektor       = 4;      // jumlah
$konektorLoss   = 0.5;    // dB per konektor
$margin         = 3;      // dB
$splicePerKm    = 2;      // 1 splice tiap 2 km
$spliceLoss     = 0.1;    // dB per splice
$kapasitasKanal = 10;     // Gbps per kanal
$kanalUtama     = 3;
$kanalCadangan  = 2;

// ============ PERHITUNGAN ============
echo "📐 PERHITUNGAN LINK BUDGET\n";
echo str_repeat("-", 55) . "\n";

// 1. Redaman fiber
$redamanFiber = $jarak * $fiberLossPerKm;
printf("1. Redaman Fiber       : %d km × %.2f dB/km = %.2f dB\n",
    $jarak, $fiberLossPerKm, $redamanFiber);

// 2. Jumlah splice
$jumlahSplice = floor($jarak / $splicePerKm);
$redamanSplice = $jumlahSplice * $spliceLoss;
printf("2. Jumlah Splice       : %d km / %d km = %d titik\n",
    $jarak, $splicePerKm, $jumlahSplice);
printf("   Redaman Splice      : %d × %.2f dB = %.2f dB\n",
    $jumlahSplice, $spliceLoss, $redamanSplice);

// 3. Mux + Demux
$totalMuxDemux = $muxLoss + $demuxLoss;
printf("3. Mux + Demux         : %.2f + %.2f = %.2f dB\n",
    $muxLoss, $demuxLoss, $totalMuxDemux);

// 4. Konektor
$totalKonektor = $konektor * $konektorLoss;
printf("4. Konektor            : %d × %.2f dB = %.2f dB\n",
    $konektor, $konektorLoss, $totalKonektor);

// 5. Margin
printf("5. Margin              : %.2f dB\n", $margin);

// 6. Total redaman
$totalRedaman = $redamanFiber + $redamanSplice + $totalMuxDemux + $totalKonektor + $margin;
printf("\n   TOTAL REDAMAN       : %.2f dB\n", $totalRedaman);

// 7. Rx Power
$rxPower = $txPower - $totalRedaman;
printf("   Rx Power            : %.2f dBm - %.2f dB = %.2f dBm\n",
    $txPower, $totalRedaman, $rxPower);

// 8. Margin tersisa
$marginTersisa = $rxPower - $rxSensitivity;
printf("   Margin Tersisa      : %.2f dBm - (%.2f dBm) = %.2f dB\n",
    $rxPower, $rxSensitivity, $marginTersisa);

// ============ KESIMPULAN ============
echo "\n📊 KESIMPULAN LINK\n";
echo str_repeat("-", 55) . "\n";

if ($rxPower >= $rxSensitivity) {
    echo "✅ LINK LAYAK\n";
    printf("   Sinyal diterima: %.2f dBm ≥ Sensitivitas: %.2f dBm\n",
        $rxPower, $rxSensitivity);
    printf("   Margin tersisa: %.2f dB\n", $marginTersisa);
} else {
    echo "❌ LINK TIDAK LAYAK\n";
    printf("   Sinyal diterima: %.2f dBm < Sensitivitas: %.2f dBm\n",
        $rxPower, $rxSensitivity);
    printf("   Kekurangan: %.2f dB\n", abs($marginTersisa));
}

// ============ KANAL DWDM ============
echo "\n📡 PERENCANAAN KANAL DWDM\n";
echo str_repeat("-", 55) . "\n";

$totalKanal = $kanalUtama + $kanalCadangan;
printf("Kanal Utama    : %d × %d Gbps\n", $kanalUtama, $kapasitasKanal);
printf("Kanal Cadangan : %d × %d Gbps\n", $kanalCadangan, $kapasitasKanal);
printf("Total Kanal    : %d kanal\n", $totalKanal);
printf("Total Kapasitas: %d Gbps\n", $totalKanal * $kapasitasKanal);

echo "\n📋 Alokasi Wavelength (Channel Spacing 100 GHz / 0.8 nm)\n";
echo str_repeat("-", 55) . "\n";

$wavelengthStart = 1550.00;
for ($i = 1; $i <= $totalKanal; $i++) {
    $wavelength = $wavelengthStart + (($i - 1) * 0.8);
    $tipe = $i <= $kanalUtama ? 'Utama' : 'Cadangan';
    printf("  Kanal %d : %.2f nm (%s)\n", $i, $wavelength, $tipe);
}

// ============ CATATAN RISIKO ============
echo "\n⚠️  CATATAN RISIKO\n";
echo str_repeat("-", 55) . "\n";

if ($marginTersisa < 2) {
    echo "Margin tersisa sangat tipis (< 2 dB). Berisiko saat:\n";
    echo "  - Suhu kabel berubah ekstrem\n";
    echo "  - Konektor kotor / aging\n";
    echo "  - Fiber menua\n";
    echo "\nREKOMENDASI:\n";
    echo "  - Tambahkan EDFA (Erbium-Doped Fiber Amplifier)\n";
    echo "  - Perbaiki kualitas konektor (gunakan UPC/APC)\n";
    echo "  - Pertimbangkan repeater di tengah jalur\n";
} elseif ($marginTersisa < 5) {
    echo "Margin tersisa cukup, namun tetap pantau kualitas link.\n";
} else {
    echo "Margin tersisa aman untuk operasional jangka panjang.\n";
}

echo "\n======================================================\n";
echo "  SELESAI\n";
echo "======================================================\n";