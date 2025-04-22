<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quote {{ $quote->quote_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            color: #2d3748;
            margin-bottom: 20px;
        }
        .quote-details {
            margin-bottom: 20px;
        }
        .quote-details p {
            margin: 5px 0;
        }
        .message {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9em;
        }
        .button {
            display: inline-block;
            background-color: #4a5568;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Quote {{ $quote->quote_number }}</h1>
        </div>
        
        <p>Dear {{ $customerName }},</p>
        
        <div class="message">
            @if(is_string($message))
                {!! nl2br(e($message)) !!}
            @else
                <!-- No message provided -->
            @endif
        </div>
        
        <div class="quote-details">
            <p><strong>Quote Number:</strong> {{ $quote->quote_number }}</p>
            <p><strong>Issue Date:</strong> {{ $quote->issue_date->format('F j, Y') }}</p>
            <p><strong>Expiry Date:</strong> {{ $quote->expiry_date->format('F j, Y') }}</p>
            <p><strong>Total Amount:</strong> KES {{ number_format($quote->total, 2) }}</p>
        </div>
        
        <p>Please find the attached quote for your reference.</p>
        
        <p>If you have any questions or would like to discuss this quote further, please don't hesitate to contact us.</p>
        
        <p>Thank you for considering our services!</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Oliver's Laravel CRM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
