<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat {{ ucfirst($surat->jenis) }}</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            margin: 40px;
            line-height: 1.6;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .kop-surat h2 {
            margin: 0;
        }
        .isi-surat {
            text-align: justify;
            margin-top: 20px;
        }
        .ttd {
            margin-top: 60px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>HIMPUNAN MAHASISWA TEKNIK INFORMATIKA</h2>
        <p>Universitas XYZ</p>
        <small>Jl. Pendidikan No. 10, Riau</small>
    </div>

    <div class="isi-surat">
        <p>Kepada Yth:</p>
        <p><strong>{{ $surat->kepada }}</strong></p>
        <br>

        <p>{{ $surat->isi }}</p>

        <br>
        <p>Demikian surat ini kami sampaikan. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>
    </div>

    <div class="ttd">
        <p>Hormat kami,</p>
        <p><strong>{{ $surat->penanggung_jawab }}</strong></p>
        <small>{{ $surat->tanggal }}</small>
    </div>
</body>
</html>
