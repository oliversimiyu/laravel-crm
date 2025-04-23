<div wire:poll="{{ $pollingInterval }}ms" class="py-8">
    {{-- The whole world belongs to you. --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Quotes</h1>
            <a href="{{ route('quotes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Create Quote
            </a>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Search</label>
                    <input type="text" wire:model.debounce.300ms="search" id="search" 
                           class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Quote #, customer...">
                </div>
                
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-300 mb-1">Customer</label>
                    <select wire:model="customer_id" id="customer_id" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->first_name }} {{ $customer->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                    <select wire:model="status" id="status" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="draft">Draft</option>
                        <option value="sent">Sent</option>
                        <option value="accepted">Accepted</option>
                        <option value="declined">Declined</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button wire:click="$refresh" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
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
                                {{ $quote->customer->first_name }} {{ $quote->customer->last_name }}
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($quote->status == 'draft') bg-gray-600 text-gray-100
                                    @elseif($quote->status == 'sent') bg-blue-600 text-blue-100
                                    @elseif($quote->status == 'accepted') bg-green-600 text-green-100
                                    @elseif($quote->status == 'declined') bg-red-600 text-red-100
                                    @elseif($quote->status == 'expired') bg-yellow-600 text-yellow-100
                                    @endif">
                                    {{ ucfirst($quote->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('quotes.show', $quote) }}" class="text-blue-400 hover:text-blue-300">View</a>
                                    <a href="{{ route('quotes.edit', $quote) }}" class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                    <a href="{{ route('quotes.pdf', $quote) }}" target="_blank" class="text-purple-400 hover:text-purple-300">PDF</a>
                                    <a href="{{ route('quotes.send.form', $quote) }}" class="text-green-400 hover:text-green-300">Send</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                                No quotes found
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
