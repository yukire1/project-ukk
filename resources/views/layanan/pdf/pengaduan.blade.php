<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan</title>
    <style>
        * { margin: 0; padding: 0; }
        body { 
            font-family: 'Arial', sans-serif; 
            line-height: 1.6;
            margin: 20px;
            color: #000;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        .header h2 { margin-bottom: 5px; font-size: 18px; }
        .header p { font-size: 12px; }
        table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        td { padding: 8px; font-size: 12px; }
        .label { font-weight: bold; width: 25%; vertical-align: top; }
        .divider { border: 1px solid #ddd; padding: 10px; background: #f5f5f5; margin: 10px 0; min-height: 30px; font-size: 12px; }
        .signature { margin-top: 60px; text-align: right; font-size: 11px; }
        hr { border: none; border-top: 1px solid #000; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PENGADUAN</h2>
        <p>Nomor: {{ $layanan->id }}/ADU/{{ now()->format('Y') }}</p>
    </div>

    <div class="content">
        <table>
            <tr>
                <td class="label">Tanggal Pengaduan</td>
                <td>: {{ $layanan->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Judul</td>
                <td>: {{ $layanan->judul ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>: {{ $layanan->status ?? '-' }}</td>
            </tr>
        </table>

        <hr>

        <p><strong>Deskripsi Pengaduan:</strong></p>
        <div class="divider">
            {{ $layanan->deskripsi ?? '-' }}
        </div>

        @if($layanan->detail && isset($layanan->detail['lampiran']) && $layanan->detail['lampiran'])
            <p><strong>Lampiran:</strong></p>
            <div class="divider">
                {{ $layanan->detail['lampiran'] }}
            </div>
        @endif

        @if($layanan->keterangan)
            <p><strong>Keterangan Tambahan:</strong></p>
            <div class="divider">
                {{ $layanan->keterangan }}
            </div>
        @endif
    </div>

    <div class="signature">
        <p>Dibuat pada: {{ now()->format('d-m-Y H:i') }}</p>
        <br><br><br>
        <p>Petugas Pelayanan</p>
        <p>_____________________</p>
    </div>
</body>
</html>