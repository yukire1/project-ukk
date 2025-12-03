<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{ $layanan->jenis }}</title>
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size:12px; }
    .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 30px; }
    .title { font-size: 16px; font-weight: bold; }
    .content { margin-bottom: 20px; }
    .sign { margin-top: 50px; text-align: right; }
  </style>
</head>
<body>
  <div class="header">
    <div class="title">{{ $layanan->detail['jenis_surat'] ?? 'Surat Layanan Umum' }}</div>
  </div>

  <div class="content">
    <p><strong>Judul:</strong> {{ $layanan->judul }}</p>
    <p><strong>Tujuan Penggunaan:</strong></p>
    <p>{{ $layanan->detail['tujuan_penggunaan'] ?? '-' }}</p>
    <p><strong>Keterangan:</strong></p>
    <p>{{ $layanan->detail['keterangan_surat'] ?? $layanan->deskripsi ?? '-' }}</p>
    <p><strong>Tanggal Permohonan:</strong> {{ $layanan->created_at->format('d-m-Y') }}</p>
  </div>

  <div class="sign">
    <div style="margin-top: 60px;">________________________</div>
    <div>Mengetahui</div>
  </div>
</body>
</html>