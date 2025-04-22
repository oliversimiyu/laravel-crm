@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Quote Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('quotes.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                    Back to Quotes
                </a>
                <a href="{{ route('quotes.edit', $quote) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('quotes.pdf', $quote) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" target="_blank">
                    Download PDF
                </a>
                @if($quote->status === 'draft' || $quote->status === 'sent')
                <a href="{{ route('quotes.send.form', $quote) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Send Email
                </a>
                @endif
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold text-white mb-4">Quote Information</h2>
                    <div class="space-y-2">
                        <p class="text-gray-300"><span class="font-medium">Quote Number:</span> {{ $quote->quote_number }}</p>
                        <p class="text-gray-300"><span class="font-medium">Issue Date:</span> {{ $quote->issue_date->format('F j, Y') }}</p>
                        <p class="text-gray-300"><span class="font-medium">Expiry Date:</span> {{ $quote->expiry_date->format('F j, Y') }}</p>
                        <p class="text-gray-300">
                            <span class="font-medium">Status:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $quote->status === 'draft' ? 'bg-gray-600 text-gray-300' : '' }}
                                {{ $quote->status === 'sent' ? 'bg-blue-600 text-blue-100' : '' }}
                                {{ $quote->status === 'accepted' ? 'bg-green-600 text-green-100' : '' }}
                                {{ $quote->status === 'rejected' ? 'bg-red-600 text-red-100' : '' }}
                                {{ $quote->status === 'expired' ? 'bg-yellow-600 text-yellow-100' : '' }}">
                                {{ ucfirst($quote->status) }}
                            </span>
                        </p>
                        <p class="text-gray-300"><span class="font-medium">Valid For:</span> {{ $quote->issue_date->diffInDays($quote->expiry_date) }} days</p>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-semibold text-white mb-4">Customer Information</h2>
                    <div class="space-y-2">
                        <p class="text-gray-300"><span class="font-medium">Name:</span> {{ $quote->customer->full_name }}</p>
                        <p class="text-gray-300"><span class="font-medium">Email:</span> {{ $quote->customer->email }}</p>
                        <p class="text-gray-300"><span class="font-medium">Phone:</span> {{ $quote->customer->phone }}</p>
                        <p class="text-gray-300"><span class="font-medium">Address:</span> {{ $quote->customer->address }}</p>
                        <p class="text-gray-300"><span class="font-medium">Company:</span> {{ $quote->customer->company_name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
            <h2 class="text-lg font-semibold text-white p-6 pb-3">Quote Items</h2>
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Unit Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Tax Rate
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Tax Amount
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach($quote->items as $item)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-300">
                                {{ $item->description }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                {{ number_format($item->quantity, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                KES {{ number_format($item->unit_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                {{ number_format($item->tax_rate, 2) }}%
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                KES {{ number_format($item->tax_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                KES {{ number_format($item->total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-700">
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            Subtotal:
                        </td>
                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            KES {{ number_format($quote->subtotal, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            Tax ({{ number_format($quote->tax_rate, 2) }}%):
                        </td>
                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            KES {{ number_format($quote->tax_amount, 2) }}
                        </td>
                    </tr>
                    @if($quote->discount_amount > 0)
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            Discount:
                        </td>
                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            KES {{ number_format($quote->discount_amount, 2) }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-sm font-bold text-white">
                            Total:
                        </td>
                        <td class="px-6 py-3 text-right text-sm font-bold text-white">
                            KES {{ number_format($quote->total, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($quote->notes)
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-white mb-2">Notes</h2>
            <p class="text-gray-300">{{ $quote->notes }}</p>
        </div>
        @endif

        @if($quote->status !== 'accepted' && $quote->status !== 'rejected' && !$quote->isExpired())
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Convert to Invoice</h2>
            <p class="text-gray-300 mb-4">
                Convert this quote to an invoice when the customer accepts it. This will create a new invoice with all the details from this quote.
            </p>
            <form action="{{ route('quotes.convert', $quote) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="return confirm('Are you sure you want to convert this quote to an invoice?')">
                    Convert to Invoice
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
