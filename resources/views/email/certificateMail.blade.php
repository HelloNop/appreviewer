<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Position</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            font-size: 14px;
            color: #6c757d;
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
     <div class="content">
         <p>Dear <span class="highlight">{{ $data['user_name'] ?? 'User' }}</span>,</p>
         
         <p>We are pleased to inform you that you have received a <strong>Certificate of Position</strong> for your contribution in:</p>
         
         <div style="background-color: #e7f3ff; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;">
             <p><strong>Journal:</strong> {{ $data['journal_title'] ?? 'N/A' }}</p>
             <p><strong>Position:</strong> {{ $data['position'] ?? 'N/A' }}</p>
         </div>
         
         <p>Your certificate has been attached to this email in PDF format. Please download and save the certificate for your documentation purposes.</p>
         
         <p>Thank you for your outstanding dedication and contribution!</p>
         
         <p>Best regards,<br>
         <strong>{{ $data['journal_title'] ?? 'N/A' }} Team</strong></p>
     </div>
     
     <div class="footer">
         <p>This email is sent automatically. Please do not reply to this email.</p>
         <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
     </div>
</body>
</html>
