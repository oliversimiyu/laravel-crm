@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Edit Sale</h1>
                <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Back to Sales
                </a>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('sales.update', $sale) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Invoice Number -->
                            <div>
                                <label for="invoice_number" class="block text-sm font-medium text-gray-300">Invoice Number</label>
                                <input id="invoice_number" name="invoice_number" type="text" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('invoice_number', $sale->invoice_number) }}" required autofocus>
                                @error('invoice_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Customer -->
                            <div>
                                <label for="customer_id" class="block text-sm font-medium text-gray-300">Customer</label>
                                <select id="customer_id" name="customer_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->company->name ?? 'No Company' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-300">Amount (KES)</label>
                                <input id="amount" name="amount" type="number" step="0.01" min="0" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('amount', $sale->amount) }}" required>
                                @error('amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-300">Date</label>
                                <input id="date" name="date" type="date" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('date', $sale->date ? $sale->date->format('Y-m-d') : '') }}" required>
                                @error('date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Status</option>
                                    <option value="Pending" {{ old('status', $sale->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Paid" {{ old('status', $sale->status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="Overdue" {{ old('status', $sale->status) == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                                    <option value="Cancelled" {{ old('status', $sale->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-300">Payment Method</label>
                                <input id="payment_method" name="payment_method" type="text" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('payment_method', $sale->payment_method) }}" required>
                                @error('payment_method')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-300">Notes</label>
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">{{ old('notes', $sale->notes) }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Update Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
