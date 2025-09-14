<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Appreciation</title>
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
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e9ecef;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 12px;
            color: #6c757d;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .certificate-box {
            background-color: #d4edda;
            padding: 20px;
            border-left: 4px solid #28a745;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
        }
        .login-info {
            background-color: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 15px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    
    <div class="content">
        <p>Dear {{ $user->name ?? 'Reviewer' }},</p>
        
        <p>Thank you for your valuable contribution as a reviewer in our application review system. We are pleased to present you with a certificate of appreciation for your dedication and expertise.</p>
        
        
        <p>To view your accumulated points and access other certificates, please log in to your reviewer account:</p>
        
        <div class="login-info">
            <h4>📱 Access Your Reviewer Dashboard</h4>
            <p><strong>Website:</strong> {{ $app_url ?? config('app.url') }}</p>
            <p><strong>Your Email:</strong> {{ $user->email ?? 'your-email@example.com' }}</p>
            <p><strong>Login Steps:</strong></p>
            <ol>
                <li>Visit our website using the link above</li>
                <li>Click on "Login" or "Reviewer Login"</li>
                <li>Enter your registered email address</li>
                <li>Enter your password (reset password if needed)</li>
                <li>Access your dashboard to view points and certificates</li>
            </ol>
            <p style="text-align: center;">
                <a href="{{ $login_url ?? config('app.url') . '/login' }}" class="btn btn-primary">🔐 Login to Dashboard</a>
            </p>
        </div>
        
        <p>In your dashboard, you can:</p>
        <ul>
            <li>View your total reviewer points</li>
            <li>Download all your certificates</li>
            <li>Track your review history</li>
            <li>Update your profile information</li>
        </ul>
        
        <p>Thank you once again for your outstanding contribution to our review process.</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p>This is an automated certificate notification.</p>
        @if(isset($support_email))
        <p>Need help? Contact us at <a href="mailto:{{ $support_email }}">{{ $support_email }}</a></p>
        @endif
    </div>
</body>
</html>