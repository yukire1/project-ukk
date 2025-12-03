<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Domisili - {{ $surat->nama }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Arial', sans-serif;
      font-size: 12px;
      color: #000;
      line-height: 1.6;
    }

    .container {
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #333;
      padding-bottom: 15px;
    }

    .header-title {
      font-size: 14px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .header-subtitle {
      font-size: 16px;
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 10px;
    }

    .header-number {
      font-size: 12px;
      margin-bottom: 5px;
    }

    .content {
      margin-bottom: 20px;
    }

    .section {
      margin-bottom: 15px;
    }

    .section-title {
      font-weight: bold;
      margin-bottom: 10px;
      font-size: 13px;
    }

    .info-row {
      display: flex;
      margin-bottom: 8px;
    }

    .info-label {
      width: 150px;
      font-weight: bold;
    }

    .info-value {
      flex: 1;
    }

    .address-box {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
      background-color: #f9f9f9;
      min-height: 50px;
    }

    .signature-section {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
    }

    .signature-box {
      width: 40%;
      text-align: center;
    }

    .signature-line {
      border-top: 1px solid #000;
      margin-top: 50px;
      padding-top: 5px;
      font-weight: bold;
    }

    .footer {
      margin-top: 20px;
      font-size: 11px;
      text-align: center;
      color: #666;
    }

    .stamp-area {
      width: 50%;
      text-align: center;
      border: 2px dashed #999;
      padding: 20px;
      margin: 20px auto;
      min-height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #999;
    }
  </style>
</head>
<body>
  <div class="container">
    {{-- HEADER --}}
    <div class="header">
      <div class="header-title">PEMERINTAH DESA</div>
      <div class="header-subtitle">SURAT DOMISILI</div>
      <div class="header-number">
        Nomor: {{ $surat->nomor_surat ?? '___/DOM/' . date('Y') }}
      </div>
    </div>

    {{-- PEMBUKAAN --}}
    <div class="content">
      <div class="section">
        <p style="text-align: justify;">
          Yang bertanda tangan di bawah ini, Kepala Desa / Perangkat Desa, menerangkan bahwa:
        </p>
      </div>

      {{-- DATA DIRI --}}
      <div class="section">
        <div class="section-title">DATA PRIBADI</div>
        <div class="info-row">
          <div class="info-label">Nama</div>
          <div class="info-value">: {{ $surat->nama }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">NIK</div>
          <div class="info-value">: {{ $surat->nik }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">Tanggal Lahir</div>
          <div class="info-value">: ___________________________</div>
        </div>
      </div>

      {{-- ALAMAT LAMA --}}
      <div class="section">
        <div class="section-title">ALAMAT LAMA (ASAL)</div>
        <div class="address-box">
          {{ $surat->alamat_lama }}
        </div>
      </div>

      {{-- ALAMAT BARU --}}
      <div class="section">
        <div class="section-title">ALAMAT BARU (TUJUAN PINDAH)</div>
        <div class="address-box">
          {{ $surat->alamat_baru }}
        </div>
      </div>

      {{-- KETERANGAN PINDAH --}}
      <div class="section">
        <div class="info-row">
          <div class="info-label">Alasan Pindah</div>
          <div class="info-value">: {{ $surat->alasan_pindah }}</div>
        </div>
        <div class="info-row">
          <div class="info-label">Tanggal Pindah</div>
          <div class="info-value">: {{ $surat->tanggal_pindah?->format('d-m-Y') ?? '_______________' }}</div>
        </div>
      </div>

      {{-- CATATAN --}}
      @if($surat->catatan)
        <div class="section">
          <div class="section-title">KETERANGAN TAMBAHAN</div>
          <div class="address-box">
            {{ $surat->catatan }}
          </div>
        </div>
      @endif

      {{-- PENUTUP --}}
      <div class="section" style="margin-top: 20px;">
        <p style="text-align: justify;">
          Demikian surat domisili ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
        </p>
      </div>
    </div>

    {{-- TTANGAN & STEMPEL --}}
    <div class="signature-section">
      <div class="signature-box">
        <div style="font-size: 11px; margin-bottom: 20px;">Diketahui,</div>
        <div style="margin-top: 50px;">________________________</div>
        <div style="font-size: 10px; margin-top: 5px;">Kepala Desa</div>
      </div>
      <div class="stamp-area">
        STEMPEL
      </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
      <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
      <p>Status Layanan: {{ $layanan->status }}</p>
    </div>
  </div>
</body>
</html>