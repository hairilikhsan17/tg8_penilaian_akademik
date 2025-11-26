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
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.location.href='/dosen/laporan-nilai'" style="padding: 10px 20px; background-color: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            <i class="fas fa-print"></i> Cetak PDF
        </button>
        <button onclick="window.location.href='/dosen/laporan-nilai'" style="padding: 10px 20px; background-color: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 10px;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <div class="header">
        <h1>LAPORAN NILAI MAHASISWA</h1>
        <p>Sistem Penilaian Akademik</p>
        <p>Tanggal Cetak: <span id="printDate"></span></p>
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
                <th style="width: 50px;" class="bg-green">Tugas</th>
                <th style="width: 50px;" class="bg-purple">Quiz</th>
                <th style="width: 50px;" class="bg-indigo">Project</th>
                <th style="width: 50px;" class="bg-orange">UTS</th>
                <th style="width: 50px;" class="bg-red">UAS</th>
                <th style="width: 60px;" class="bg-yellow">Nilai Akhir</th>
                <th style="width: 60px;" class="bg-yellow">Huruf Mutu</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Data akan di-render oleh JavaScript -->
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: <span id="footerDate"></span></p>
        <p>Total Data: <span id="totalData">0</span> nilai</p>
    </div>

    
</body>
</html>
