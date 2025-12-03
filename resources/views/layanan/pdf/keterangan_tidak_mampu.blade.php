<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tidak Mampu</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; }
        .content { margin: 20px 0; }
        .signature { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SURAT KETERANGAN TIDAK MAMPU</h2>
        <p>Nomor: {{ $layanan->id }}/SKT/{{ now()->format('Y') }}</p>
    </div>

    <div class="content">
        <p>Desa/Kelurahan yang bertanda tangan di bawah ini menerangkan bahwa:</p>
        
        <table style="width: 100%; margin: 20px 0;">
            <tr>
                <td style="width: 30%;">Nama</td>
                <td style="width: 3%;">:</td>
                <td>{{ $layanan->detail['nama'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nomor KK</td>
                <td>:</td>
                <td>{{ $layanan->detail['no_kk'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alasan</td>
                <td>:</td>
                <td>{{ $layanan->detail['alasan'] ?? '-' }}</td>
            </tr>
        </table>

        <p>Dengan ini menerangkan bahwa orang tersebut di atas benar-benar tidak mampu secara ekonomi.</p>
        <p>Surat ini diberikan untuk keperluan: <strong>{{ $layanan->keterangan ?? '-' }}</strong></p>
    </div>

    <div class="signature">
        <p>Dibuat pada: {{ now()->format('d-m-Y') }}</p>
        <br><br><br>
        <p>Kepala Desa</p>
        <p>(__________________)</p>
    </div>
</body>
</html>