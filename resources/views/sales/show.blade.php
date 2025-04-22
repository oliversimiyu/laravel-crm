@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Sale Details</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('sales.edit', $sale) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Edit Sale
                    </a>
                    <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Back to Sales
                    </a>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-300">Invoice Information</h3>
                                <div class="mt-2 p-4 bg-gray-700 rounded-lg">
                                    <div class="grid grid-cols-1 gap-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Invoice Number:</span>
                                            <span class="text-white font-medium">{{ $sale->invoice_number }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Date:</span>
                                            <span class="text-white font-medium">{{ $sale->date ? $sale->date->format('M d, Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Amount:</span>
                                            <span class="text-white font-medium">KES {{ number_format($sale->amount, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Status:</span>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($sale->status == 'Paid') bg-green-100 text-green-800
                                                @elseif($sale->status == 'Pending') bg-yellow-100 text-yellow-800
                                                @elseif($sale->status == 'Overdue') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ $sale->status }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Payment Method:</span>
                                            <span class="text-white font-medium">{{ $sale->payment_method }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-300">Customer Information</h3>
                                <div class="mt-2 p-4 bg-gray-700 rounded-lg">
                                    <div class="grid grid-cols-1 gap-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Name:</span>
                                            <span class="text-white font-medium">
                                                <a href="{{ route('customers.show', $sale->customer) }}" class="text-blue-400 hover:underline">
                                                    {{ $sale->customer->first_name }} {{ $sale->customer->last_name }}
                                                </a>
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Email:</span>
                                            <span class="text-white font-medium">{{ $sale->customer->email }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Phone:</span>
                                            <span class="text-white font-medium">{{ $sale->customer->phone }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-400">Company:</span>
                                            <span class="text-white font-medium">{{ $sale->customer->company->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($sale->notes)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-300">Notes</h3>
                        <div class="mt-2 p-4 bg-gray-700 rounded-lg">
                            <p class="text-white whitespace-pre-line">{{ $sale->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="mt-8 border-t border-gray-700 pt-6">
                        <form method="POST" action="{{ route('sales.destroy', $sale) }}" onsubmit="return confirm('Are you sure you want to delete this sale?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Delete Sale
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
