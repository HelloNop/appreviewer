<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keputusan dan Sertifikat</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.8;
            color: #1a1a1a;
            max-width: 650px;
            margin: 0 auto;
            padding: 0;
            background-color: #f5f5f5;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 30px 40px;
            text-align: center;
            border-bottom: 4px solid #1e40af;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .header p {
            color: #e0e7ff;
            margin: 8px 0 0 0;
            font-size: 14px;
        }
        .content {
            padding: 40px;
            background-color: #ffffff;
        }
        .salutation {
            margin-bottom: 25px;
            font-size: 16px;
        }
        .recipient-name {
            font-weight: 600;
            color: #1e3a8a;
        }
        .main-text {
            text-align: justify;
            margin-bottom: 20px;
            font-size: 15px;
        }
        .info-box {
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-left: 5px solid #1e3a8a;
            padding: 20px;
            margin: 25px 0;
        }
        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-box td {
            padding: 8px 0;
            font-size: 15px;
        }
        .info-box td:first-child {
            font-weight: 600;
            color: #334155;
            width: 140px;
        }
        .info-box td:last-child {
            color: #1e3a8a;
            font-weight: 500;
        }
        .attachment-notice {
            background-color: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 4px;
            padding: 15px;
            margin: 25px 0;
            font-size: 14px;
        }
        .attachment-notice strong {
            color: #92400e;
        }
        .signature {
            margin-top: 35px;
            font-size: 15px;
        }
        .signature p {
            margin: 5px 0;
        }
        .regards {
            font-style: italic;
            color: #475569;
        }
        .publisher-name {
            font-weight: 600;
            color: #1e3a8a;
            margin-top: 10px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 25px 40px;
            text-align: center;
            border-top: 3px solid #e2e8f0;
            font-size: 13px;
            color: #64748b;
        }
        .footer p {
            margin: 8px 0;
        }
        .divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 25px 0;
        }
        hr {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ $brand ?? 'Penerbit Jurnal Ilmiah' }}</h1>
            <p>{{ $publisher ?? 'Publisher Name' }}</p>
        </div>
        
        <div class="content">
            <div class="salutation">
                <p>Kepada Yth.<br>
                <span class="recipient-name">{{ $user ?? 'Nama Penerima' }}</span><br>
                {{ $affiliation ?? 'Institusi' }}</p>
            </div>
            
            <p class="main-text">
                Dengan hormat,
            </p>
            
            <p class="main-text">
                Melalui surat elektronik ini, kami dengan senang hati menyampaikan bahwa Bapak/Ibu telah ditetapkan sebagai <strong>{{ $position }}</strong> pada jurnal ilmiah kami. Penetapan ini merupakan bentuk pengakuan dan apresiasi atas kompetensi akademik serta dedikasi Bapak/Ibu dalam pengembangan ilmu pengetahuan.
            </p>
            
            <div class="info-box">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $user ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>: {{ $position ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Jurnal</td>
                        <td>: {{ $journal ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor SK</td>
                        <td>: {{ $sk_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Penetapan</td>
                        <td>: {{ $tanggal_sk ?? date('d F Y') }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="attachment-notice">
                <strong>📎 Lampiran Dokumen:</strong><br>
                Terlampir dalam email ini adalah dokumen <strong>Surat Keputusan (SK)</strong> dan <strong>Sertifikat</strong> dalam format PDF. Mohon untuk menyimpan dokumen-dokumen tersebut dengan baik sebagai bukti resmi penugasan.
            </div>
            
            <p class="main-text">
                Kami berharap kerjasama ini dapat berjalan dengan baik dan berkontribusi positif terhadap peningkatan kualitas publikasi ilmiah. Apabila terdapat pertanyaan atau hal yang perlu didiskusikan, Bapak/Ibu dapat menghubungi kami melalui sistem manajemen jurnal.
            </p>
            
            <hr>
            
            <div class="signature">
                <p class="regards">Hormat kami,</p>
                <p class="publisher-name">{{ $brand ?? 'Tim Penerbit' }}</p>
                <p style="color: #64748b;">{{ $publisher ?? '' }}</p>
            </div>
        </div>
        
        <div class="footer">
            <p><em>Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</em></p>
            <p style="margin-top: 15px; color: #94a3b8;">© {{ date('Y') }} {{ $publisher ?? config('app.name') }}. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
