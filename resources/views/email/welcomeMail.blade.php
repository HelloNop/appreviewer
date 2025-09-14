<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
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
        .credentials {
            background-color: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Welcome to {{ config('app.name') }}</h2>
    </div>
     
    <div class="content">
        <p>Dear <span class="highlight">{{ $data['name'] }}</span>,</p>
         
        <p>Welcome to {{ config('app.name') }}! Your account has been successfully created.</p>
         
        <p>Here are your login credentials:</p>
         
        <div class="credentials">
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Password:</strong> {{ $data['password'] }}</p>
            <p><strong>URL:</strong> {{ config('app.url') }}</p>
        </div>
         
        <p>Please login to your account and change your password as soon as possible for security reasons.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ config('app.url') . '/admin/login' }}" style="background-color: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;">Login to Your Account</a>
        </div>
         
        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
         
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>
     
    <div class="footer">
        <p>This email is sent automatically. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>