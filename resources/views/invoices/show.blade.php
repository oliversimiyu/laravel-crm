@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Invoice Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                    Back to Invoices
                </a>
                <a href="{{ route('invoices.edit', $invoice) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('invoices.pdf', $invoice) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" target="_blank">
                    Download PDF
                </a>
                @if($invoice->status === 'draft' || $invoice->status === 'sent')
                <a href="{{ route('invoices.send.form', $invoice) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Send Email
                </a>
                @endif
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold text-white mb-4">Invoice Information</h2>
                    <div class="space-y-2">
                        <p class="text-gray-300"><span class="font-medium">Invoice Number:</span> {{ $invoice->invoice_number }}</p>
                        <p class="text-gray-300"><span class="font-medium">Issue Date:</span> {{ $invoice->issue_date->format('F j, Y') }}</p>
                        <p class="text-gray-300"><span class="font-medium">Due Date:</span> {{ $invoice->due_date->format('F j, Y') }}</p>
                        <p class="text-gray-300">
                            <span class="font-medium">Status:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $invoice->status === 'draft' ? 'bg-gray-600 text-gray-300' : '' }}
                                {{ $invoice->status === 'sent' ? 'bg-blue-600 text-blue-100' : '' }}
                                {{ $invoice->status === 'paid' ? 'bg-green-600 text-green-100' : '' }}
                                {{ $invoice->status === 'overdue' ? 'bg-red-600 text-red-100' : '' }}
                                {{ $invoice->status === 'cancelled' ? 'bg-gray-500 text-gray-100' : '' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </p>
                        @if($invoice->status === 'paid')
                        <p class="text-gray-300"><span class="font-medium">Payment Date:</span> {{ $invoice->payment_date->format('F j, Y') }}</p>
                        <p class="text-gray-300"><span class="font-medium">Payment Method:</span> {{ $invoice->payment_method }}</p>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-semibold text-white mb-4">Customer Information</h2>
                    <div class="space-y-2">
                        <p class="text-gray-300"><span class="font-medium">Name:</span> {{ $invoice->customer->full_name }}</p>
                        <p class="text-gray-300"><span class="font-medium">Email:</span> {{ $invoice->customer->email }}</p>
                        <p class="text-gray-300"><span class="font-medium">Phone:</span> {{ $invoice->customer->phone }}</p>
                        <p class="text-gray-300"><span class="font-medium">Address:</span> {{ $invoice->customer->address }}</p>
                        <p class="text-gray-300"><span class="font-medium">Company:</span> {{ $invoice->customer->company_name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
            <h2 class="text-lg font-semibold text-white p-6 pb-3">Invoice Items</h2>
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
                    @foreach($invoice->items as $item)
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
                            KES {{ number_format($invoice->subtotal, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            Tax ({{ number_format($invoice->tax_rate, 2) }}%):
                        </td>
                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            KES {{ number_format($invoice->tax_amount, 2) }}
                        </td>
                    </tr>
                    @if($invoice->discount_amount > 0)
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            Discount:
                        </td>
                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-300">
                            KES {{ number_format($invoice->discount_amount, 2) }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-sm font-bold text-white">
                            Total:
                        </td>
                        <td class="px-6 py-3 text-right text-sm font-bold text-white">
                            KES {{ number_format($invoice->total, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($invoice->notes)
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-white mb-2">Notes</h2>
            <p class="text-gray-300">{{ $invoice->notes }}</p>
        </div>
        @endif

        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Mark as Paid</h2>
            <form action="{{ route('invoices.mark-as-paid', $invoice) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-1">Payment Method</label>
                        <select name="payment_method" id="payment_method" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Mobile Money">Mobile Money</option>
                            <option value="Check">Check</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-300 mb-1">Payment Date</label>
                        <input type="date" name="payment_date" id="payment_date" required value="{{ date('Y-m-d') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Mark as Paid
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
