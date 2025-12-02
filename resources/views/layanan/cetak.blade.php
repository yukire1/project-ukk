<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Surat Domisili - {{ $surat->nama }}</title>
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size:12px; color:#000; }
    .header { text-align: center; margin-bottom: 20px; }
    .title { font-size:16px; font-weight:bold; text-decoration:underline; }
    .meta { margin-top:10px; margin-bottom:20px; }
    .section { margin-bottom:12px; }
    .sign { margin-top:40px; text-align:right; }
  </style>
</head>
<body>
  <div class="header">
    <div><strong>PEMERINTAH DESA / KECAMATAN / KABUPATEN</strong></div>
    <div class="title">SURAT DOMISILI</div>
    <div class="meta">Nomor: {{ $surat->nomor_surat ?? '-' }}</div>
  </div>

  <div class="section">
    <strong>Yang bertanda tangan di bawah ini menerangkan bahwa:</strong>
    <table>
      <tr><td style="width:150px">Nama</td><td>: {{ $surat->nama }}</td></tr>
      <tr><td>NIK</td><td>: {{ $surat->nik }}</td></tr>
      <tr><td>Alamat Lama</td><td>: {{ $surat->alamat_lama }}</td></tr>
      <tr><td>Alamat Baru</td><td>: {{ $surat->alamat_baru }}</td></tr>
      <tr><td>Alasan Pindah</td><td>: {{ $surat->alasan_pindah }}</td></tr>
      <tr><td>Tanggal Pindah</td><td>: {{ $surat->tanggal_pindah?->format('d-m-Y') ?? '-' }}</td></tr>
    </table>
  </div>

  <div class="section">
    <strong>Keterangan Lain:</strong>
    <p>{{ $surat->catatan ?? '-' }}</p>
  </div>

  <div class="sign">
    <div>{{ config('app.name') }}, {{ now()->format('d-m-Y') }}</div>
    <div style="margin-top:60px">__________________________</div>
    <div>Pejabat yang Menandatangani</div>
  </div>
</body>
</html>