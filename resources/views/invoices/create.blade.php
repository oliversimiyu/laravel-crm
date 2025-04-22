@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Create Invoice</h1>
            <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                Back to Invoices
            </a>
        </div>

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-lg font-semibold text-white mb-4">Invoice Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="invoice_number" class="block text-sm font-medium text-gray-300 mb-1">Invoice Number</label>
                        <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', $invoice_number) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('invoice_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-300 mb-1">Customer</label>
                        <select name="customer_id" id="customer_id" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->full_name }} ({{ $customer->company_name }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="issue_date" class="block text-sm font-medium text-gray-300 mb-1">Issue Date</label>
                        <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('issue_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-300 mb-1">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('due_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="tax_rate" class="block text-sm font-medium text-gray-300 mb-1">Tax Rate (%)</label>
                        <input type="number" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', 16) }}" min="0" max="100" step="0.01"
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('tax_rate')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="discount_amount" class="block text-sm font-medium text-gray-300 mb-1">Discount Amount</label>
                        <input type="number" name="discount_amount" id="discount_amount" value="{{ old('discount_amount', 0) }}" min="0" step="0.01"
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('discount_amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-white">Invoice Items</h2>
                    <button type="button" id="add-item" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Add Item
                    </button>
                </div>
                
                <div id="items-container">
                    <div class="item-row mb-4 pb-4 border-b border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-2">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                                <input type="text" name="items[0][description]" required
                                       class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Quantity</label>
                                <input type="number" name="items[0][quantity]" value="1" min="0.01" step="0.01" required
                                       class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 item-quantity">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Unit Price</label>
                                <input type="number" name="items[0][unit_price]" value="0" min="0" step="0.01" required
                                       class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 item-price">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Tax Rate (%)</label>
                                <input type="number" name="items[0][tax_rate]" value="16" min="0" max="100" step="0.01"
                                       class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 item-tax">
                            </div>
                            <div class="md:col-span-2 flex items-end justify-end">
                                <button type="button" class="remove-item px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                @error('items')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemCount = 1;
        
        // Add item
        document.getElementById('add-item').addEventListener('click', function() {
            const container = document.getElementById('items-container');
            const newRow = document.createElement('div');
            newRow.className = 'item-row mb-4 pb-4 border-b border-gray-700';
            
            newRow.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-2">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                        <input type="text" name="items[${itemCount}][description]" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Quantity</label>
                        <input type="number" name="items[${itemCount}][quantity]" value="1" min="0.01" step="0.01" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 item-quantity">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Unit Price</label>
                        <input type="number" name="items[${itemCount}][unit_price]" value="0" min="0" step="0.01" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 item-price">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Tax Rate (%)</label>
                        <input type="number" name="items[${itemCount}][tax_rate]" value="16" min="0" max="100" step="0.01"
                               class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 item-tax">
                    </div>
                    <div class="md:col-span-2 flex items-end justify-end">
                        <button type="button" class="remove-item px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                            Remove
                        </button>
                    </div>
                </div>
            `;
            
            container.appendChild(newRow);
            itemCount++;
            
            // Add event listener to the new remove button
            newRow.querySelector('.remove-item').addEventListener('click', function() {
                container.removeChild(newRow);
            });
        });
        
        // Remove item (for the initial row)
        document.querySelector('.remove-item').addEventListener('click', function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                this.closest('.item-row').remove();
            }
        });
    });
</script>
@endpush
@endsection
