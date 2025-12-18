<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nilai</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            @page {
                margin: 1cm;
                size: A4 landscape;
            }
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 9px;
        }
        td {
            font-size: 9px;
        }
        .text-left {
            text-align: left;
        }
        .bg-blue { background-color: #dbeafe; }
        .bg-green { background-color: #dcfce7; }
        .bg-purple { background-color: #f3e8ff; }
        .bg-indigo { background-color: #e0e7ff; }
        .bg-orange { background-color: #fed7aa; }
        .bg-red { background-color: #fee2e2; }
        .bg-yellow { background-color: #fef9c3; }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
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
    <div class="no-print" style="margin-bottom: 20px; text-align: center; padding: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin-right: 10px;">
            <i class="fas fa-print"></i> Cetak / Print
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <div class="header">
        <h1>LAPORAN NILAI MAHASISWA</h1>
        <p>Sistem Penilaian Akademik</p>
        @if(!empty($filterInfo))
            <p>Filter: {{ implode(' - ', $filterInfo) }}</p>
        @endif
        <p>Tanggal Cetak: {{ date('d F Y, H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 80px;" class="text-left">Kode MK</th>
                <th style="width: 150px;" class="text-left">Mata Kuliah</th>
                <th style="width: 50px;">Semester</th>
                <th style="width: 80px;" class="text-left">NIM</th>
                <th style="width: 120px;" class="text-left">Nama Mahasiswa</th>
                <th style="width: 50px;" class="bg-blue">Hadir</th>
                @if($maxTugas > 0)
                @for($i = 1; $i <= $maxTugas; $i++)
                <th style="width: 50px;" class="bg-green">Tugas {{ $i }}</th>
                @endfor
                @endif
                <th style="width: 50px;" class="bg-purple">Quiz</th>
                @if($maxProject > 0)
                @for($i = 1; $i <= $maxProject; $i++)
                <th style="width: 50px;" class="bg-indigo">Project {{ $i }}</th>
                @endfor
                @endif
                <th style="width: 50px;" class="bg-orange">UTS</th>
                <th style="width: 50px;" class="bg-red">UAS</th>
                <th style="width: 60px;" class="bg-blue">Nilai Hadir</th>
                <th style="width: 60px;" class="bg-green">Nilai Tugas</th>
                <th style="width: 60px;" class="bg-indigo">Nilai Project</th>
                <th style="width: 60px;" class="bg-red">Nilai Final (UAS)</th>
                <th style="width: 60px;" class="bg-purple">Nilai Quiz</th>
                <th style="width: 60px;" class="bg-orange">Nilai UTS</th>
                <th style="width: 60px;" class="bg-yellow">Nilai Akhir</th>
                <th style="width: 60px;" class="bg-yellow">Huruf Mutu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilai as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $item->matakuliah->kode_mk ?? '-' }}</td>
                <td class="text-left">{{ $item->matakuliah->nama_mk ?? '-' }}</td>
                <td>{{ $item->matakuliah->semester ?? '-' }}</td>
                <td class="text-left">{{ $item->mahasiswa->nim ?? '-' }}</td>
                <td class="text-left">{{ $item->mahasiswa->nama_user ?? '-' }}</td>
                <td class="bg-blue">{{ $item->kehadiran ? number_format($item->kehadiran, 2) : '-' }}</td>
                @php
                    $tugasArray = [];
                    if ($item->tugas) {
                        if (is_string($item->tugas)) {
                            $decoded = json_decode($item->tugas, true);
                            $tugasArray = is_array($decoded) ? $decoded : [];
                        } elseif (is_array($item->tugas)) {
                            $tugasArray = $item->tugas;
                        } else {
                            $tugasArray = [(float)$item->tugas];
                        }
                    }
                @endphp
                @if($maxTugas > 0)
                @for($i = 0; $i < $maxTugas; $i++)
                <td class="bg-green">
                    {{ isset($tugasArray[$i]) && $tugasArray[$i] !== null && $tugasArray[$i] !== '' ? number_format((float)$tugasArray[$i], 2) : '-' }}
                </td>
                @endfor
                @endif
                <td class="bg-purple">{{ $item->kuis ? number_format($item->kuis, 2) : '-' }}</td>
                @php
                    $projectArray = [];
                    if ($item->project) {
                        if (is_string($item->project)) {
                            $decoded = json_decode($item->project, true);
                            $projectArray = is_array($decoded) ? $decoded : [];
                        } elseif (is_array($item->project)) {
                            $projectArray = $item->project;
                        } else {
                            $projectArray = [(float)$item->project];
                        }
                    }
                @endphp
                @if($maxProject > 0)
                @for($i = 0; $i < $maxProject; $i++)
                <td class="bg-indigo">
                    {{ isset($projectArray[$i]) && $projectArray[$i] !== null && $projectArray[$i] !== '' ? number_format((float)$projectArray[$i], 2) : '-' }}
                </td>
                @endfor
                @endif
                <td class="bg-orange">{{ $item->uts ? number_format($item->uts, 2) : '-' }}</td>
                <td class="bg-red">{{ $item->uas ? number_format($item->uas, 2) : '-' }}</td>
                @php
                    // Hitung nilai rekap berdasarkan input nilai dan bobot penilaian
                    // Sama persis dengan perhitungan di halaman Input Nilai
                    $komponenItem = $item->matakuliah->komponenPenilaian ?? null;
                    
                    // Calculate average for Tugas (hanya nilai yang sudah diisi)
                    $rataRataTugas = 0;
                    $tugasCount = 0;
                    if (!empty($tugasArray)) {
                        foreach ($tugasArray as $tugasVal) {
                            if ($tugasVal !== null && $tugasVal !== '' && is_numeric($tugasVal)) {
                                $rataRataTugas += (float)$tugasVal;
                                $tugasCount++;
                            }
                        }
                        if ($tugasCount > 0) {
                            $rataRataTugas = $rataRataTugas / $tugasCount;
                        } else {
                            $rataRataTugas = 0;
                        }
                    }
                    
                    // Calculate average for Project (hanya nilai yang sudah diisi)
                    $rataRataProject = 0;
                    $projectCount = 0;
                    if (!empty($projectArray)) {
                        foreach ($projectArray as $projectVal) {
                            if ($projectVal !== null && $projectVal !== '' && is_numeric($projectVal)) {
                                $rataRataProject += (float)$projectVal;
                                $projectCount++;
                            }
                        }
                        if ($projectCount > 0) {
                            $rataRataProject = $rataRataProject / $projectCount;
                        } else {
                            $rataRataProject = 0;
                        }
                    }
                    
                    // Hitung semua nilai rekap
                    $nilaiHadirValue = 0;
                    $nilaiTugasValue = 0;
                    $nilaiProjectValue = 0;
                    $nilaiFinalValue = 0;
                    $nilaiQuizValue = 0;
                    $nilaiUtsValue = 0;
                    
                    if ($komponenItem) {
                        // Nilai Hadir: (kehadiran_input / 25) * bobot_kehadiran
                        $kehadiranInput = $item->kehadiran ?? 0;
                        $bobotKehadiran = $komponenItem->kehadiran ?? 0;
                        if ($kehadiranInput > 0 && $bobotKehadiran > 0) {
                            $nilaiHadirValue = ($kehadiranInput / 25) * $bobotKehadiran;
                        }
                        
                        // Nilai Tugas: (rata-rata_tugas / 100) * bobot_tugas
                        $bobotTugas = $komponenItem->tugas ?? 0;
                        if ($rataRataTugas > 0 && $bobotTugas > 0) {
                            $nilaiTugasValue = ($rataRataTugas / 100) * $bobotTugas;
                        }
                        
                        // Nilai Project: (rata-rata_project / 100) * bobot_project
                        $bobotProject = $komponenItem->project ?? 0;
                        if ($rataRataProject > 0 && $bobotProject > 0) {
                            $nilaiProjectValue = ($rataRataProject / 100) * $bobotProject;
                        }
                        
                        // Nilai Final (UAS): (uas_input / 100) * bobot_uas
                        $uasInput = $item->uas ?? 0;
                        $bobotUas = $komponenItem->uas ?? 0;
                        if ($uasInput > 0 && $bobotUas > 0) {
                            $nilaiFinalValue = ($uasInput / 100) * $bobotUas;
                        }
                        
                        // Nilai Quiz: (kuis_input / 100) * bobot_kuis
                        $kuisInput = $item->kuis ?? 0;
                        $bobotKuis = $komponenItem->kuis ?? 0;
                        if ($kuisInput > 0 && $bobotKuis > 0) {
                            $nilaiQuizValue = ($kuisInput / 100) * $bobotKuis;
                        }
                        
                        // Nilai UTS: (uts_input / 100) * bobot_uts
                        $utsInput = $item->uts ?? 0;
                        $bobotUts = $komponenItem->uts ?? 0;
                        if ($utsInput > 0 && $bobotUts > 0) {
                            $nilaiUtsValue = ($utsInput / 100) * $bobotUts;
                        }
                    }
                    
                    // Hitung nilai akhir dengan menjumlahkan semua nilai rekap
                    // Sama dengan perhitungan di halaman Input Nilai
                    $nilaiAkhirBaru = $nilaiHadirValue + $nilaiTugasValue + $nilaiProjectValue + $nilaiFinalValue + $nilaiQuizValue + $nilaiUtsValue;
                @endphp
                <td class="bg-blue"><strong>{{ $nilaiHadirValue > 0 ? number_format($nilaiHadirValue, 1) : '-' }}</strong></td>
                <td class="bg-green"><strong>{{ $nilaiTugasValue > 0 ? number_format($nilaiTugasValue, 1) : '-' }}</strong></td>
                <td class="bg-indigo"><strong>{{ $nilaiProjectValue > 0 ? number_format($nilaiProjectValue, 1) : '-' }}</strong></td>
                <td class="bg-red"><strong>{{ $nilaiFinalValue > 0 ? number_format($nilaiFinalValue, 1) : '-' }}</strong></td>
                <td class="bg-purple"><strong>{{ $nilaiQuizValue > 0 ? number_format($nilaiQuizValue, 1) : '-' }}</strong></td>
                <td class="bg-orange"><strong>{{ $nilaiUtsValue > 0 ? number_format($nilaiUtsValue, 1) : '-' }}</strong></td>
                <td class="bg-yellow"><strong>{{ $nilaiAkhirBaru > 0 ? number_format($nilaiAkhirBaru, 2) : '-' }}</strong></td>
                <td class="bg-yellow"><strong>{{ $item->huruf_mutu ?? '-' }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ 6 + ($maxTugas ?? 1) + 1 + ($maxProject ?? 1) + 10 }}" style="text-align: center; padding: 20px;">
                    Tidak ada data nilai
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y, H:i:s') }}</p>
        <p>Total Data: {{ $nilai->count() }} nilai</p>
    </div>

    <script>
        // Auto focus on print button when page loads
        window.onload = function() {
            // Optional: Auto print (uncomment if needed)
            // window.print();
        };
    </script>
</body>
</html>
