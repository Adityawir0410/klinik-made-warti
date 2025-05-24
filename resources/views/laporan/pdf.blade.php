<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - {{ $periode }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 40px;
        }
        h1, h2, h3 {
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header h2 {
            font-size: 16px;
            margin-bottom: 4px;
        }
        .header p {
            font-size: 11px;
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            font-size: 11px;
        }
        th {
            background-color: #f0f0f0;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 40px;
            font-size: 11px;
        }
        .footer .ttd {
            margin-top: 40px;
            text-align: right;
        }
        .footer .ttd p {
            margin-bottom: 60px;
        }
        .note {
            font-style: italic;
            font-size: 10px;
            margin-top: 20px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .page-number {
            margin-top: 80px;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Klinik Bidan Made Warti</h2>
        <p>Jl. Sunan Giri 1 No. 6, Kebomas, Gresik</p>
        <p>Tel: +62 812 3456 7890 | Email: info@klinikbidanmade.id</p>
    </div>

    <h3 class="text-center">LAPORAN KEUANGAN</h3>
    <p class="text-center"><strong>Periode: {{ $periode }}</strong></p>

    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pasien</th>
                <th>Keluhan</th>
                <th class="text-right">Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $rekam)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($rekam->tanggal_kunjungan)->translatedFormat('d M Y') }}</td>
                    <td>{{ $rekam->pasien->nama_pasien }}</td>
                    <td>{{ $rekam->keluhan }}</td>
                    <td class="text-right">Rp {{ number_format($rekam->biaya, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-center">Total</td>
                <td class="text-right">Rp {{ number_format($data->sum('biaya'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Gresik, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Pimpinan</p>
            <p style="font-weight: bold;">(Made Warti)</p>
        </div>

        <p class="note">* Dokumen ini adalah laporan keuangan resmi dan sudah terverifikasi secara digital</p>
        <p class="note">Dicetak pada: {{ $tanggal_cetak }}</p>
    </div>

    <p class="page-number">Halaman 1 dari 1</p>

</body>
</html>
