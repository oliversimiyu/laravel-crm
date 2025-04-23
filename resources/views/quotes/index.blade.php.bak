@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Quotes</h1>
            <a href="{{ route('quotes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Create Quote
            </a>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <form action="{{ route('quotes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Quote #, customer...">
                </div>
                
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-300 mb-1">Customer</label>
                    <select name="customer_id" id="customer_id" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                    <select name="status" id="status" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                        Filter
                    </button>
                    <a href="{{ route('quotes.index') }}" class="ml-2 px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Quote #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Issue Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Expiry Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($quotes as $quote)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $quote->quote_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $quote->customer->full_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $quote->issue_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $quote->expiry_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                KES {{ number_format($quote->total, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $quote->status === 'draft' ? 'bg-gray-600 text-gray-300' : '' }}
                                    {{ $quote->status === 'sent' ? 'bg-blue-600 text-blue-100' : '' }}
                                    {{ $quote->status === 'accepted' ? 'bg-green-600 text-green-100' : '' }}
                                    {{ $quote->status === 'rejected' ? 'bg-red-600 text-red-100' : '' }}
                                    {{ $quote->status === 'expired' ? 'bg-yellow-600 text-yellow-100' : '' }}">
                                    {{ ucfirst($quote->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('quotes.show', $quote) }}" class="text-blue-400 hover:text-blue-300">
                                        View
                                    </a>
                                    <a href="{{ route('quotes.edit', $quote) }}" class="text-yellow-400 hover:text-yellow-300">
                                        Edit
                                    </a>
                                    <a href="{{ route('quotes.pdf', $quote) }}" class="text-green-400 hover:text-green-300" target="_blank">
                                        PDF
                                    </a>
                                    <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this quote?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
                                No quotes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="px-6 py-4 bg-gray-800">
                {{ $quotes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
