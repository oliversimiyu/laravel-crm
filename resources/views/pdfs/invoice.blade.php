<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 5px;
        }
        .company-details {
            margin-bottom: 30px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .customer-details {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2d3748;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
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
            width: 300px;
            float: right;
            margin-bottom: 30px;
        }
        .totals table {
            width: 100%;
        }
        .notes {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .status-draft {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        .status-sent {
            background-color: #cce5ff;
            color: #004085;
        }
        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }
        .status-overdue {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="invoice-title">INVOICE</div>
            <div>{{ $invoice->invoice_number }}</div>
        </div>
        
        <div class="company-details">
            <div class="section-title">FROM</div>
            <div>Laravel CRM</div>
            <div>123 Business Street</div>
            <div>Nairobi, Kenya</div>
            <div>Email: info@laravelcrm.com</div>
            <div>Phone: +254 700 000000</div>
        </div>
        
        <div class="customer-details">
            <div class="section-title">BILL TO</div>
            <div>{{ $invoice->customer->full_name }}</div>
            <div>{{ $invoice->customer->company_name }}</div>
            <div>{{ $invoice->customer->address }}</div>
            <div>{{ $invoice->customer->city }}, {{ $invoice->customer->country }}</div>
            <div>Email: {{ $invoice->customer->email }}</div>
            <div>Phone: {{ $invoice->customer->phone }}</div>
        </div>
        
        <div class="invoice-details">
            <table>
                <tr>
                    <td><strong>Invoice Date:</strong></td>
                    <td>{{ $invoice->issue_date->format('F j, Y') }}</td>
                    <td><strong>Status:</strong></td>
                    <td>
                        <span class="status status-{{ $invoice->status }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Due Date:</strong></td>
                    <td>{{ $invoice->due_date->format('F j, Y') }}</td>
                    @if($invoice->status == 'paid')
                    <td><strong>Payment Date:</strong></td>
                    <td>{{ $invoice->payment_date->format('F j, Y') }}</td>
                    @else
                    <td></td>
                    <td></td>
                    @endif
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
                @foreach($invoice->items as $item)
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
                    <td class="text-right">KES {{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Tax ({{ number_format($invoice->tax_rate, 2) }}%):</strong></td>
                    <td class="text-right">KES {{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                @if($invoice->discount_amount > 0)
                <tr>
                    <td><strong>Discount:</strong></td>
                    <td class="text-right">KES {{ number_format($invoice->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Total:</strong></td>
                    <td class="text-right"><strong>KES {{ number_format($invoice->total, 2) }}</strong></td>
                </tr>
                @if($invoice->status == 'paid')
                <tr>
                    <td><strong>Payment Method:</strong></td>
                    <td class="text-right">{{ $invoice->payment_method }}</td>
                </tr>
                @endif
            </table>
        </div>
        
        @if($invoice->notes)
        <div class="notes">
            <div class="section-title">NOTES</div>
            <div>{{ $invoice->notes }}</div>
        </div>
        @endif
        
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>&copy; {{ date('Y') }} Laravel CRM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
