<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kontribusi Reviewer</title>
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
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            padding: 30px 40px;
            text-align: center;
            border-bottom: 4px solid #047857;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .header p {
            color: #d1fae5;
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
            color: #047857;
        }
        .main-text {
            text-align: justify;
            margin-bottom: 20px;
            font-size: 15px;
        }
        .certificate-info {
            background-color: #f0fdf4;
            border: 2px solid #bbf7d0;
            border-left: 5px solid #059669;
            padding: 25px;
            margin: 25px 0;
            border-radius: 4px;
            text-align: center;
        }
        .certificate-info h3 {
            color: #047857;
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .certificate-info p {
            margin: 8px 0;
            font-size: 15px;
        }
        .points-box {
            background-color: #fef3c7;
            border: 2px solid #fbbf24;
            border-radius: 4px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .points-box h4 {
            color: #92400e;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .points-value {
            font-size: 32px;
            font-weight: bold;
            color: #b45309;
            margin: 10px 0;
        }
        .dashboard-box {
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-left: 5px solid #3b82f6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .dashboard-box h4 {
            color: #1e40af;
            margin: 0 0 15px 0;
            font-size: 16px;
        }
        .info-table {
            width: 100%;
            margin: 15px 0;
        }
        .info-table td {
            padding: 8px 0;
            font-size: 14px;
        }
        .info-table td:first-child {
            font-weight: 600;
            color: #334155;
            width: 130px;
        }
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            margin: 15px 0;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 2px 4px rgba(37,99,235,0.3);
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            box-shadow: 0 4px 8px rgba(37,99,235,0.4);
        }
        .features-list {
            background-color: #fefce8;
            border: 1px solid #fde047;
            border-radius: 4px;
            padding: 20px 20px 10px 40px;
            margin: 20px 0;
        }
        .features-list ul {
            margin: 0;
            padding: 0;
        }
        .features-list li {
            margin: 10px 0;
            font-size: 15px;
            color: #713f12;
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
        .team-name {
            font-weight: 600;
            color: #047857;
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
        hr {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 25px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>📜 Sertifikat Kontribusi Reviewer</h1>
            <p>Penghargaan atas Dedikasi dalam Penelaahan Karya Ilmiah</p>
        </div>
        
        <div class="content">
            <div class="salutation">
                <p>Kepada Yth.<br>
                <span class="recipient-name">{{ $data['name'] ?? 'Reviewer' }}</span><br>
            </div>
            
            <p class="main-text">
                Dengan hormat,
            </p>
            
            <p class="main-text">
                Kami mengucapkan terima kasih yang sebesar-besarnya atas kontribusi Bapak/Ibu sebagai <strong>Reviewer</strong> dalam proses penelaahan naskah ilmiah pada sistem manajemen jurnal kami. Dedikasi dan keahlian Bapak/Ibu sangat berharga dalam menjaga kualitas dan integritas publikasi ilmiah.
            </p>
            
            <div class="certificate-info">
                <h3>🏆 Sertifikat Penghargaan</h3>
                <p>Terlampir dalam email ini adalah <strong>Sertifikat Kontribusi</strong> sebagai bentuk apresiasi atas partisipasi aktif Bapak/Ibu dalam proses peer review.</p>
            </div>
            
            <hr>
            
            <div class="dashboard-box">
                <h4>🔐 Akses Dashboard Reviewer</h4>
                <p style="font-size: 14px; color: #475569; margin-bottom: 15px;">
                    Untuk melihat akumulasi poin, riwayat review, dan mengunduh sertifikat lainnya, silakan login ke dashboard reviewer Anda:
                </p>
                
                <table class="info-table">
                    <tr>
                        <td>Portal Website</td>
                        <td>: {{ $data['app_url'] ?? config('app.url') }}</td>
                    </tr>
                    <tr>
                        <td>Email Terdaftar</td>
                        <td>: {{ $data['email'] ?? 'your-email@example.com' }}</td>
                    </tr>
                </table>
                
                <p style="text-align: center; margin-top: 20px;">
                    <a href="{{ $data['login_url'] ?? config('app.url') }}" class="btn">Login ke Dashboard</a>
                </p>
            </div>
            
            <div class="features-list">
                <p style="font-weight: 600; color: #713f12; margin-bottom: 10px;">Di dalam dashboard, Bapak/Ibu dapat:</p>
                <ul>
                    <li>Mengunduh semua sertifikat kontribusi</li>
                    <li>Melacak riwayat aktivitas review</li>
                    <li>Memperbarui informasi profil dan afiliasi</li>
                    <li>Melihat statistik kontribusi reviewer</li>
                </ul>
            </div>
            
            <p class="main-text">
                Sekali lagi, kami menyampaikan apresiasi yang tinggi atas kontribusi Bapak/Ibu dalam proses penelaahan naskah. Ketelitian dan profesionalitas Bapak/Ibu sangat membantu dalam menjaga standar kualitas publikasi ilmiah kami.
            </p>
            
            <hr>
            
            <div class="signature">
                <p class="regards">Hormat kami,</p>
                <p class="team-name">{{ config('app.name') }}</p>
                <p style="color: #64748b; font-size: 14px;">Tim Manajemen Jurnal Ilmiah</p>
            </div>
        </div>
        
        <div class="footer">
            <p><em>Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</em></p>
            @if(isset($data['support_email']))
            <p style="margin-top: 12px;">Butuh bantuan? Hubungi kami di <a href="mailto:{{ $data['support_email'] }}" style="color: #3b82f6; text-decoration: none;">{{ $data['support_email'] }}</a></p>
            @endif
            <p style="margin-top: 15px; color: #94a3b8;">© {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>