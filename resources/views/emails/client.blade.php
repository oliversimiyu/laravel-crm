<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Client Communication</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #1e293b;
            padding: 30px 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6c757d;
            background-color: #f1f3f5;
            border-top: 1px solid #e9ecef;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.1);
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
        }
        .message {
            margin: 25px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 500;
        }
        .contact-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        .social-links {
            margin-top: 15px;
        }
        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #3b82f6;
            text-decoration: none;
        }
        .greeting {
            font-size: 18px;
            font-weight: 500;
            color: #1e293b;
        }
        .signature {
            margin-top: 30px;
        }
        .signature-name {
            font-weight: 600;
            color: #1e293b;
        }
        .signature-title {
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
        </div>
        
        <div class="content">
            <p class="greeting">Dear {{ $customer->first_name }} {{ $customer->last_name }},</p>
            
            <div class="message">
                {!! nl2br(e($emailMessage)) !!}
            </div>
            
            <p>If you have any questions or need further assistance, please don't hesitate to contact us.</p>
            
            <div class="signature">
                <p class="signature-name">{{ auth()->user()->name }}</p>
                <p class="signature-title">{{ config('app.name') }} Team</p>
            </div>
            
            <div class="contact-info">
                <p>Contact us: <a href="mailto:support@example.com">support@example.com</a> | <a href="tel:+1234567890">+1 (234) 567-890</a></p>
                <div class="social-links">
                    <a href="#" class="social-link">LinkedIn</a>
                    <a href="#" class="social-link">Twitter</a>
                    <a href="#" class="social-link">Facebook</a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>{{ config('app.name') }} - Professional CRM Solutions</p>
        </div>
    </div>
</body>
</html>
