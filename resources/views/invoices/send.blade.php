@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Send Invoice</h1>
            <a href="{{ route('invoices.show', $invoice) }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                Back to Invoice
            </a>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-white mb-2">Invoice Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-300"><span class="font-medium">Invoice Number:</span> {{ $invoice->invoice_number }}</p>
                        <p class="text-gray-300"><span class="font-medium">Customer:</span> {{ $invoice->customer->full_name }}</p>
                        <p class="text-gray-300"><span class="font-medium">Issue Date:</span> {{ $invoice->issue_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-300"><span class="font-medium">Due Date:</span> {{ $invoice->due_date->format('M d, Y') }}</p>
                        <p class="text-gray-300"><span class="font-medium">Status:</span> {{ ucfirst($invoice->status) }}</p>
                        <p class="text-gray-300"><span class="font-medium">Total Amount:</span> KES {{ number_format($invoice->total, 2) }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('invoices.send', $invoice) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $invoice->customer->email) }}" 
                           class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-300 mb-1">Email Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject', 'Invoice #' . $invoice->invoice_number . ' from Laravel CRM') }}" 
                           class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-300 mb-1">Email Message</label>
                    <textarea name="message" id="message" rows="6" 
                              class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message', "Dear " . $invoice->customer->full_name . ",\n\nPlease find attached the invoice #" . $invoice->invoice_number . " for KES " . number_format($invoice->total, 2) . ".\n\nThe invoice is due on " . $invoice->due_date->format('F j, Y') . ".\n\nIf you have any questions, please don't hesitate to contact us.\n\nThank you for your business.") }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="attach_pdf" id="attach_pdf" value="1" checked 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-600 rounded bg-gray-700">
                        <label for="attach_pdf" class="ml-2 block text-sm text-gray-300">
                            Attach PDF
                        </label>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Send Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
