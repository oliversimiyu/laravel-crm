<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quote {{ $quote->quote_number }}</title>
    <style>
        @page {
            margin: 0.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.3;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .quote-title {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 3px;
        }
        .company-details {
            margin-bottom: 15px;
        }
        .quote-details {
            margin-bottom: 10px;
        }
        .customer-details {
            margin-bottom: 15px;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
            color: #2d3748;
            border-bottom: 1px solid #ddd;
            padding-bottom: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            padding: 4px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            width: 250px;
            float: right;
            margin-bottom: 15px;
        }
        .totals table {
            width: 100%;
        }
        .notes {
            clear: both;
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
        }
        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            color: #6c757d;
        }
        .status {
            display: inline-block;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
        .status-draft {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        .status-sent {
            background-color: #cce5ff;
            color: #004085;
        }
        .status-accepted {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-expired {
            background-color: #ffeeba;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="quote-title">QUOTE</div>
            <div>{{ $quote->quote_number }}</div>
        </div>
        
        <div class="company-details">
            <div class="section-title">FROM</div>
            <div>Oliver's Laravel CRM</div>
            <div>123 Business Street</div>
            <div>Nairobi, Kenya</div>
            <div>Email: oliver@laravelcrm.com</div>
            <div>Phone: +254 700 000000</div>
        </div>
        
        <div class="customer-details">
            <div class="section-title">FOR</div>
            <div>{{ $quote->customer->full_name }}</div>
            <div>{{ $quote->customer->company_name }}</div>
            <div>{{ $quote->customer->address }}</div>
            <div>{{ $quote->customer->city }}, {{ $quote->customer->country }}</div>
            <div>Email: {{ $quote->customer->email }}</div>
            <div>Phone: {{ $quote->customer->phone }}</div>
        </div>
        
        <div class="quote-details">
            <table>
                <tr>
                    <td><strong>Quote Date:</strong></td>
                    <td>{{ $quote->issue_date->format('F j, Y') }}</td>
                    <td><strong>Status:</strong></td>
                    <td>
                        <span class="status status-{{ $quote->status }}">
                            {{ ucfirst($quote->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Expiry Date:</strong></td>
                    <td>{{ $quote->expiry_date->format('F j, Y') }}</td>
                    <td><strong>Valid For:</strong></td>
                    <td>{{ $quote->issue_date->diffInDays($quote->expiry_date) }} days</td>
                </tr>
            </table>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Tax Rate</th>
                    <th class="text-right">Tax Amount</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 2) }}</td>
                    <td class="text-right">KES {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->tax_rate, 2) }}%</td>
                    <td class="text-right">KES {{ number_format($item->tax_amount, 2) }}</td>
                    <td class="text-right">KES {{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="totals">
            <table>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td class="text-right">KES {{ number_format($quote->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Tax ({{ number_format($quote->tax_rate, 2) }}%):</strong></td>
                    <td class="text-right">KES {{ number_format($quote->tax_amount, 2) }}</td>
                </tr>
                @if($quote->discount_amount > 0)
                <tr>
                    <td><strong>Discount:</strong></td>
                    <td class="text-right">KES {{ number_format($quote->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Total:</strong></td>
                    <td class="text-right"><strong>KES {{ number_format($quote->total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
        
        @if($quote->notes)
        <div class="notes">
            <div class="section-title">NOTES</div>
            <div>{{ $quote->notes }}</div>
        </div>
        @endif
        
        <div class="footer">
            <p>Thank you for considering our services!</p>
            <p>&copy; {{ date('Y') }} Oliver's Laravel CRM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
