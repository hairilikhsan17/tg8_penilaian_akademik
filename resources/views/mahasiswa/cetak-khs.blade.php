<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHS - Kartu Hasil Studi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            @page {
                margin: 1.5cm;
                size: A4 portrait;
            }
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: bold;
        }
        .header p {
            margin: 3px 0;
            font-size: 11px;
        }
        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #000;
        }
        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-section td {
            padding: 5px 10px;
            border: none;
        }
        .info-section td.label {
            width: 150px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 10px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-left {
            text-align: left;
        }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .footer-left {
            text-align: left;
        }
        .footer-right {
            text-align: right;
        }
        .signature {
            margin-top: 40px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            border: none;
            padding: 5px;
            text-align: center;
        }
        .ipk-box {
            display: inline-block;
            padding: 8px 15px;
            border: 2px solid #000;
            font-weight: bold;
            font-size: 14px;
            margin-left: 10px;
        }
        .no-print {
            margin-bottom: 20px;
            text-align: center;
        }
        .no-print button {
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
        }
        .no-print button:hover {
            background-color: #2563eb;
        }
        .bg-gray {
            background-color: #f5f5f5;
        }
        @media screen {
            body {
                padding: 20px;
                background-color: #f5f5f5;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="padding: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin-right: 10px;">
            <i class="fas fa-print"></i> Cetak / Print
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <div class="header">
        <h1>UNIVERSITAS [NAMA UNIVERSITAS]</h1>
        <h2>KARTU HASIL STUDI (KHS)</h2>
        <p>Tanggal Cetak: {{ date('d F Y, H:i:s') }}</p>
    </div>

    <!-- Informasi Mahasiswa -->
    <div class="info-section">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $mahasiswa->nama_user ?? '-' }}</td>
                <td class="label" style="width: 150px;">IPK</td>
                <td>: <span class="ipk-box">{{ number_format($ipk, 2) }}</span></td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td>: {{ $mahasiswa->nim ?? '-' }}</td>
                <td class="label">Total SKS</td>
                <td>: {{ $totalSKS }} SKS</td>
            </tr>
            <tr>
                <td class="label">Program Studi</td>
                <td>: {{ $mahasiswa->jurusan ?? '-' }}</td>
                <td class="label">Total Mata Kuliah</td>
                <td>: {{ $nilai->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Tabel Nilai -->
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 80px;" class="text-left">Kode MK</th>
                <th class="text-left">Mata Kuliah</th>
                <th style="width: 60px;">Semester</th>
                <th style="width: 40px;">SKS</th>
                <th style="width: 70px;">Nilai Akhir</th>
                <th style="width: 70px;">Huruf Mutu</th>
                <th style="width: 70px;">Bobot</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalSKSRow = 0;
                $totalBobotRow = 0;
            @endphp
            @forelse($nilai as $index => $item)
            @php
                $sks = $item->matakuliah->sks ?? 0;
                $nilaiAkhir = $item->nilai_akhir ?? 0;
                $hurufMutu = $item->huruf_mutu ?? '';
                
                // Konversi huruf mutu ke bobot
                if ($hurufMutu) {
                    $bobot = \App\Models\InputNilaiModel::hurufMutuToBobot($hurufMutu);
                } else {
                    // Jika belum ada huruf mutu, hitung dari nilai akhir
                    $hurufMutuDariNilai = '';
                    if ($nilaiAkhir >= 90) $hurufMutuDariNilai = 'A';
                    elseif ($nilaiAkhir >= 85) $hurufMutuDariNilai = 'A-';
                    elseif ($nilaiAkhir >= 80) $hurufMutuDariNilai = 'B+';
                    elseif ($nilaiAkhir >= 75) $hurufMutuDariNilai = 'B';
                    elseif ($nilaiAkhir >= 70) $hurufMutuDariNilai = 'B-';
                    elseif ($nilaiAkhir >= 65) $hurufMutuDariNilai = 'C+';
                    elseif ($nilaiAkhir >= 60) $hurufMutuDariNilai = 'C';
                    elseif ($nilaiAkhir >= 55) $hurufMutuDariNilai = 'C-';
                    elseif ($nilaiAkhir >= 50) $hurufMutuDariNilai = 'D';
                    else $hurufMutuDariNilai = 'E';
                    $bobot = \App\Models\InputNilaiModel::hurufMutuToBobot($hurufMutuDariNilai);
                }
                
                $nilaiKualitas = $sks * $bobot;
                $totalSKSRow += $sks;
                $totalBobotRow += $nilaiKualitas;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $item->matakuliah->kode_mk ?? '-' }}</td>
                <td class="text-left">{{ $item->matakuliah->nama_mk ?? '-' }}</td>
                <td>{{ $item->matakuliah->semester ?? '-' }}</td>
                <td>{{ $sks }}</td>
                <td>{{ $nilaiAkhir > 0 ? number_format($nilaiAkhir, 2) : '-' }}</td>
                <td><strong>{{ $hurufMutu ?: '-' }}</strong></td>
                <td>{{ $nilaiKualitas > 0 ? number_format($nilaiKualitas, 2) : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">
                    Tidak ada data nilai
                </td>
            </tr>
            @endforelse
            @if($nilai->count() > 0)
            <tr class="bg-gray">
                <td></td>
                <td></td>
                <td></td>
                <td><strong>TOTAL</strong></td>
                <td><strong>{{ $totalSKSRow }}</strong></td>
                <td><strong>--</strong></td>
                <td><strong>--</strong></td>
                <td><strong>{{ number_format($totalBobotRow, 2) }}</strong></td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Keterangan -->
    <div style="margin-top: 20px; font-size: 10px;">
        <p><strong>Keterangan:</strong></p>
        <p>Nilai Mutu: A = 4.00 (≥90), A- = 3.75 (85-89), B+ = 3.50 (80-84), B = 3.00 (75-79), B- = 2.75 (70-74), C+ = 2.50 (65-69), C = 2.00 (60-64), C- = 1.75 (55-59), D = 1.00 (50-54), E = 0.00 (<50)</p>
        <p>IPK (Indeks Prestasi Kumulatif) = Total (SKS × Nilai Mutu) / Total SKS</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <table class="signature-table">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%;">
                    <p>Mengetahui,</p>
                    <p style="margin-top: 50px;">_______________________</p>
                    <p style="margin-top: 5px;"><strong>Ketua Program Studi</strong></p>
                    <p style="margin-top: 5px;">NIP. ...................</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="footer-left">
            <p style="font-size: 9px;">Catatan: Dokumen ini dicetak secara elektronik dan berlaku tanpa tanda tangan basah</p>
        </div>
        <div class="footer-right">
            <p style="font-size: 9px;">Dicetak pada: {{ date('d F Y, H:i:s') }}</p>
        </div>
    </div>

    <script>
        // Optional: Auto print when page loads (uncomment if needed)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>
